<?php

namespace IvobaOxid\OxidSiteMap\Query;

/**
 * Class Cms
 * @package IvobaOxid\OxidSiteMap\Query
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
                          oxfolder IN ('CMSFOLDER_USERINFO', 'CMSFOLDER_PRODUCTINFO') %s
                    ORDER by oxtitle ASC";

    public function getSql(): string
    {
        $this->sql = sprintf($this->sql, $this->config->getLangQuery());

        return $this->sql;
    }

}
