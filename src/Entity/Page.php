<?php

namespace IvobaOxid\OxidSiteMap\Entity;


class Page
{

    private $url;
    private $priority;
    private $lastmod;
    private $changefreq;

    /**
     * Page constructor.
     * @param $url
     * @param $priority
     * @param $lastmod
     * @param $changefreq
     */
    public function __construct($url, $priority, $lastmod, $changefreq)
    {
        $this->url = $url;
        $this->priority = $priority;
        $this->lastmod = $lastmod;
        $this->changefreq = $changefreq;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @return mixed
     */
    public function getLastmod()
    {
        return $this->lastmod;
    }

    /**
     * @return mixed
     */
    public function getChangefreq()
    {
        return $this->changefreq;
    }

}
