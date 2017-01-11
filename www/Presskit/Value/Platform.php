<?php

namespace Presskit\Value;

use Presskit\Value\Text;
use Presskit\Value\URI;
use Presskit\Value\Website;


class Platform
{
    private $name;
    private $uri;
    private $website;

    public function __construct($name, $uri)
    {
        $this->name = new Text($name);
        $this->uri = new URI($uri);
        $this->website = new Website($uri);
    }

    public function __toString()
    {
        if ((string) $this->name !== '') {
            if ((string) $this->website !== '') {
                return $this->name . ' (' . $this->website->url() . ')';
            } elseif ((string) $this->uri !== '') {
                return $this->name . ' (' . $this->uri . ')';
            }
        }

        return '';
    }

    public function name()
    {
        if ((string) $this->name === '' || ((string) $this->uri === '' && (string) $this->email === '')) {
            return '';
        }

        return $this->name;
    }

    public function url()
    {
        if ((string) $this->name === '' || ((string) $this->uri === '' && (string) $this->email === '')) {
            return '';
        }

        return $this->uri;
    }

    public function website()
    {
        if ((string) $this->name === '' || ((string) $this->uri === '' && (string) $this->email === '')) {
            return '';
        }

        return $this->website;
    }
}
