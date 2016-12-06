<?php

namespace Presskit;

use Presskit\Value\Text;
use Presskit\Value\Website;
use Presskit\Value\URL;
use Presskit\Value\Contact;
use Presskit\Value\History;
use Presskit\Value\Trailer;
use Presskit\Value\Award;
use Presskit\Value\Quote;
use Presskit\Value\AdditionalLink;
use Presskit\Value\Credit;

/**
 * @SuppressWarnings(PHPMD.TooManyFields)
*/
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
    private $phone = '';
    private $description = '';
    private $history = [];
    private $features = [];
    private $trailers = [];
    private $awards = [];
    private $quotes = [];
    private $additionalLinks = [];
    private $credits = [];

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
        $contact = new Contact($name, $uri, '');

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

    public function setPhone($phone)
    {
        $this->phone = new Text($phone);
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setDescription($description)
    {
        $this->description = new Text($description);
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function addHistory($heading, $body)
    {
        $history = new History($heading, $body);

        if ((string) $history !== '') {
            $this->history[] = $history;
        }
    }

    public function getHistory()
    {
        return $this->history;
    }

    public function addFeature($feature)
    {
        $feature = new Text($feature);

        if ((string) $feature !== '') {
            $this->features[] = $feature;
        }
    }

    public function getFeatures()
    {
        return $this->features;
    }

    public function addTrailer($name, $locations)
    {
        $trailer = new Trailer($name, $locations);

        if ((string) $trailer !== '') {
            $this->trailers[] = $trailer;
        }
    }

    public function getTrailers()
    {
        return $this->trailers;
    }

    public function addAward($award, $description)
    {
        $award = new Award($award, $description);

        if ((string) $award !== '') {
            $this->awards[] = $award;
        }
    }

    public function getAwards()
    {
        return $this->awards;
    }

    public function addQuote($description, $name, $website, $websiteName)
    {
        $quote = new Quote($description, $name, $website, $websiteName);

        if ((string) $quote !== '') {
            $this->quotes[] = $quote;
        }
    }

    public function getQuotes()
    {
        return $this->quotes;
    }

    public function addAdditionalLink($title, $description, $website)
    {
        $additionalLink = new AdditionalLink($title, $description, $website);

        if ((string) $additionalLink !== '') {
            $this->additionalLinks[] = $additionalLink;
        }
    }

    public function getAdditionalLinks()
    {
        return $this->additionalLinks;
    }

    public function addCredit($name, $role, $website)
    {
        $credit = new Credit($name, $role, $website);

        if ((string) $credit !== '') {
            $this->credits[] = $credit;
        }
    }

    public function getCredits()
    {
        return $this->credits;
    }
}
