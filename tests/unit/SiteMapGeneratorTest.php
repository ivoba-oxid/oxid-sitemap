<?php

declare(strict_types=1);

namespace IvobaOxid\OxidSiteMap\Tests;

use IvobaOxid\OxidSiteMap\Entity\Config;
use IvobaOxid\OxidSiteMap\Query\Categories;
use IvobaOxid\OxidSiteMap\SiteMapGenerator;
use PHPUnit\Framework\TestCase;

class SiteMapGeneratorTest extends TestCase
{
    public function testConstruct()
    {
        $config = new Config('filepath', 'filename', 'siteurl');
        $categories = $this->prophesize(Categories::class);
        // todo mock $query->getPages()
        // todo check if xml files exists
        // todo check generated xml
        // todo delete file
        $generator  = new SiteMapGenerator($config, [$categories->reveal()]);

        $this->assertInstanceOf(SiteMapGenerator::class, $generator);
    }
}
