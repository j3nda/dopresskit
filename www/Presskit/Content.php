<?php

namespace Presskit;

class Content
{
    private $title;
    private $foundingDate;
    private $releaseDate;

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

    public function setFoundingDate($date)
    {
        $date = (string) $date;

        if ($date !== '') {
            $this->foundingDate = $date;
        }
    }

    public function getFoundingDate()
    {
        if ($this->foundingDate === null) {
            return false;
        }

        return $this->foundingDate;
    }

    public function setReleaseDate($date)
    {
        $date = (string) $date;

        if ($date !== '') {
            $this->releaseDate = $date;
        }
    }

    public function getReleaseDate()
    {
        if ($this->releaseDate === null) {
            return false;
        }

        return $this->releaseDate;
    }
}
