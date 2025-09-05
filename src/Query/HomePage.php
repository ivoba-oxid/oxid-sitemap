<?php

namespace IvobaOxid\OxidSiteMap\Query;

use IvobaOxid\OxidSiteMap\Entity\Config;
use IvobaOxid\OxidSiteMap\Entity\Page;

class HomePage implements QueryInterface
{
    protected string $hierarchy;
    protected string $changefreq;
    protected Config $config;

    public function __construct(Config $config, string $hierarchy, string $changefreq)
    {
        $this->config = $config;
        $this->hierarchy = $hierarchy;
        $this->changefreq = $changefreq;
    }

    /**
     * @return array<   Page>
     */
    public function getPages(): array
    {
        return [
            new Page(
                $this->config->getShopUrl(),
                $this->hierarchy,
                (new \DateTime())->format(\DateTime::ATOM),
                $this->changefreq
            )
        ];
    }
}
