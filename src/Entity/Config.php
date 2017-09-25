<?php

namespace Ivoba\OxidSiteMap\Entity;

class Config
{

    private $filepath;
    private $filename;
    private $shopUrl;
    private $sLangQuery;


    /**
     * Config constructor.
     * @param $filepath
     * @param $filename
     */
    public function __construct($filepath, $filename)
    {
        $this->filepath = $filepath;
        $this->filename = $filename;

        $aLangParams    = \oxRegistry::getConfig()->getConfigParam('aLanguageParams');
        $aActiveLangIds = array();

        foreach ($aLangParams as $key=>$lang) {
            if ($lang['active']) {
                $aActiveLangIds[] = $lang['baseId'];
            }
        }

        if ($aActiveLangIds && count($aActiveLangIds) > 0) {
            $this->sLangQuery = ' AND OXLANG IN (' . implode(',', $aActiveLangIds) . ')';
        }
    }

    /**
     * @return mixed
     */
    public function getShopUrl()
    {
        return $this->shopUrl;
    }

    /**
     * @param mixed $shopUrl
     */
    public function setShopUrl($shopUrl)
    {
        $this->shopUrl = $shopUrl;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLangQuery()
    {
        return $this->sLangQuery;
    }


    /**
     * @return mixed
     */
    public function getFilepath()
    {
        return $this->filepath;
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

}