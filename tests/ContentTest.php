<?php

use PHPUnit\Framework\TestCase;

class ContentTest extends TestCase
{
    use Codeception\Specify;

    private function createContent()
    {
        return new Presskit\Content;
    }

    public function testTitle()
    {
        $this->specify('title can be set', function () {
            $content = $this->createContent();
            verify($content->setTitle('A Title'))->isEmpty();
        });

        $this->specify('title can be read', function () {
            $content = $this->createContent();
            $content->setTitle('Another Title');
            verify($content->getTitle())->equals('Another Title');
        });

        $this->specify('a non-empty title is always a string', function () {
            $content = $this->createContent();
            $content->setTitle(100);
            verify($content->getTitle())->internalType('string');
        });

        $this->specify('when a title is not set getTitle will return false', function () {
            $content = $this->createContent();
            verify($content->getTitle())->false();
        });

        $this->specify('when a empty title is set getTitle will return false', function () {
            $content = $this->createContent();
            $content->setTitle('');
            verify($content->getTitle())->false();
        });

        $this->specify('when a null title is set getTitle will return false', function () {
            $content = $this->createContent();
            $content->setTitle(null);
            verify($content->getTitle())->false();
        });
    }

    public function testFoundingDate()
    {
        $this->specify('foundingDate can be set', function () {
            $content = $this->createContent();
            verify($content->setFoundingDate('A Date'))->isEmpty();
        });

        $this->specify('foundingDate can be read', function () {
            $content = $this->createContent();
            $content->setFoundingDate('Another Date');
            verify($content->getFoundingDate())->equals('Another Date');
        });

        $this->specify('a non-empty foundingDate is always a string', function () {
            $content = $this->createContent();
            $content->setFoundingDate(100);
            verify($content->getFoundingDate())->internalType('string');
        });

        $this->specify('when a founding date is not set getFoundingDate will return false', function () {
            $content = $this->createContent();
            verify($content->getFoundingDate())->false();
        });

        $this->specify('when a empty founding date is set getFoundingDate will return false', function () {
            $content = $this->createContent();
            $content->setFoundingDate('');
            verify($content->getFoundingDate())->false();
        });

        $this->specify('when a null founding date is set getFoundingDate will return false', function () {
            $content = $this->createContent();
            $content->setFoundingDate(null);
            verify($content->getFoundingDate())->false();
        });
    }

    public function testReleaseDate()
    {
        $this->specify('releaseDate can be set', function () {
            $content = $this->createContent();
            verify($content->setReleaseDate('A Date'))->isEmpty();
        });

        $this->specify('releaseDate can be read', function () {
            $content = $this->createContent();
            $content->setReleaseDate('Another Date');
            verify($content->getReleaseDate())->equals('Another Date');
        });

        $this->specify('a non-empty releaseDate is always a string', function () {
            $content = $this->createContent();
            $content->setReleaseDate(100);
            verify($content->getReleaseDate())->internalType('string');
        });

        $this->specify('when a release date is not set getReleaseDate will return false', function () {
            $content = $this->createContent();
            verify($content->getReleaseDate())->false();
        });

        $this->specify('when a empty release date is set getReleaseDate will return false', function () {
            $content = $this->createContent();
            $content->setReleaseDate('');
            verify($content->getReleaseDate())->false();
        });

        $this->specify('when a null release date is set getReleaseDate will return false', function () {
            $content = $this->createContent();
            $content->setReleaseDate(null);
            verify($content->getReleaseDate())->false();
        });
    }

    public function testWebsite()
    {
        $this->specify('website can be set', function () {
            $content = $this->createContent();
            verify($content->setWebsite('http://www.example.com/'))->isEmpty();
        });

        $this->specify('website can be read', function () {
            $content = $this->createContent();
            $content->setWebsite('http://www.example.com/');
            verify($content->getWebsiteURL())->equals('http://www.example.com/');
        });

        $this->specify('when a website is not set getWebsiteURL will return false', function () {
            $content = $this->createContent();
            verify($content->getWebsiteURL())->false();
        });

        $this->specify('when a empty website is set getWebsiteURL will return false', function () {
            $content = $this->createContent();
            $content->setWebsite('');
            verify($content->getWebsiteURL())->false();
        });

        $this->specify('when a null website is set getWebsiteURL will return false', function () {
            $content = $this->createContent();
            $content->setWebsite(null);
            verify($content->getWebsiteURL())->false();
        });

        $this->specify('when a invalid website url is set getWebsiteURL will return false', function () {
            $content = $this->createContent();
            $content->setWebsite('www.example.com');
            verify($content->getWebsiteURL())->false();
        });

        $this->specify('only http urls are accepted as valid for the website', function () {
            $content = $this->createContent();
            $content->setWebsite('ssh://example.com');
            verify($content->getWebsiteURL())->false();
        });
    }
}
