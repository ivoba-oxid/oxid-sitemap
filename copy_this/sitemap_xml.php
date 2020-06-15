<?php
/**
 * Site Map Generator
 */

require_once __DIR__.'/bootstrap.php';

use \OxidEsales\Eshop\Core\Registry;
use \OxidEsales\Eshop\Core\DatabaseProvider;
use \OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use \IvobaOxid\OxidSiteMap\SiteMapGenerator;

$containerFactory = ContainerFactory::getInstance();
$container = $containerFactory->getContainer();
$siteMapGenerator = $container->get(SiteMapGenerator::class);

$siteMapGenerator->generate();

echo '<a href="/'.$siteMapGenerator->getConfig()->getFilename().'" target="_blank">XML File</a>';
