<?php

namespace IvobaOxid\OxidSiteMap\Query;

use Doctrine\DBAL\Query\QueryBuilder;

class Variants extends Products
{
    public function getQuery(QueryBuilder $queryBuilder): QueryBuilder
    {
        $queryBuilder
            ->select('oxarticles.oxid', 'oxarticles.oxtimestamp')
            ->from('oxarticles')
            ->leftJoin('oxarticles', 'oxarticles', 'oxparent', 'oxarticles.oxparentid = oxparent.oxid')
            ->where('oxarticles.oxactive = :active', 'oxarticles.oxparentid = :parent')
            ->andWhere('oxparent.oxactive = :active')
            ->orderBy('oxarticles.oxtitle', 'ASC')
            ->setParameters([
                'active' => 1,
                'parent' => '',
            ]);

        return $queryBuilder;
    }
}
