<?php

namespace Presskit\Parser;

use Presskit\Content;
use SimpleXMLElement;

class XML
{
    private $content;
    private $data;

    public function __construct($file, Content $content)
    {
        $this->content = $content;
        $this->data = new SimpleXMLElement(file_get_contents($file));
    }

    public function parse()
    {
        $this->findTitle();

        return $this->content;
    }

    private function findTitle()
    {
        if (count($this->data->title) > 0) {
            $this->content->setTitle($this->data->title);
        }
    }
}
