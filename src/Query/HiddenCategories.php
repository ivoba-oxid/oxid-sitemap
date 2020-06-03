<?php

namespace IvobaOxid\OxidSiteMap\Query;

/**
 * Class HiddenCategories
 * @package IvobaOxid\OxidSiteMap\Query
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

    public function getSql(): string
    {
        return $this->sql;
    }

}
