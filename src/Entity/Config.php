<?php

namespace Ivoba\OxidSiteMap\Entity;

class Config
{

    private $filepath;
    private $filename;
    private $siteurl;

    /**
     * Config constructor.
     * @param $filepath
     * @param $filename
     * @param $siteurl
     */
    public function __construct($filepath, $filename, $siteurl)
    {
        $this->filepath = $filepath;
        $this->filename = $filename;
        $this->siteurl = $siteurl;
    }

    /**
     * @return mixed
     */
    public function getFilepath()
    {
        return $this->filepath;
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return mixed
     */
    public function getSiteurl()
    {
        return $this->siteurl;
    }

}