<?php

namespace IvobaOxid\OxidSiteMap\Query;

use Doctrine\DBAL\Query\QueryBuilder;
use IvobaOxid\OxidSiteMap\Entity\Page;
use OxidEsales\EshopCommunity\Application\Model\Article;

class Products extends AbstractQuery
{
    public function getQuery(QueryBuilder $queryBuilder): QueryBuilder
    {
        $queryBuilder
            ->select('oxid', 'oxtimestamp')
            ->from('oxarticles')
            ->where('oxactive = :active', 'oxparentid = ""')
            ->orderBy('oxtitle', 'ASC')
            ->setParameters(['active' => 1]);

        return $queryBuilder;
    }

    /**
     * @inheritdoc
     */
    protected function createPage($result)
    {
        $article = new Article();
        $article->load($result['oxid']);

        $time = explode(" ", $result['oxtimestamp']);

        return new Page(
            $article->getMainLink(),
            $this->hierarchy,
            $time[0] . 'T' . $time[1] . '+00:00',
            $this->changefreq
        );
    }
}
