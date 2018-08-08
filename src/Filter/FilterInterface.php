<?php

namespace IvobaOxid\OxidSiteMap\Filter;

use IvobaOxid\OxidSiteMap\Entity\Page;

interface FilterInterface
{
    public function filter(Page $page);
}
