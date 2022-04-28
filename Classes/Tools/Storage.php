<?php

/*
 * This file is part of the TYPO3 project.
 * (c) 2022 B-Factor GmbH
 *          Sudhaus7
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 * The TYPO3 project - inspiring people to share!
 * @copyright 2022 B-Factor GmbH https://b-factor.de/
 * @author Frank Berger <fberger@b-factor.de>
 */

namespace Sudhaus7\Guard7\Tools;

use function base64_decode;
use Exception;
use function file_get_contents;
use function file_put_contents;
use function json_decode;
use function json_encode;
use function method_exists;
use PDO;
use function realpath;
use function sha1;
use function sha1_file;
use Sudhaus7\Guard7\Adapter\ConfigurationAdapter;
use Sudhaus7\Guard7\KeyNotReadableException;
use Sudhaus7\Guard7\SealException;
use SUDHAUS7\Guard7Core\Exceptions\MissingKeyException;
use SUDHAUS7\Guard7Core\Exceptions\UnlockException;
use SUDHAUS7\Guard7Core\Factory\KeyFactory;
use SUDHAUS7\Guard7Core\Tools\Decoder;
use SUDHAUS7\Guard7Core\Tools\Encoder;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Class Storage
 */
final class Storage
{
    /**
     * @var string
     */
    private const TX_GUARD7_SIGNATURES = 'tx_guard7_signatures';

    /**
     * @var string
     */
    private const PARENT = 'parent';

    /**
     * @var string
     */
    private const TX_GUARD7_DOMAIN_MODEL_DATA = 'tx_guard7_domain_model_data';

    /**
     * @var string
     */
    private const UID = 'uid';

    /**
     * @var string
     */
    private const TABLENAME = 'tablename';

    /**
     * @var string
     */
    private const TABLEUID = 'tableuid';

    /**
     * @var string
     */
    private const FIELDNAME = 'fieldname';

    /**
     * @var string
     */
    private const SECRETDATA = 'secretdata';

    /**
     * @param $signature
     */
    public static function markForReencode($signature): void
    {
        /** @var Connection $connection */
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable(self::TX_GUARD7_SIGNATURES);
        $res = $connection->select([self::PARENT], self::TX_GUARD7_SIGNATURES, ['signature' => $signature]);
        $list = $res->fetchAll(PDO::FETCH_ASSOC);
        foreach ($list as $row) {
            $connection->update(self::TX_GUARD7_DOMAIN_MODEL_DATA, ['needsreencode' => 1], [self::UID => $row[self::PARENT]]);
        }
    }

    /**
     * @param $tx_guard7_domain_model_data_uid
     * @param $pubkeys
     */
    public static function updateKeyLog($tx_guard7_domain_model_data_uid, $pubkeys): void
    {
        /** @var Connection $connection */
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable(self::TX_GUARD7_SIGNATURES);

        $connection->delete(self::TX_GUARD7_SIGNATURES, [self::PARENT => $tx_guard7_domain_model_data_uid]);
        foreach ($pubkeys as $checksum => $key) {
            $connection->insert(
                self::TX_GUARD7_SIGNATURES,
                [
                    self::PARENT => $tx_guard7_domain_model_data_uid,
                    'signature' => $checksum,
                ]
            );
        }
    }

    /**
     * @throws SealException
     * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Exception
     */
    public static function lockModel(AbstractEntity $obj, array $fields, array $pubKeys, $store = true): void
    {

        /** @var ConfigurationAdapter $configuration */
        $configuration = GeneralUtility::makeInstance(ConfigurationAdapter::class);

        $table = Helper::getModelTable($obj);

        /** @var Connection $connection */
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable($table);

        foreach ($fields as $fieldname) {
            $setter = 'set' . GeneralUtility::underscoredToUpperCamelCase($fieldname);
            $getter = 'get' . GeneralUtility::underscoredToUpperCamelCase($fieldname);
            if (method_exists($obj, $getter)) {
                $value = $obj->$getter();
                if (Helper::checkLockedValue($value) || empty($value)) {
                    continue;
                }

                $connection->delete(
                    self::TX_GUARD7_DOMAIN_MODEL_DATA,
                    [
                        self::TABLENAME => $table,
                        self::TABLEUID => $obj->getUid(),
                        self::FIELDNAME => $fieldname,
                    ]
                );
                $obj->$setter('&#128274;'); // 🔒

                $encoder = new Encoder($configuration, $pubKeys, $value);
                $encoded = $encoder->run();
                unset($encoder);

                $connection->insert(self::TX_GUARD7_DOMAIN_MODEL_DATA, [
                    self::TABLENAME => $table,
                    self::TABLEUID => $obj->getUid(),
                    self::FIELDNAME => $fieldname,
                    self::SECRETDATA => $encoded,
                ]);

                $insertid = $connection->lastInsertId();
                self::updateKeyLog($insertid, $pubKeys);
                $connection->update($table, [$fieldname => '&#128274;'], [self::UID => $obj->getUid()]);// 🔒
            }
        }
    }

