<?php

namespace Ivoba\OxidSiteMap\Filter;

use Ivoba\OxidSiteMap\Entity\Page;

interface FilterInterface
{
    public function filter(Page $page);
}