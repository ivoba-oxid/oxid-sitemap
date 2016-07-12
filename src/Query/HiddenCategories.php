<?php

namespace Ivoba\OxidSiteMap\Query;

/**
 * Class HiddenCategories
 * @package Ivoba\OxidSiteMap\Query
 */
class HiddenCategories extends AbstractQuery
{

    private $sql = "SELECT
                        oxid,
                        oxtitle,
                        oxdesc,
                        oxlongdesc,
                        oxstdurl,
                        oxseourl
                    FROM oxcategories
                    JOIN
                      oxseo
                    ON
                      (oxseo.OXOBJECTID = oxcategories.OXID)
                    WHERE
                        oxactive = 1 AND
                        oxhidden = 1
                    ORDER by oxtitle ASC";


    /**
     * @return string
     */
    public function getSql()
    {
        return $this->sql;
    }

}