    /**
     * @param $table
     * @param $uid
     * @param $fields
     * @param $data
     * @param $pubKeys
     * @return mixed
     * @throws SealException
     */
    public static function lockRecord($table, $uid, $fields, $data, $pubKeys)
    {
        /** @var ConfigurationAdapter $configuration */
        $configuration = GeneralUtility::makeInstance(ConfigurationAdapter::class);

        /** @var Connection $connection */
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable(self::TX_GUARD7_DOMAIN_MODEL_DATA);
        foreach ($data as $fieldname => $value) {
            if (in_array($fieldname, $fields)) {
                $data[$fieldname] = '&#128274;';
                if (Helper::checkLockedValue($value)) {
                    continue;
                }

                $fieldArray[$fieldname] = '&#128274;'; // 🔒
                $encoder = new Encoder($configuration, $pubKeys, $value);
                $encoded = $encoder->run();
                unset($encoder);

                $connection->delete(
                    self::TX_GUARD7_DOMAIN_MODEL_DATA,
                    [
                        self::TABLENAME => $table,
                        self::TABLEUID => $uid,
                        self::FIELDNAME => $fieldname,
                    ]
                );
                $connection->insert(self::TX_GUARD7_DOMAIN_MODEL_DATA, [
                    self::TABLENAME => $table,
                    self::TABLEUID => $uid,
                    self::FIELDNAME => $fieldname,
                    self::SECRETDATA => $encoded,
                ]);
                $insertid = $connection->lastInsertId();
                self::updateKeyLog($insertid, $pubKeys);
            }
        }

        return $data;
    }

