<?php

namespace Ivoba\OxidSiteMap\Query;

use Ivoba\OxidSiteMap\Entity\Page;

abstract class AbstractQuery implements QueryInterface
{

    protected $db;
    protected $siteUrl;
    protected $hierachy;
    protected $changefreq;

    abstract public function getSql();

    /**
     * @param \oxLegacyDb $db
     * @param $siteUrl
     * @param $hierachy
     * @param $changefreq
     */
    public function __construct(\oxLegacyDb $db, $siteUrl, $hierachy, $changefreq)
    {
        $this->db = $db;
        $this->siteUrl = $siteUrl;
        $this->hierachy = $hierachy;
        $this->changefreq = $changefreq;
    }

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

    protected function createPage($result)
    {
        $url = $result->fields['oxseourl'];
        if (empty($url)) {
            $url = $result->fields['oxstdurl'];
        }

        return new Page(
            $this->siteUrl.'/'.$url,
            $this->hierachy,
            date('Y').'-'.date('m').'-'.date('d').'T'.date('h').':'.date('i').':'.date('s').'+00:00',
            $this->changefreq
        );
    }
}