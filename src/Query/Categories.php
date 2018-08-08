<?php

namespace IvobaOxid\OxidSiteMap\Query;

/**
 * Class Categories
 * @package IvobaOxid\OxidSiteMap\Query
 */
class Categories extends AbstractQuery
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
                        oxhidden = 0 %s
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
