<?php

namespace Presskit\Value;

use Presskit\Value\Text;

class History
{
    private $heading;
    private $body;

    public function __construct($heading, $body)
    {
        $this->heading = new Text($heading);
        $this->body = new Text($body);
    }

    public function __toString()
    {
        if ((string) $this->heading !== '' && (string) $this->body !== '') {
            return $this->heading . ': ' . $this->body;
        }

        return '';
    }

    public function heading()
    {
        if ((string) $this->heading === '' || (string) $this->body === '') {
            return '';
        }

        return $this->heading;
    }

    public function body()
    {
        if ((string) $this->heading === '' || (string) $this->body === '') {
            return '';
        }

        return $this->body;
    }
}
