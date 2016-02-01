<?php

namespace Ivoba\OxidSiteMap\Filter;

use Ivoba\OxidSiteMap\Entity\Page;

/**
 * Class UrlFilter
 * @package Ivoba\OxidSiteMap\Filter
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