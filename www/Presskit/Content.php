<?php

namespace Presskit;

class Content
{
    private $title;

    public function setTitle($title)
    {
        $title = (string) $title;

        if ($title !== '') {
            $this->title = $title;
        }
    }

    public function getTitle()
    {
        if ($this->title === null) {
            return false;
        }

        return $this->title;
    }
}
