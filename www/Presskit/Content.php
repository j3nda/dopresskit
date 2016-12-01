<?php

namespace Presskit;

class Content
{
    private $title;
    private $foundingDate;

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
}
