<?php
/**
 * Site Map Generator
 */

require_once __DIR__ . '/bootstrap.php';

$config = new \Ivoba\OxidSiteMap\Entity\Config(__DIR__, 'sitemap.xml', oxRegistry::get("oxConfigFile")->getVar("sShopURL"));
$queries = [
    new \Ivoba\OxidSiteMap\Query\Categories(oxDb::getDb(), $hierachy = '0.8', $changefreq = 'weekly'),
    new \Ivoba\OxidSiteMap\Query\Cms(oxDb::getDb(), $hierachy = '0.1', $changefreq = 'weekly'),
    new \Ivoba\OxidSiteMap\Query\Products(oxDb::getDb(), $hierachy = '1.0', $changefreq = 'daily')
];
$siteMapGenerator = new \Ivoba\OxidSiteMap\SiteMapGenerator($config, $queries);

$siteMapGenerator->generate();

echo '<a href="/'. $config->getFilename() .'" target="_blank">XML Datei betrachten</a>';

