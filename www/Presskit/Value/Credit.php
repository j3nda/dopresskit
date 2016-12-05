<?php

namespace Presskit\Value;

use Presskit\Value\Text;
use Presskit\Value\Website;

class Credit
{
    private $name;
    private $role;
    private $website;

    public function __construct($name, $role, $website)
    {
        $this->name = new Text($name);
        $this->role = new Text($role);
        $this->website = new Website($website);
    }

    public function __toString()
    {
        if ((string) $this->name !== '' && (string) $this->role !== '') {
            if ((string) $this->website !== '') {
                return $this->name . ' - ' . $this->role . ' (' . $this->website->url() . ')';
            }
            
            return $this->name . ' - ' . $this->role;
        }

        return '';
    }

    public function name()
    {
        if ((string) $this->name !== '' && (string) $this->role !== '') {
            return $this->name;
        }

        return '';
    }

    public function role()
    {
        if ((string) $this->name !== '' && (string) $this->role !== '') {
            return $this->role;
        }

        return '';
    }

    public function website()
    {
        if ((string) $this->name !== '' && (string) $this->role !== '') {
            return $this->website;
        }

        return '';
    }
}
