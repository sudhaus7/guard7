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

namespace Sudhaus7\Guard7\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

final class Data extends AbstractEntity
{

    /**
     * Tablename
     */
    private ?string $tablename = null;

    /**
     * Tableuid
     */
    private ?string $tableuid = null;

    /**
     * Fieldname
     */
    private ?string $fieldname = null;

    /**
     * Secretdata
     */
    private ?string $secretdata = null;

    /**
     * Needsreencode
     */
    private ?string $needsreencode = null;

    /**
     * Returns the Tablename
     *
     * @return string|null $tablename
     */
    public function getTablename(): ?string
    {
        return $this->tablename;
    }

    /**
     * Sets the Tablename
     */
    public function setTablename(string $tablename): void
    {
        $this->tablename = $tablename;
    }

    /**
     * Returns the Tableuid
     *
     * @return string|null $tableuid
     */
    public function getTableuid(): ?string
    {
        return $this->tableuid;
    }

    /**
     * Sets the Tableuid
     */
    public function setTableuid(string $tableuid): void
    {
        $this->tableuid = $tableuid;
    }

    /**
     * Returns the Fieldname
     *
     * @return string|null $fieldname
     */
    public function getFieldname(): ?string
    {
        return $this->fieldname;
    }

    /**
     * Sets the Fieldname
     */
    public function setFieldname(string $fieldname): void
    {
        $this->fieldname = $fieldname;
    }

    /**
     * Returns the Secretdata
     *
     * @return string|null $secretdata
     */
    public function getSecretdata(): ?string
    {
        return $this->secretdata;
    }

    /**
     * Sets the Secretdata
     */
    public function setSecretdata(string $secretdata): void
    {
        $this->secretdata = $secretdata;
    }

    /**
     * Returns the Needsreencode
     *
     * @return string|null $needsreencode
     */
    public function getNeedsreencode(): ?string
    {
        return $this->needsreencode;
    }

    /**
     * Sets the Needsreencode
     */
    public function setNeedsreencode(string $needsreencode): void
    {
        $this->needsreencode = $needsreencode;
    }
}
