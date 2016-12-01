<?php

namespace Presskit;

use finfo;
use Presskit\Parser\XML as XMLParser;

class Presskit
{
    private $content;

    public function __construct()
    {
        $this->content = new Content;
    }

    public function parse($file)
    {
        if (is_file($file)) {
            $finfo = new finfo;
            $mimeType = $finfo->file($file, FILEINFO_MIME);

            if (strpos($mimeType, 'application/xml') !== false) {
                $parser = new XMLParser($file, $this->content);
                return $parser->parse();
            }
        }

        return false;
    }
}
