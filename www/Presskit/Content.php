<?php

namespace Presskit;

use Presskit\Value\Text;
use Presskit\Value\Website;
use Presskit\Value\URL;
use Presskit\Value\Contact;

class Content
{
    private $title = '';
    private $foundingDate = '';
    private $releaseDate = '';
    private $website = '';
    private $pressContact = '';
    private $location = '';
    private $socialContacts = [];
    private $address = [];

    public function setTitle($title)
    {
        $this->title = new Text($title);
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setFoundingDate($date)
    {
        $this->foundingDate = new Text($date);
    }

    public function getFoundingDate()
    {
        return $this->foundingDate;
    }

    public function setReleaseDate($date)
    {
        $this->releaseDate = new Text($date);
    }

    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    public function setWebsite($website)
    {
        $this->website = new Website($website);
    }

    public function getWebsite()
    {
        if ($this->website === null) {
            return false;
        }

        return $this->website;
    }

    public function setPressContact($contact)
    {
        $this->pressContact = new Text($contact);
    }

    public function getPressContact()
    {
        return $this->pressContact;
    }

    public function setLocation($location)
    {
        $this->location = new Text($location);
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function addSocialContact($name, $uri)
    {
        $contact = new Contact($name, $uri);

        if ((string) $contact !== '') {
            $this->socialContacts[] = $contact;
        }
    }

    public function getSocialContacts()
    {
        return $this->socialContacts;
    }

    public function addAddressLine($addressLine)
    {
        $addressLine = new Text($addressLine);

        if ((string) $addressLine !== '') {
            $this->address[] = $addressLine;
        }
    }

    public function getAddress()
    {
        return $this->address;
    }
}
