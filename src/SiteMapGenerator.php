<?php

namespace IvobaOxid\OxidSiteMap;

use IvobaOxid\OxidSiteMap\Entity\Config;
use IvobaOxid\OxidSiteMap\Filter\FilterInterface;
use IvobaOxid\OxidSiteMap\Query\QueryInterface;

/**
 * Class SiteMapGenerator
 * @package Ivoba\OxidSiteMap
 */
class SiteMapGenerator
{

    /**
     * @var Config
     */
    private $config;
    /**
     * @var array[QueryInterface]
     */
    private $queries;
    /**
     * @var bool
     */
    private $lowerUrls;
    /**
     * @var array[FilterInterface]
     */
    private $filters;

    /**
     * @param Config $config
     * @param array [QueryInterface] $queries
     * @param bool $lowerUrls
     * @param array [FilterInterface] $filters
     */
    public function __construct(Config $config, array $queries, $lowerUrls = false, array $filters = [])
    {
        $this->config = $config;
        foreach ($queries as $query) {
            $this->addQuery($query);
        }
        foreach ($filters as $filter) {
            $this->addFilter($filter);
        }
        $this->lowerUrls = $lowerUrls;
    }

    /**
     * @param QueryInterface $query
     */
    public function addQuery(QueryInterface $query)
    {
        $this->queries[] = $query;
    }

    /**
     * @param FilterInterface $filter
     */
    public function addFilter(FilterInterface $filter)
    {
        $this->filters[] = $filter;
    }


    /**
     * @param array [QueryInterface] $pages
     * @return string
     */
    protected function generateXml($pages)
    {
        $xmlLines = [];
        $xmlLines[] = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($pages as $page) {

            foreach ($this->filters as $filter) {
                if($filter->filter($page)){
                    continue 2;
                }
            }

            $url = $page->getUrl();
            if ($this->lowerUrls) {
                $url = strtolower($url);
            }

            $xmlLines[] = '<url><loc>'.$url.'</loc>
                            <priority>'.$page->getPriority().'</priority>
                            <lastmod>'.$page->getLastmod().'</lastmod>
                            <changefreq>'.$page->getChangefreq().'</changefreq></url>';
        }
        $xmlLines[] = '</urlset>';

        return implode('', $xmlLines);
    }

    /**
     * @param $xml
     */
    protected function createXmlFile($xml)
    {
        $file = $this->config->getFilepath().'/'.$this->config->getFilename();
        $fp = fopen($file, "w+");
        fwrite($fp, $xml);
        fclose($fp);
    }

    /**
     *
     */
    public function generate()
    {
        $pages = [];

        foreach ($this->queries as $query) {
            $pages = array_merge($pages, $query->getPages());
        }

        $this->createXmlFile($this->generateXml($pages));
    }
}
