<?php

namespace IvobaOxid\OxidSiteMap\Filter;

use IvobaOxid\OxidSiteMap\Entity\Page;

/**
 * Class UrlFilter
 * @package IvobaOxid\OxidSiteMap\Filter
 */
class UrlFilter implements FilterInterface
{
    /**
     * @var array
     */
    private $urls;

    /**
     * UrlFilter constructor.
     * @param $urls
     */
    public function __construct(array $urls)
    {
        $this->urls = array_flip($urls);
    }

    /**
     * @param Page $page
     * @return bool
     */
    public function filter(Page $page)
    {
        return isset($this->urls[$page->getUrl()]);
    }

}
