<?php

namespace IvobaOxid\OxidSiteMap\Entity;

class Config
{
    private $filepath;
    private $filename;
    private $shopUrl;
    private $langQuery;

    /**
     * Config constructor.
     * @param string $filepath
     * @param string $filename
     * @param string $shopUrl
     * @param array $aLangParams
     */
    public function __construct(string $filepath, string $filename, string $shopUrl, array $aLangParams = [])
    {
        $this->filepath = $filepath;
        $this->filename = $filename;
        $this->shopUrl  = $shopUrl;

        $aActiveLangIds = [];
        foreach ($aLangParams as $key => $lang) {
            if ($lang['active']) {
                $aActiveLangIds[] = $lang['baseId'];
            }
        }

        if ($aActiveLangIds && count($aActiveLangIds) > 0) {
            $this->langQuery = ' AND OXLANG IN ('.implode(',', $aActiveLangIds).')';
        }
    }

    public function getShopUrl(): string
    {
        return $this->shopUrl;
    }

    public function getLangQuery(): string
    {
        return $this->sLangQuery;
    }


    public function getFilepath(): string
    {
        return $this->filepath;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }
}
