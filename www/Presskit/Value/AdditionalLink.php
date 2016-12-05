<?php

namespace Presskit\Value;

use Presskit\Value\Text;
use Presskit\Value\Website;

class AdditionalLink
{
    private $title;
    private $description;
    private $website;

    public function __construct($title, $description, $website)
    {
        $this->title = new Text($title);
        $this->description = new Text($description);
        $this->website = new Website($website);
    }

    public function __toString()
    {
        if ((string) $this->title !== '' && (string) $this->description !== '' && (string) $this->website !== '') {
            return $this->title . ' - ' . $this->description . ' (' . $this->website->url() . ')';
        }

        return '';
    }

    public function title()
    {
        if ((string) $this->title !== '' && (string) $this->description !== '' && (string) $this->website !== '') {
            return $this->title;
        }

        return '';
    }

    public function description()
    {
        if ((string) $this->title !== '' && (string) $this->description !== '' && (string) $this->website !== '') {
            return $this->description;
        }

        return '';
    }

    public function website()
    {
        if ((string) $this->title !== '' && (string) $this->description !== '' && (string) $this->website !== '') {
            return $this->website;
        }

        return '';
    }
}
