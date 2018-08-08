<?php

namespace IvobaOxid\OxidSiteMap\Query;

use IvobaOxid\OxidSiteMap\Entity\Config;
use IvobaOxid\OxidSiteMap\Entity\Page;
use OxidEsales\Eshop\Core\Database\Adapter\DatabaseInterface;

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
     * @param DatabaseInterface $db
     * @param Config $config
     * @param $hierachy
     * @param $changefreq
     */
    public function __construct(DatabaseInterface $db, Config $config, $hierachy, $changefreq)
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

        $result = $this->db->select($this->getSql());
        if ($result !== false && $result->count() > 0) {
            while (!$result->EOF) {
                $pages[] = $this->createPage($result);
                $result->fetchRow();
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
