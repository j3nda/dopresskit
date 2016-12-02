<?php

namespace Presskit\Value;

use Presskit\Value\Text;
use Presskit\Value\URI;

class Contact
{
    private $name;
    private $uri;

    public function __construct($name, $uri)
    {
        $this->name = new Text($name);
        $this->uri = new URI($uri);
    }

    public function __toString()
    {
        if ((string) $this->name !== '' && (string) $this->uri !== '') {
            return $this->name . ' (' . $this->uri . ')';
        }

        return '';
    }

    public function name()
    {
        if ((string) $this->name === '' || (string) $this->uri === '') {
            return '';
        }

        return $this->name;
    }

    public function URI()
    {
        if ((string) $this->name === '' || (string) $this->uri === '') {
            return '';
        }

        return $this->uri;
    }
}
