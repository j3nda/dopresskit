<?php

namespace Presskit\Value;

use Presskit\Value\Text;
use Presskit\Value\Website;

class Quote
{
    private $description;
    private $name;
    private $website;
    private $websiteName;

    public function __construct($description, $name, $website, $websiteName)
    {
        $this->description = new Text($description);
        $this->name = new Text($name);
        $this->website = new Website($website);
        $this->websiteName = new Text($websiteName);
    }

    public function __toString()
    {
        if ((string) $this->description !== '' && (string) $this->name !== '') {
            if ((string) $this->website !== '' && (string) $this->websiteName !== '') {
                return $this->description . ' - ' . $this->name . ' (' . $this->website->url() . ')';
            }

            return $this->description . ' - ' . $this->name;
        }

        return '';
    }

    public function description()
    {
        if ((string) $this->description !== '' && (string) $this->name !== '') {
            return $this->description;
        }

        return '';
    }

    public function name()
    {
        if ((string) $this->description !== '' && (string) $this->name !== '') {
            return $this->name;
        }

        return '';
    }

    public function website()
    {
        if ((string) $this->description !== '' &&
            (string) $this->name !== '' &&
            (string) $this->website !== '' &&
            (string) $this->websiteName) {
            return $this->website;
        }

        return '';
    }

    public function websiteName()
    {
        if ((string) $this->description !== '' &&
            (string) $this->name !== '' &&
            (string) $this->website !== '' &&
            (string) $this->websiteName) {
            return $this->websiteName;
        }

        return '';
    }
}
