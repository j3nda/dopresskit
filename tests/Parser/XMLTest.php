<?php

use PHPUnit\Framework\TestCase;

class XMLTest extends TestCase
{
    use Codeception\Specify;

    private function createParser($fixture)
    {
        $content = new Presskit\Content;
        return new Presskit\Parser\XML(__DIR__ . '/../fixtures/' . $fixture . '.xml', $content);
    }

    public function testParsing()
    {
        $this->specify('parse returns the content object', function () {
            $XMLParser = $this->createParser('normal');
            verify($XMLParser->parse())->isInstanceOf('Presskit\Content');
        });

        $this->specify('it can handle a empty xml file', function () {
            $XMLParser = $this->createParser('empty');
            verify($XMLParser->parse())->isInstanceOf('Presskit\Content');
        });
    }

    public function testTitleParsing()
    {
        $this->specify('the title is read from the xml file', function () {
            $XMLParser = $this->createParser('normal');
            verify($XMLParser->parse()->getTitle())->equals('Example Title');
        });

        $this->specify('it can handle a missing title tag', function () {
            $XMLParser = $this->createParser('empty');
            verify($XMLParser->parse()->getTitle())->false();
        });
    }

    public function testFoundingDateParsing()
    {
        $this->specify('founding-date is read from the xml file', function () {
            $XMLParser = $this->createParser('normal');
            verify($XMLParser->parse()->getFoundingDate())->equals('First of January, 2016');
        });

        $this->specify('it can handle a missing founding-date tag', function () {
            $XMLParser = $this->createParser('empty');
            verify($XMLParser->parse()->getFoundingDate())->false();
        });
    }

    public function testReleaseDateParsing()
    {
        $this->specify('release-date is read from the xml file', function () {
            $XMLParser = $this->createParser('normal');
            verify($XMLParser->parse()->getReleaseDate())->equals('Second of January, 2016');
        });

        $this->specify('it can handle a missing release-date tag', function () {
            $XMLParser = $this->createParser('empty');
            verify($XMLParser->parse()->getReleaseDate())->false();
        });
    }

    public function testWebsiteParsing()
    {
        $this->specify('website is read from the xml file', function () {
            $XMLParser = $this->createParser('normal');
            verify($XMLParser->parse()->getWebsite()->url())->equals('http://www.example.com/');
        });

        $this->specify('it can handle a missing website tag', function () {
            $XMLParser = $this->createParser('empty');
            verify($XMLParser->parse()->getWebsite())->false();
        });
    }
}
