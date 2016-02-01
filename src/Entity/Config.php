<?php

namespace Ivoba\OxidSiteMap\Entity;

class Config
{

    private $filepath;
    private $filename;

    /**
     * Config constructor.
     * @param $filepath
     * @param $filename
     */
    public function __construct($filepath, $filename)
    {
        $this->filepath = $filepath;
        $this->filename = $filename;
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

}