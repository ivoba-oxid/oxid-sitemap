<?php

namespace IvobaOxid\OxidSiteMap\Filter;

use IvobaOxid\OxidSiteMap\Entity\Page;

class UrlFilter implements FilterInterface
{
    private string $shopUrl;
    /**
     * @var array<string>
     */
    private array $urls;

    /**
     * @param array<string> $urls
     */
    public function __construct(string $shopUrl, array $urls)
    {
        $this->shopUrl = $shopUrl;
        $this->urls    = array_flip(
            array_map(
                function ($url) {
                    return $this->shopUrl . $url;
                },
                $urls
            )
        );
    }

    public function filter(Page $page): bool
    {
        return isset($this->urls[$this->shopUrl . $page->getUrl()]);
    }
}
