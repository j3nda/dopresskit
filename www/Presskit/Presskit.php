<?php

namespace Presskit;

use finfo;
use Presskit\Parser\XML as XMLParser;

class Presskit
{
    private $XMLParser;

    public function __construct()
    {
        $this->XMLParser = new XMLParser;
    }

    public function parse($file)
    {
        if (is_file($file)) {
            $finfo = new finfo;
            $mimeType = $finfo->file($file, FILEINFO_MIME);

            if (strpos($mimeType, 'application/xml') !== false) {
                return $this->XMLParser->parse($file);
            }
        }

        return false;
    }
}
