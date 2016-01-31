<?php

namespace Ivoba\OxidSiteMap;

use Ivoba\OxidSiteMap\Entity\Config;
use Ivoba\OxidSiteMap\Query\QueryInterface;

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
     * @param Config $config
     * @param array[QueryInterface] $queries
     */
    public function __construct(Config $config, array $queries)
    {
        $this->config = $config;
        foreach ($queries as $query) {
            $this->addQuery($query);
        }
    }

    /**
     * @param QueryInterface $query
     */
    public function addQuery(QueryInterface $query)
    {
        $this->queries[] = $query;
    }


    /**
     * @param array[QueryInterface] $pages
     * @return string
     */
    protected function generateXml($pages)
    {
        $xmlLines = [];
        $xmlLines[] = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($pages as $page) {
            $xmlLines[] = '<url><loc>'.strtolower(
                    $this->config->getSiteurl().'/'.$page->getUrl()
                ).'</loc><priority>'.$page->getPriority().'</priority><lastmod>'.$page->getLastmod().
                '</lastmod><changefreq>'.$page->getChangefreq().'</changefreq></url>';
        }

        $xmlLines[] = '</urlset>';

        return implode("\n", $xmlLines);
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
            $pages += $query->getPages();
        }

        $this->createXmlFile($this->generateXml($pages));
    }
}