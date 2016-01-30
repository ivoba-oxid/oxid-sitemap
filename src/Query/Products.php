<?php

namespace Ivoba\OxidSiteMap\Query;

class Products extends AbstractQuery
{

    private $sql = "SELECT
                        oxart.oxid as oxid,
                        oxart.oxartnum as oxartnum,
                        oxart.oxtitle as oxtitle,
                        oxart.oxshortdesc as oxshortdesc,
                        oxart.oxtimestamp as oxtimestamp
                    FROM oxarticles as oxart
                    LEFT JOIN oxobject2category as oxobj2cat ON ( oxobj2cat.oxobjectid = oxart.oxid )
                    LEFT JOIN oxcategories as oxcat ON ( oxcat.oxid = oxobj2cat.oxcatnid )
                    WHERE
                        oxart.oxactive = 1 AND
                        oxcat.oxactive = 1 AND
                        oxcat.oxhidden = 0
                    GROUP by oxart.oxid
                    ORDER by oxart.oxartnum ASC";


    /**
     * @inheritdoc
     */
    protected function createPage($result)
    {
        $time = explode(" ", $result->fields['oxtimestamp']);

        return new Page(
            $this->getSeoUrl($result->fields['OXID']),
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