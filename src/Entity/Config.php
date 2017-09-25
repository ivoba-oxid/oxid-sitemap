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
     * @param string $filepath
     * @param string $filename
     * @param string $shopUrl
     * @param array $aLangParams
     */
    public function __construct($filepath, $filename, $shopUrl, $aLangParams = [])
    {
        $this->filepath = $filepath;
        $this->filename = $filename;
        $this->shopUrl = $shopUrl;

        $aActiveLangIds = [];
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