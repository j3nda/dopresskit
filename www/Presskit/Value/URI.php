<?php

namespace Presskit\Value;

class URI
{
    private $uri;

    public function __construct($uri)
    {
        $uri = (string) $uri;

        if ($uri !== '') {
            if (filter_var($uri, FILTER_VALIDATE_URL) || substr($uri, 0, 7) === 'callto:') {
                $this->uri = $uri;
            }
        }
    }

    public function __toString()
    {
        if ($this->uri === null) {
            return '';
        }

        return $this->uri;
    }
}
