<?php
declare(strict_types=1);

namespace IvobaOxid\OxidSiteMap\Tests\SiteMapGenerator;

use IvobaOxid\OxidSiteMap\Entity\Config;
use IvobaOxid\OxidSiteMap\Query\Categories;
use IvobaOxid\OxidSiteMap\SiteMapGenerator;
use PHPUnit\Framework\TestCase;

class SiteMapGeneratorTest extends TestCase
{
    public function testConstruct()
    {
        $config = new Config('filepath', 'filename', 'siteurl');
        //todo as soon as oxid core is available on packagist, mock legacyDb class and us all query classes
        $categories = $this->prophesize(Categories::class);
        $generator = new SiteMapGenerator($config, [$categories->reveal()]);

        $this->assertInstanceOf(SiteMapGenerator::class, $generator);
    }
}
