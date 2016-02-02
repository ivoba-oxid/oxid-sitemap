<?php

namespace Ivoba\OxidSiteMap\Query;

/**
 * Class Tags
 * @package Ivoba\OxidSiteMap\Query
 */
class Tags extends AbstractQuery
{

    private $sql = "SELECT seo.oxseourl
                    FROM
                        oxseo seo
                    WHERE
                        seo.oxseourl <> '' AND
                        seo.oxstdurl LIKE '%=tag%' AND
                        seo.oxtype='dynamic' AND
                        seo.oxexpired = 0 AND
                        seo.oxlang = 0";


    /**
     * @return string
     */
    public function getSql()
    {
        return $this->sql;
    }

}