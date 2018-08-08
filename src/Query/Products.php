<?php

namespace IvobaOxid\OxidSiteMap\Query;

use IvobaOxid\OxidSiteMap\Entity\Page;

class Products extends AbstractQuery
{
    /**
     * @var string
     */
    private $sql = "SELECT
                        oxart.oxid, oxart.oxtimestamp
                    FROM oxarticles as oxart
                    WHERE
                        oxart.oxactive = 1
                    ORDER BY oxart.oxtitle ASC";

    /**
     * @inheritdoc
     */
    protected function createPage($result)
    {
        $article = oxNew('oxArticle');
        $article->load($result->fields['oxid']);

        $time = explode(" ", $result->fields['oxtimestamp']);

        return new Page(
            $article->getMainLink(),
            $this->hierachy,
            $time[0].'T'.$time[1].'+00:00',
            $this->changefreq
        );
    }

    /**
     * @return string
     */
    public function getSql()
    {
        return $this->sql;
    }

}
