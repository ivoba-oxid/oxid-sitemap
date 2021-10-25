<?php

namespace IvobaOxid\OxidSiteMap\Query;

/**
 * Class Tags
 * @package IvobaOxid\OxidSiteMap\Query
 */
class Tags extends AbstractQuery
{
    private $sql = "SELECT seo.oxseourl, seo.oxstdurl
                    FROM
                        oxseo seo
                    WHERE
                        seo.oxseourl <> '' AND
                        seo.oxstdurl LIKE '%%=oetagstagcontroller%%' AND
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

    /**
     * @return array
     */
    public function getPages()
    {
        $pages = [];

        $result = $this->db->select($this->getSql());
        if ($result !== false && $result->count() > 0) {
            while (!$result->EOF) {
                // check if tag is in oxartextends
                $url       = $result->fields['oxstdurl'];
                $urlParsed = parse_url($url);
                if (isset($urlParsed['query'])) {
                    parse_str(html_entity_decode($urlParsed['query']), $urlQuery);
                    $sViewName     = 'oxartextends';
                    $sArticleTable = 'oxarticles';
                    $oTag          = oxNew('oetagstag', $urlQuery['searchtag']);
                    $oTag->addUnderscores();
                    $sTag     = $oTag->get();
                    $sql      = "select {$sViewName}.oxid from {$sViewName} inner join {$sArticleTable} on ".
                        "{$sArticleTable}.oxid = {$sViewName}.oxid where {$sArticleTable}.oxparentid = '' and ".
                        "{$sArticleTable}.oxactive = 1 and ".
                        "(   {$sViewName}.oetags like ".$this->db->quote($sTag).
                        " or {$sViewName}.oetags like ".$this->db->quote("%,".$sTag.",%").
                        " or {$sViewName}.oetags like ".$this->db->quote("%,".$sTag).
                        " or {$sViewName}.oetags like ".$this->db->quote($sTag.",%").")";
                    $resCheck = $this->db->select($sql);
                    if ($resCheck !== false && $resCheck->count() > 0) {
                        $pages[] = $this->createPage($result);
                    }
                }
                $result->fetchRow();
            }
        }

        return $pages;
    }
}
