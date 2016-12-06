<?php

namespace Presskit\Value;

use Presskit\Value\Text;
use Presskit\Value\URI;
use Presskit\Value\Website;
use Presskit\Value\Email;

class Contact
{
    private $name;
    private $uri;
    private $website;
    private $email;

    public function __construct($name, $uri, $email)
    {
        $this->name = new Text($name);
        $this->uri = new URI($uri);
        $this->website = new Website($uri);
        $this->email = new Email($email);
    }

    public function __toString()
    {
        if ((string) $this->name !== '') {
            if ((string) $this->website !== '') {
                return $this->name . ' (' . $this->website->url() . ')';
            } else if ((string) $this->uri !== '') {
                return $this->name . ' (' . $this->uri . ')';
            } else if ((string) $this->email !== '') {
                return $this->name . ' (' . $this->email . ')';
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

    public function URI()
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

    public function email()
    {
        if ((string) $this->name === '' || ((string) $this->uri === '' && (string) $this->email === '')) {
            return '';
        }

        return $this->email;
    }
}
