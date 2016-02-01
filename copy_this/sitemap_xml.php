<?php
/**
 * Site Map Generator
 */

require_once __DIR__.'/bootstrap.php';

$config = new \Ivoba\OxidSiteMap\Entity\Config(__DIR__, 'sitemap.xml');

$shopUrl = oxRegistry::get("oxConfigFile")->getVar("sShopURL");
$db = oxDb::getDb(\oxDb::FETCH_MODE_ASSOC);

$queries = [
    new \Ivoba\OxidSiteMap\Query\Categories($db, $shopUrl, $hierachy = '0.8', $changefreq = 'weekly'),
    new \Ivoba\OxidSiteMap\Query\Cms($db, $shopUrl, $hierachy = '0.1', $changefreq = 'weekly'),
    new \Ivoba\OxidSiteMap\Query\Products($db, $shopUrl, $hierachy = '1.0', $changefreq = 'daily'),
];

$urlFilter = new \Ivoba\OxidSiteMap\Filter\UrlFilter([$shopUrl.'/AGB/']);
$siteMapGenerator = new \Ivoba\OxidSiteMap\SiteMapGenerator($config, $queries, true, [$urlFilter]);

$siteMapGenerator->generate();

echo '<a href="/'.$config->getFilename().'" target="_blank">XML File</a>';