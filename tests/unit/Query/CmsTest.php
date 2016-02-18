<?php
/**
 * Created by PhpStorm.
 * User: ivo
 * Date: 18.02.16
 * Time: 11:48
 */

namespace Ivoba\OxidSiteMap\Tests\Query\Cms;


use Ivoba\OxidSiteMap\Query\Cms;

class CmsTest extends \PHPUnit_Framework_TestCase
{

    public function testGetPages()
    {
        //doesnt work because we cant include oxLegacyDb
//        $db = $this->prophesize('\oxLegacyDb');
//        $query = new Cms(
//            $db->reveal(),
//            'siteurl',
//            '1',
//            'daily'
//        );
//
//        $this->assertInstanceOf(Cms::class, $query);
    }
}
