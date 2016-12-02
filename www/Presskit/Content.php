<?php

namespace Presskit;

use Presskit\Value\Text;

class Content
{
    private $title;
    private $foundingDate;
    private $releaseDate;
    private $websiteURL;
    private $websiteName;

    public function setTitle($title)
    {
        $this->title = new Text($title);
    }

    public function getTitle()
    {
        if ($this->title === null) {
            return false;
        }

        return $this->title->get();
    }

    public function setFoundingDate($date)
    {
        $this->foundingDate = new Text($date);
    }

    public function getFoundingDate()
    {
        if ($this->foundingDate === null) {
            return false;
        }

        return $this->foundingDate->get();
    }

    public function setReleaseDate($date)
    {
        $this->releaseDate = new Text($date);
    }

    public function getReleaseDate()
    {
        if ($this->releaseDate === null) {
            return false;
        }

        return $this->releaseDate->get();
    }

    public function setWebsite($website)
    {
        $website = (string) $website;

        if ($website !== '' && filter_var($website, FILTER_VALIDATE_URL) && substr($website, 0, 4) === 'http') {
            $this->websiteURL = $website;

            $host = parse_url($website, PHP_URL_HOST);

            if (substr($host, 0, 4) === 'www.') {
                $host = substr($host, 4);
            }

            $this->websiteName = $host;
        }
    }

    public function getWebsiteURL()
    {
        if ($this->websiteURL === null) {
            return false;
        }

        return $this->websiteURL;
    }
    
    public function getWebsiteName()
    {
        if ($this->websiteName === null) {
            return false;
        }

        return $this->websiteName;
    }
}
