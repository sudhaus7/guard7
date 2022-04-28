<?php

declare(strict_types=1);

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

namespace Sudhaus7\Guard7\Hooks\Frontend;

use Exception;
use Sudhaus7\Guard7\Tools\Helper;
use Sudhaus7\Guard7\Tools\PrivatekeySingleton;
use Sudhaus7\Guard7\Tools\Storage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

final class AfterGettingObjectDataHandler
{

    /**
     * @param QueryInterface $query
     * @param $result
     * @return mixed[]
     */
    public function handle(QueryInterface $query, $result): array
    {
        $privateKey = GeneralUtility::makeInstance(PrivatekeySingleton::class);
        if ($privateKey->hasKey() && !empty($result)) {
            try {
                if (Helper::classIsGuard7Element($query->getType())) {
                    $table = Helper::getClassTable($query->getType());
                    foreach ($result as $idx=>$row) {
                        $result[$idx] = Storage::unlockRecord($table, $row, $privateKey->getKey());
                    }
                }
            } catch ( Exception $exception) {
                // ignore for now
            }
        }

        return [$query, $result];
    }
}
