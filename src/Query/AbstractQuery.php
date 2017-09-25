<?php

namespace Ivoba\OxidSiteMap\Query;

use Ivoba\OxidSiteMap\Entity\Config;
use Ivoba\OxidSiteMap\Entity\Page;

abstract class AbstractQuery implements QueryInterface
{

    protected $db;
    protected $siteUrl;
    protected $hierachy;
    protected $changefreq;
    protected $config;

    abstract public function getSql();

    /**
     * AbstractQuery constructor.
     * @param \oxLegacyDb $db
     * @param Config $config
     * @param $hierachy
     * @param $changefreq
     */
    public function __construct(\oxLegacyDb $db, Config $config, $hierachy, $changefreq)
    {
        $this->db = $db;
        $this->config = $config;
        $this->hierachy = $hierachy;
        $this->changefreq = $changefreq;
    }

    /**
     * @return array
     */
    public function getPages()
    {
        $pages = [];

        $result = $this->db->execute($this->getSql());
        if ($result !== false && $result->recordCount() > 0) {
            while (!$result->EOF) {
                $pages[] = $this->createPage($result);
                $result->MoveNext();
            }
        }

        return $pages;
    }

    /**
     * @param $result
     * @return Page
     */
    protected function createPage($result)
    {
        $url = $result->fields['oxseourl'];
        if (empty($url)) {
            $url = $result->fields['oxstdurl'];
        }

        return new Page(
            $this->config->getShopUrl().'/'.$url,
            $this->hierachy,
            date('Y').'-'.date('m').'-'.date('d').'T'.date('h').':'.date('i').':'.date('s').'+00:00',
            $this->changefreq
        );
    }
}