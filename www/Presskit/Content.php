<?php

namespace Presskit;

use Presskit\Value\Text;
use Presskit\Value\Website;

class Content
{
    private $title;
    private $foundingDate;
    private $releaseDate;
    private $website;

    public function setTitle($title)
    {
        $this->title = new Text($title);
    }

    public function getTitle()
    {
        if ($this->title === null) {
            return false;
        }

        return $this->title->get();
    }

    public function setFoundingDate($date)
    {
        $this->foundingDate = new Text($date);
    }

    public function getFoundingDate()
    {
        if ($this->foundingDate === null) {
            return false;
        }

        return $this->foundingDate->get();
    }

    public function setReleaseDate($date)
    {
        $this->releaseDate = new Text($date);
    }

    public function getReleaseDate()
    {
        if ($this->releaseDate === null) {
            return false;
        }

        return $this->releaseDate->get();
    }

    public function setWebsite($website)
    {
        $this->website = new Website($website);
    }

    public function getWebsite()
    {
        if ($this->website === null) {
            return false;
        }

        return $this->website;
    }
}
