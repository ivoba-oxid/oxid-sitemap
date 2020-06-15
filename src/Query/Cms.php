<?php

namespace IvobaOxid\OxidSiteMap\Query;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Connection;

/**
 * Class Cms
 * @package IvobaOxid\OxidSiteMap\Query
 */
class Cms extends AbstractQuery
{
    public function getQuery(QueryBuilder $queryBuilder): QueryBuilder
    {
        $folders = ['CMSFOLDER_USERINFO', 'CMSFOLDER_PRODUCTINFO'];
        $queryBuilder
            ->select('oxid', 'oxtitle', 'oxseo.oxstdurl', 'oxseo.oxseourl')
            ->from('oxcontents')
            ->join('oxcontents', 'oxseo', 'oxseo', 'oxseo.OXOBJECTID = oxcontents.OXID')
            ->where('oxcontents.oxactive = :active')
            ->andWhere('oxcontents.oxfolder IN (:folders)')
            ->orderBy('oxcontents.oxtitle', 'ASC')
            ->setParameter('folders', $folders, Connection::PARAM_STR_ARRAY)
            ->setParameter('active', 1);

        return $queryBuilder;
    }
}
