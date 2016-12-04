<?php

namespace Presskit\Value;

use Presskit\Value\Text;

class Award
{
    private $award;
    private $description;

    public function __construct($award, $description)
    {
        $this->award = new Text($award);
        $this->description = new Text($description);
    }

    public function __toString()
    {
        if ((string) $this->award !== '' && (string) $this->description !== '') {
            return $this->award . ' (' . $this->description . ')';
        }

        return '';
    }

    public function award()
    {
        if ((string) $this->award === '' || (string) $this->description === '') {
            return '';
        }

        return $this->award;
    }

    public function description()
    {
        if ((string) $this->award === '' || (string) $this->description === '') {
            return '';
        }

        return $this->description;
    }
}
