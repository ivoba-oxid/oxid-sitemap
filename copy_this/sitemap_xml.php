<?php
/**
 * Site Map Generator
 */

require_once __DIR__.'/bootstrap.php';

$aLangParams = \oxRegistry::getConfig()->getConfigParam('aLanguageParams');
$shopUrl     = oxRegistry::get("oxConfigFile")->getVar("sShopURL");
$config      = new \Ivoba\OxidSiteMap\Entity\Config(__DIR__, 'sitemap.xml', $shopUrl, $aLangParams);

$db = oxDb::getDb(\oxDb::FETCH_MODE_ASSOC);

$queries = [
    new \Ivoba\OxidSiteMap\Query\Categories($db, $config, $hierachy = '0.8', $changefreq = 'weekly'),
    new \Ivoba\OxidSiteMap\Query\HiddenCategories($db, $config, $hierachy = '0.8', $changefreq = 'weekly'),
    new \Ivoba\OxidSiteMap\Query\Cms($db, $config, $hierachy = '0.1', $changefreq = 'weekly'),
    new \Ivoba\OxidSiteMap\Query\Tags($db, $config, $hierachy = '0.1', $changefreq = 'weekly'),
    new \Ivoba\OxidSiteMap\Query\Products($db, $config, $hierachy = '1.0', $changefreq = 'daily'),
];

$urlFilter        = new \Ivoba\OxidSiteMap\Filter\UrlFilter([$shopUrl.'/AGB/']);
$siteMapGenerator = new \Ivoba\OxidSiteMap\SiteMapGenerator($config, $queries, true, [$urlFilter]);

$siteMapGenerator->generate();

echo '<a href="/'.$config->getFilename().'" target="_blank">XML File</a>';