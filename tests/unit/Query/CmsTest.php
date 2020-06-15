<?php

declare(strict_types=1);

namespace IvobaOxid\OxidSiteMap\Tests\Query;

use IvobaOxid\OxidSiteMap\Entity\Config;
use IvobaOxid\OxidSiteMap\Query\Cms;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use PHPUnit\Framework\TestCase;

class CmsTest extends TestCase
{
    public function testGetPages()
    {
        $db = $this->prophesize(QueryBuilderFactoryInterface::class);
        $config = new Config(
            'filepath',
            'filename.xml',
            'http://shopurl'
        );
        $query = new Cms(
            $db->reveal(),
            $config,
            '1',
            'daily'
        );

        $this->assertInstanceOf(Cms::class, $query);
    }
}