    /**
     * @param AbstractEntity $obj
     * @param string|null $table
     * @param string|null $privateKey
     * @param string|null $password
     * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Exception
     */
    public static function unlockModel(AbstractEntity $obj, $table=null, string $privateKey=null, string $password = null): void
    {

        /** @var ConfigurationAdapter $configuration */
        $configuration = GeneralUtility::makeInstance(ConfigurationAdapter::class);
        $key = KeyFactory::readFromString($configuration, $privateKey, $password);

        if ($table===null) {
            $table = Helper::getModelTable($obj);
        }

        $uid = $obj->getUid();
        /** @var Connection $connection */
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable(self::TX_GUARD7_DOMAIN_MODEL_DATA);
        $res = $connection->select(
            ['*'],
            self::TX_GUARD7_DOMAIN_MODEL_DATA,
            [
                self::TABLENAME => $table,
                self::TABLEUID => $uid,
            ]
        );
        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
            $setter = 'set' . GeneralUtility::underscoredToUpperCamelCase($row[self::FIELDNAME]);
            $getter = 'get' . GeneralUtility::underscoredToUpperCamelCase($row[self::FIELDNAME]);
            if (method_exists($obj, $getter)) {
                $value = $obj->$getter();
                if (Helper::checkLockedValue($value)) {
                    try {
                        $newvalue = Decoder::decode($configuration, $key, $row[self::SECRETDATA]);
                        if (method_exists($obj, $setter)) {
                            $obj->$setter($newvalue);
                        }
                    } catch (Exception $exception) {
                        //$data[ $fieldname ] = '&#128274;';
                    }
                }
            }
        }
    }

    /**
     * @param string $table Tablename of the locked Record
     * @param array $data The locked data-row
     * @param string|null $privateKey
     * @param string|null $password
     * @throws MissingKeyException
     * @return mixed[]
     */
    public static function unlockRecord(string $table, array $data, string $privateKey=null, string $password = null, int $uid = 0): array
    {
        /** @var ConfigurationAdapter $configuration */
        $configuration = GeneralUtility::makeInstance(ConfigurationAdapter::class);
        $key = KeyFactory::readFromString($configuration, $privateKey, $password);

        if ($uid == 0) {
            $uid = $data[self::UID];
        }

        /** @var Connection $connection */
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable(self::TX_GUARD7_DOMAIN_MODEL_DATA);
        foreach ($data as $fieldname => $value) {
            if (Helper::checkLockedValue($value)) {
                $row = $connection->select(
                    [self::SECRETDATA],
                    self::TX_GUARD7_DOMAIN_MODEL_DATA,
                    [
                        self::TABLENAME => $table,
                        self::TABLEUID => $uid,
                        self::FIELDNAME => $fieldname,
                    ],
                    [],
                    [],
                    0,
                    1
                )
                    ->fetch(PDO::FETCH_ASSOC);
                if ($row && $row[self::SECRETDATA]) {
                    try {
                        $data[$fieldname] = Decoder::decode($configuration, $key, $row[self::SECRETDATA]);
                    } catch (UnlockException $unlockException) {
                        //$data[ $fieldname ] = '&#128274;';
                    }
                }
            }
        }

        return $data;
    }

    /**
     * @param $path
     * @return false|string|null
     */
    private static function sanitizePath($path)
    {
        str_replace('../', '', $path);
        $path = realpath($path);
        if (strpos($path, (string)(Environment::getPublicPath() . '/')) === 0) {
            return $path;
        }

        return null;
    }

    /**
     * @param $filepath
     * @param $pubKeys
     */
    public static function lockFile($filepath, $pubKeys): bool
    {
        $filepath = self::sanitizePath($filepath);
        if (is_file($filepath)) {
            try {
                $encoded = self::encodeFile($filepath, $pubKeys);
                if ($encoded !== null) {
                    //@unlink( $filepath );
                    file_put_contents($filepath, 'encoded');
                    file_put_contents($filepath . '.s7sec', $encoded);
                    return true;
                }
            } catch (Exception $exception) {
                return false;
            }
        }

        return false;
    }

    /**
     * @param $filepath
     * @param $privateKey
     * @param $password
     */
    public static function unlockFile($filepath, $privateKey, $password): bool
    {
        $filepath = self::sanitizePath($filepath) . '.s7sec';

        if (is_file($filepath)) {
            try {
                $data = self::decodeFile($filepath, $privateKey, $password);
                if ($data !== null) {
                    @unlink($filepath);
                    file_put_contents(
                        dirname($filepath) . '/' . $data['filename'],
                        base64_decode($data['secure'])
                    );
                    return true;
                }
            } catch (Exception $exception) {
                return false;
            }
        }

        return false;
    }

    /**
     * @param $filepath
     * @param $pubKeys
     * @return string|null
     * @throws SealException
     */
    public static function encodeFile($filepath, $pubKeys): ?string
    {
        /** @var ConfigurationAdapter $configuration */
        $configuration = GeneralUtility::makeInstance(ConfigurationAdapter::class);

        $filepath = self::sanitizePath($filepath);
        $encoded = null;
        if (is_file($filepath)) {
            $identifier = str_replace([
                Environment::getPublicPath() . '/',
                'fileadmin/',
            ], '', $filepath);

            $buf = file_get_contents($filepath);
            if ($buf === 'encoded') {
                throw new Exception('already encoded');
            }

            $data = [
                'checksum' => sha1_file($filepath),
                'secure' => base64_encode($buf),
                'filename' => basename($filepath),
                'identifier' => $identifier,
                'identifier_hash' => sha1($identifier),
            ];

            $encoder = new Encoder($configuration, $pubKeys, json_encode($data, JSON_THROW_ON_ERROR));
            $encoded = $encoder->run();
        }

        return $encoded;
    }

    /**
     * @param $filepath
     * @param $privatekey
     * @param null $password
     * @return mixed|null
     * @throws MissingKeyException
     * @throws UnlockException
     * @throws WrongKeyPassException
     * @throws KeyNotReadableException
     */
    public static function decodeFile($filepath, string $privatekey, string $password = null)
    {
        /** @var ConfigurationAdapter $configuration */
        $configuration = GeneralUtility::makeInstance(ConfigurationAdapter::class);
        $key = KeyFactory::readFromString($configuration, $privatekey, $password);
        $filepath = self::sanitizePath($filepath);
        $data = null;
        if (is_file($filepath)) {
            $enc = file_get_contents($filepath);
            $json = Decoder::decode($configuration, $key, $enc);
            $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        }

        return $data;
    }
}
