<?php

namespace IvobaOxid\OxidSiteMap\Query;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\ForwardCompatibility\Result;
use IvobaOxid\OxidSiteMap\Entity\Config;
use IvobaOxid\OxidSiteMap\Entity\Page;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;

abstract class AbstractQuery implements QueryInterface
{
    protected QueryBuilderFactoryInterface $queryBuilderFactory;
    protected string $hierarchy;
    protected string $changefreq;
    protected Config $config;

    public function __construct(
        QueryBuilderFactoryInterface $queryBuilderFactory,
        Config $config,
        string $hierarchy,
        string $changefreq
    ) {
        $this->queryBuilderFactory = $queryBuilderFactory;
        $this->config              = $config;
        $this->hierarchy           = $hierarchy;
        $this->changefreq          = $changefreq;
    }

    abstract public function getQuery(QueryBuilder $queryBuilder): QueryBuilder;

    /**
     * @return array<Page>
     */
    public function getPages(): array
    {
        $pages  = [];
        $query  = $this->getQuery($this->queryBuilderFactory->create());
        $result = $query->execute();
        if ($result instanceof Result) {
            foreach ($result as $item) {
                $pages[] = $this->createPage($item);
            }
        }

        return $pages;
    }

    /**
     * @param array<string, mixed> $result
     */
    protected function createPage(array $result): Page
    {
        $url = $result['oxseourl'];
        if (empty($url)) {
            $url = $result['oxstdurl'];
        }

        return new Page(
            $this->config->getShopUrl() . $url,
            $this->hierarchy,
            (new \DateTime())->format(\DateTime::ATOM),
            $this->changefreq
        );
    }
}
