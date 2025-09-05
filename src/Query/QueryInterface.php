<?php

namespace IvobaOxid\OxidSiteMap\Query;

use IvobaOxid\OxidSiteMap\Entity\Page;

interface QueryInterface
{
    /**
     * @return Page[]
     */
    public function getPages(): array;
}
