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

namespace Sudhaus7\Guard7\Hooks\Backend;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\Query\Restriction\BackendWorkspaceRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Database\Query\QueryHelper;
use TYPO3\CMS\Backend\Utility\BackendUtility;

final class Guard7BackendUtility extends BackendUtility
{
    public static function getRecord($table, $uid, $fields = '*', $where = '', $useDeleteClause = true): ?array
    {
        return parent::getRecord($table, $uid, $fields, $where, $useDeleteClause);
    }

    public static function getRecordsByField($theTable, $theField, $theValue, $whereClause = '', $groupBy = '', $orderBy = '', $limit = '', $useDeleteClause = true, $queryBuilder = null)
    {
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(BackendWorkspaceRestriction::class));
        if ($useDeleteClause) {
            $queryBuilder->getRestrictions()->add(GeneralUtility::makeInstance(DeletedRestriction::class));
        }

        $queryBuilder->select('*')->from($theTable)->where($queryBuilder->expr()->eq($theField, $queryBuilder->createNamedParameter($theValue)));
        if ($whereClause) {
            $queryBuilder->andWhere(QueryHelper::stripLogicalOperatorPrefix($whereClause));
        }

        if ($groupBy !== '') {
            $queryBuilder->groupBy(QueryHelper::parseGroupBy($groupBy));
        }

        if ($orderBy !== '') {
            foreach (QueryHelper::parseOrderBy($orderBy) as $orderPair) {
                list($fieldName, $order) = $orderPair;
                $queryBuilder->addOrderBy($fieldName, $order);
            }
        }

        if ($limit !== '') {
            if (strpos($limit, ',')) {
                $limitOffsetAndMax = GeneralUtility::intExplode(',', $limit);
                $queryBuilder->setFirstResult((int) $limitOffsetAndMax[0]);
                $queryBuilder->setMaxResults((int) $limitOffsetAndMax[1]);
            } else {
                $queryBuilder->setMaxResults((int) $limit);
            }
        }

        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(BackendWorkspaceRestriction::class));
        if ($useDeleteClause) {
            $queryBuilder->getRestrictions()->add(GeneralUtility::makeInstance(DeletedRestriction::class));
        }

        $queryBuilder->select('*')->from($theTable)->where($queryBuilder->expr()->eq($theField, $queryBuilder->createNamedParameter($theValue)));
        if ($whereClause) {
            $queryBuilder->andWhere(QueryHelper::stripLogicalOperatorPrefix($whereClause));
        }

        if ($groupBy !== '') {
            $queryBuilder->groupBy(QueryHelper::parseGroupBy($groupBy));
        }

        if ($orderBy !== '') {
            foreach (QueryHelper::parseOrderBy($orderBy) as $orderPair) {
                list($fieldName, $order) = $orderPair;
                $queryBuilder->addOrderBy($fieldName, $order);
            }
        }

        if ($limit !== '') {
            if (strpos($limit, ',')) {
                $limitOffsetAndMax = GeneralUtility::intExplode(',', $limit);
                $queryBuilder->setFirstResult((int) $limitOffsetAndMax[0]);
                $queryBuilder->setMaxResults((int) $limitOffsetAndMax[1]);
            } else {
                $queryBuilder->setMaxResults((int) $limit);
            }
        }

        return $queryBuilder->execute()->fetchAll();
    }
}
