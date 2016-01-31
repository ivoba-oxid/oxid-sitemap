<?php

namespace Ivoba\OxidSiteMap\Query;

/**
 * Class Cms
 * @package Ivoba\OxidSiteMap\Query
 */
class Cms extends AbstractQuery
{
    /**
     * @todo multilang AND oxseo.oxlang  = '0'
     * @var string
     */
    private $sql = "SELECT oxid,oxtitle,oxstdurl,oxseourl FROM oxcontents
                    JOIN
                      oxseo
                    ON
                      (oxseo.OXOBJECTID = oxcontents.OXID)
                    WHERE oxactive = 1 AND
                          oxfolder = 'CMSFOLDER_USERINFO'
                    ORDER by oxtitle ASC";


    /**
     * @return string
     */
    public function getSql()
    {
        return $this->sql;
    }

}