<?php

namespace Presskit\Value;

class Text
{
    private $value;

    public function __construct($value)
    {
        $value = (string) $value;

        if ($value !== '') {
            $this->value = trim($value);
        }
    }

    public function __toString()
    {
        if ($this->value === null) {
            return '';
        }

        return $this->value;
    }
}
