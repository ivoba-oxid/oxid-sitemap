<?php

namespace IvobaOxid\OxidSiteMap\Query;

use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Class Tags
 * @package IvobaOxid\OxidSiteMap\Query
 */
class Tags extends AbstractQuery
{
    public function getQuery(QueryBuilder $queryBuilder): QueryBuilder
    {
        $queryBuilder
            ->select('oxseourl')
            ->from('oxseo')
            ->where(
                "oxseourl <> ''",
                'oxstdurl LIKE :controller',
                'oxtype = :type',
                'oxexpired = 0'
            )
            ->andWhere('oxlang IN (:langIds)')
            ->setParameters([
                'controller' => '%%=oetagstagcontroller%%',
                'type'       => 'dynamic',
                'langIds'    => $this->config->getLangIds(),
            ]);

        return $queryBuilder;
    }
}
