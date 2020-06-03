<?php

namespace IvobaOxid\OxidSiteMap\Query;

use IvobaOxid\OxidSiteMap\Entity\Config;
use IvobaOxid\OxidSiteMap\Entity\Page;

class HomePage implements QueryInterface
{
    protected $hierachy;
    protected $changefreq;
    protected $config;

    /**
     * HomePage constructor.
     * @param Config $config
     * @param $hierachy
     * @param $changefreq
     */
    public function __construct(Config $config, $hierachy, $changefreq)
    {
        $this->config = $config;
        $this->hierachy = $hierachy;
        $this->changefreq = $changefreq;
    }

    /**
     * @inheritdoc
     */
    public function getPages()
    {
        return [
            new Page(
                $this->config->getShopUrl(),
                $this->hierachy,
                date('Y').'-'.date('m').'-'.date('d').'T'.date('h').':'.date('i').':'.date('s').'+00:00',
                $this->changefreq
            )
        ];
    }
}
