<?php

namespace IvobaOxid\OxidSiteMap\Entity;

/**
 * @phpstan-type LangConfig array{active: bool, baseId: string}
 */
class Config
{
    private string $filepath;
    private string $filename;
    private string $shopUrl;
    private string $langQuery;
    /**
     * @var array<int, string> Array of language base IDs
     */
    private array $langIds;

    /**
     * Config constructor.
     * @param string $filepath
     * @param string $filename
     * @param string $shopUrl
     * @param array<LangConfig> $langParams Array of language configurations
     */
    public function __construct(string $filepath, string $filename, string $shopUrl, array $langParams = [])
    {
        $this->filepath = $filepath;
        $this->filename = $filename;
        $this->shopUrl  = $shopUrl;

        $activeLangIds = [];
        foreach ($langParams as $key => $lang) {
            if ($lang['active']) {
                $activeLangIds[] = $lang['baseId'];
                $this->langIds[] = $lang['baseId'];
            }
        }

        if (count($activeLangIds) > 0) {
            $this->langQuery = ' AND OXLANG IN (' . implode(',', $activeLangIds) . ')';
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
     * @return array<int, string>
     */
    public function getLangIds(): array
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
