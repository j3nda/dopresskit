<?php

namespace Presskit\Value;

class Text
{
    private $value;

    public function __construct($value)
    {
        $value = (string) $value;

        if ($value !== '') {
            $this->value = $value;
        }
    }

    public function get()
    {
        if ($this->value === null) {
            return false;
        }

        return $this->value;
    }
}
