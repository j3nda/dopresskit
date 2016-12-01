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
        $this->findFoundingDate();
        $this->findReleaseDate();
        $this->findWebsite();

        return $this->content;
    }

    private function findTitle()
    {
        if (count($this->data->title) > 0) {
            $this->content->setTitle($this->data->title);
        }
    }

    private function findFoundingDate()
    {
        if (count($this->data->{'founding-date'}) > 0) {
            $this->content->setFoundingDate($this->data->{'founding-date'});
        }
    }

    private function findReleaseDate()
    {
        if (count($this->data->{'release-date'}) > 0) {
            $this->content->setReleaseDate($this->data->{'release-date'});
        }
    }

    private function findWebsite()
    {
        if (count($this->data->website) > 0) {
            $this->content->setWebsite($this->data->website);
        }
    }
}
