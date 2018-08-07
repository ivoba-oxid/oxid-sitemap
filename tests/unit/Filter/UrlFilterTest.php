<?php
declare(strict_types=1);

namespace Ivoba\OxidSiteMap\Tests\Filter\UrlFilter;

use Ivoba\OxidSiteMap\Entity\Page;
use Ivoba\OxidSiteMap\Filter\UrlFilter;
use PHPUnit\Framework\TestCase;

class UrlFilterTest extends TestCase
{

    public function testFilter()
    {
        $urls = ['url1', 'url2'];
        $filter = new UrlFilter($urls);

        $filtered = $filter->filter(new Page('urrrl', '1', 'lastmod', 'changefreq'));
        $this->assertFalse($filtered);

        $filtered = $filter->filter(new Page('url1', '1', 'lastmod', 'changefreq'));
        $this->assertTrue($filtered);
    }
}
