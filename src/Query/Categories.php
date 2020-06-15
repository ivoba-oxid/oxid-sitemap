<?php

namespace IvobaOxid\OxidSiteMap\Query;

use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Class Categories
 * @package IvobaOxid\OxidSiteMap\Query
 */
class Categories extends AbstractQuery
{
    public function getQuery(QueryBuilder $queryBuilder): QueryBuilder
    {
        $queryBuilder->select('oxid', 'oxtitle', 'oxdesc', 'oxlongdesc', 'oxseo.oxstdurl', 'oxseo.oxseourl')
                     ->from('oxcategories')
                     ->join('oxcategories', 'oxseo', 'oxseo', 'oxseo.OXOBJECTID = oxcategories.OXID')
                     ->where('oxactive = :active', 'oxhidden = :hidden')
                     ->andWhere('oxlang IN (:langIds)')
                     ->orderBy('oxtitle', 'ASC')
                     ->setParameters([
                         'active'  => 1,
                         'hidden'  => 0,
                         'langIds' => $this->config->getLangIds(),
                     ]);

        return $queryBuilder;
    }
}
