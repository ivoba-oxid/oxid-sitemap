<?php
/**
 * Site Map Generator
 */

require_once __DIR__.'/bootstrap.php';

use \OxidEsales\Eshop\Core\Registry;
use \OxidEsales\Eshop\Core\DatabaseProvider;

$aLangParams = Registry::getConfig()->getConfigParam('aLanguageParams');
$shopUrl     = Registry::get(\OxidEsales\Eshop\Core\ConfigFile::class)->getVar('sShopURL');
$config      = new \IvobaOxid\OxidSiteMap\Entity\Config(__DIR__, 'sitemap.xml', $shopUrl, $aLangParams);

$db = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC);

$queries = [
    new \IvobaOxid\OxidSiteMap\Query\Categories($db, $config, $hierachy = '0.8', $changefreq = 'weekly'),
    new \IvobaOxid\OxidSiteMap\Query\HiddenCategories($db, $config, $hierachy = '0.8', $changefreq = 'weekly'),
    new \IvobaOxid\OxidSiteMap\Query\Cms($db, $config, $hierachy = '0.1', $changefreq = 'weekly'),
    new \IvobaOxid\OxidSiteMap\Query\Tags($db, $config, $hierachy = '0.1', $changefreq = 'weekly'),
    new \IvobaOxid\OxidSiteMap\Query\Products($db, $config, $hierachy = '1.0', $changefreq = 'daily'),
];

$urlFilter        = new \IvobaOxid\OxidSiteMap\Filter\UrlFilter([$shopUrl.'/AGB/']);
$siteMapGenerator = new \IvobaOxid\OxidSiteMap\SiteMapGenerator($config, $queries, true, [$urlFilter]);

$siteMapGenerator->generate();

echo '<a href="/'.$config->getFilename().'" target="_blank">XML File</a>';
