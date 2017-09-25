<?php

namespace Ivoba\OxidSiteMap\Query;

/**
 * Class Cms
 * @package Ivoba\OxidSiteMap\Query
 */
class Cms extends AbstractQuery
{
    /**
     * @var string
     */
    private $sql = "SELECT oxid,oxtitle,oxstdurl,oxseourl FROM oxcontents
                    JOIN
                      oxseo
                    ON
                      (oxseo.OXOBJECTID = oxcontents.OXID)
                    WHERE oxactive = 1 AND
                          oxfolder = 'CMSFOLDER_USERINFO' %s
                    ORDER by oxtitle ASC";


    /**
     * @return string
     */
    public function getSql()
    {
        $this->sql = sprintf($this->sql, $this->config->getLangQuery());
        return $this->sql;
    }

}