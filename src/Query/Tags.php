<?php

namespace IvobaOxid\OxidSiteMap\Query;

/**
 * Class Tags
 * @package IvobaOxid\OxidSiteMap\Query
 */
class Tags extends AbstractQuery
{

    private $sql = "SELECT seo.oxseourl
                    FROM
                        oxseo seo
                    WHERE
                        seo.oxseourl <> '' AND
                        seo.oxstdurl LIKE '%%=tag%%' AND
                        seo.oxtype='dynamic' AND
                        seo.oxexpired = 0 %s";


    /**
     * @return string
     */
    public function getSql()
    {
        $this->sql = sprintf($this->sql, $this->config->getLangQuery());
        return $this->sql;
    }

}
