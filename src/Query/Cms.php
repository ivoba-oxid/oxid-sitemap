<?php
/**
 * Created by PhpStorm.
 * User: ivo
 * Date: 29.01.16
 * Time: 12:20
 */

namespace Ivoba\OxidSiteMap\Query;


class Cms extends AbstractQuery
{
    private $sql = "SELECT
                        oxid,
                        oxtitle
                    FROM oxcontents
                    WHERE
                        oxactive = 1 AND
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