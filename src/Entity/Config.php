<?php

namespace IvobaOxid\OxidSiteMap\Entity;

class Config
{
    private $filepath;
    private $filename;
    private $shopUrl;
    private $langQuery;
    private $langIds;

    /**
     * Config constructor.
     * @param string $filepath
     * @param string $filename
     * @param string $shopUrl
     * @param array $langParams
     */
    public function __construct(string $filepath, string $filename, string $shopUrl, array $langParams = [])
    {
        $this->filepath = $filepath;
        $this->filename = $filename;
        $this->shopUrl  = $shopUrl;

        $aActiveLangIds = [];
        foreach ($langParams as $key => $lang) {
            if ($lang['active']) {
                $aActiveLangIds[] = $lang['baseId'];
                $this->langIds[] = $lang['baseId'];
            }
        }

        if ($aActiveLangIds && count($aActiveLangIds) > 0) {
            $this->langQuery = ' AND OXLANG IN (' . implode(',', $aActiveLangIds) . ')';
        }
    }

    public function getShopUrl(): string
    {
        return $this->shopUrl;
    }

    public function getLangQuery(): string
    {
        return $this->langQuery;
    }

    /**
     * @return mixed
     */
    public function getLangIds()
    {
        return $this->langIds;
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
