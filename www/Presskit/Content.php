<?php

namespace Presskit;

class Content
{
    private $title;

    public function setTitle($title)
    {
        $this->title = (string) $title;
    }

    public function getTitle()
    {
        return $this->title;
    }
}