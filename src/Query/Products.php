<?php

namespace Ivoba\OxidSiteMap\Query;

use Ivoba\OxidSiteMap\Entity\Page;

class Products extends AbstractQuery
{

    /*
     * select oxarticles.OXTITLE, oxobject2category.OXTIME, oxseo.OXSEOURL
from mehrgruen.oxarticles, mehrgruen.oxobject2category, mehrgruen.oxseo
where oxarticles.OXID = oxobject2category.OXOBJECTID
and oxobject2category.OXTIME = 0
and SUBSTRING(oxseo.OXSTDURL,-32) = oxobject2category.OXCATNID
and oxseo.OXOBJECTID = oxarticles.OXID
and OXEXPIRED = 0
and OXPARENTID =""
     */

    /**
     * @todo get only canonical
     * @var string
     */
    private $sql = "SELECT
                        oxart.oxid as oxid,
                        oxart.oxartnum as oxartnum,
                        oxart.oxtitle as oxtitle,
                        oxart.oxshortdesc as oxshortdesc,
                        oxart.oxtimestamp as oxtimestamp,
                        oxseo.oxstdurl,
                        oxseo.oxseourl
                    FROM oxarticles as oxart
                    JOIN
                      oxseo
                    ON
                      (oxseo.oxobjectid = oxart.oxid)
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

        $url = $result->fields['oxseourl'];
        if (empty($url)) {
            $url = $result->fields['oxstdurl'];
        }

        return new Page(
            $url,
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