<?php

use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
*/
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
            verify($XMLParser->parse()->getTitle())->equals('');
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
            verify($XMLParser->parse()->getFoundingDate())->equals('');
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
            verify($XMLParser->parse()->getReleaseDate())->equals('');
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
            verify($XMLParser->parse()->getWebsite())->equals('');
        });
    }

    public function testPressContactParsing()
    {
        $this->specify('press-contact is read from the xml file', function () {
            $XMLParser = $this->createParser('normal');
            verify($XMLParser->parse()->getPressContact())->equals('press@example.com');
        });

        $this->specify('it can handle a missing press-contact tag', function () {
            $XMLParser = $this->createParser('empty');
            verify($XMLParser->parse()->getPressContact())->equals('');
        });
    }

    public function testLocationParsing()
    {
        $this->specify('based-in is read from the xml file', function () {
            $XMLParser = $this->createParser('normal');
            verify($XMLParser->parse()->getLocation())->equals('City, Country');
        });

        $this->specify('it can handle a missing based-in tag', function () {
            $XMLParser = $this->createParser('empty');
            verify($XMLParser->parse()->getLocation())->equals('');
        });
    }

    public function testSocialContactsParsing()
    {
        $this->specify('social contacts are read from the xml file', function () {
            $XMLParser = $this->createParser('normal');
            verify($XMLParser->parse()->getSocialContacts())->count(3);
            verify($XMLParser->parse()->getSocialContacts()[0]->name())->equals('twitter.com/Example');
            verify($XMLParser->parse()->getSocialContacts()[0]->URI())->equals('http://www.twitter.com/Example');
        });

        $this->specify('it can handle a missing socials tag', function () {
            $XMLParser = $this->createParser('empty');
            verify($XMLParser->parse()->getSocialContacts())->count(0);
        });
    }

    public function testAddressParsing()
    {
        $this->specify('address lines are read from the xml file', function () {
            $XMLParser = $this->createParser('normal');
            verify($XMLParser->parse()->getAddress())->count(3);
            verify($XMLParser->parse()->getAddress()[0])->equals('Address Line 1');
        });

        $this->specify('it can handle a missing address tag', function () {
            $XMLParser = $this->createParser('empty');
            verify($XMLParser->parse()->getAddress())->count(0);
        });
    }

    public function testPhoneParsing()
    {
        $this->specify('phone is read from the xml file', function () {
            $XMLParser = $this->createParser('normal');
            verify($XMLParser->parse()->getPhone())->equals('+00 (1) 22 33 44 55 66');
        });

        $this->specify('it can handle a missing phone tag', function () {
            $XMLParser = $this->createParser('empty');
            verify($XMLParser->parse()->getPhone())->equals('');
        });
    }

    public function testDescriptionParsing()
    {
        $this->specify('description is read from the xml file', function () {
            $XMLParser = $this->createParser('normal');
            verify($XMLParser->parse()->getDescription())->equals('A nice description');
        });

        $this->specify('it can handle a missing description tag', function () {
            $XMLParser = $this->createParser('empty');
            verify($XMLParser->parse()->getDescription())->equals('');
        });
    }

    public function testHistoryParsing()
    {
        $this->specify('history is read from the xml file', function () {
            $XMLParser = $this->createParser('normal');
            verify($XMLParser->parse()->getHistory())->count(2);
            verify($XMLParser->parse()->getHistory()[0]->heading())->equals('Early history');
            verify($XMLParser->parse()->getHistory()[1]->heading())->equals('After that');
        });

        $this->specify('it can handle a missing histories tag', function () {
            $XMLParser = $this->createParser('empty');
            verify($XMLParser->parse()->getHistory())->count(0);
        });
    }

    public function testFeatureParsing()
    {
        $this->specify('features are read from the xml file', function () {
            $XMLParser = $this->createParser('normal');
            verify($XMLParser->parse()->getFeatures())->count(5);
            verify($XMLParser->parse()->getFeatures()[0])
                ->equals('Includes something really interesting about the game which players will love.');
        });

        $this->specify('it can handle a missing features tag', function () {
            $XMLParser = $this->createParser('empty');
            verify($XMLParser->parse()->getFeatures())->count(0);
        });
    }

    public function testTrailerParsing()
    {
        $this->specify('trailers are read from the xml file', function () {
            $XMLParser = $this->createParser('normal');
            verify($XMLParser->parse()->getTrailers())->count(5);
            verify($XMLParser->parse()->getTrailers()[0])->equals('Trailer');
        });

        $this->specify('it can handle a missing trailers tag', function () {
            $XMLParser = $this->createParser('empty');
            verify($XMLParser->parse()->getTrailers())->count(0);
        });
    }

    public function testAwardParsing()
    {
        $this->specify('awards are read from the xml file', function () {
            $XMLParser = $this->createParser('normal');
            verify($XMLParser->parse()->getAwards())->count(4);
            verify($XMLParser->parse()->getAwards()[0])
                ->equals('Winner in this highly relevant contest. (Award Location, 20 October, 1989)');
        });

        $this->specify('it can handle a missing awards tag', function () {
            $XMLParser = $this->createParser('empty');
            verify($XMLParser->parse()->getAwards())->count(0);
        });
    }

    public function testQuoteParsing()
    {
        $this->specify('quotes are read from the xml file', function () {
            $XMLParser = $this->createParser('normal');
            verify($XMLParser->parse()->getQuotes())->count(4);
            verify($XMLParser->parse()->getQuotes()[0])
                ->equals('This is a rather insignificant quote by a highly important person. - Person Name');
        });

        $this->specify('it can handle a missing quotes tag', function () {
            $XMLParser = $this->createParser('empty');
            verify($XMLParser->parse()->getQuotes())->count(0);
        });
    }

    public function testAdditionalLinksParsing()
    {
        $this->specify('additional links are read from the xml file', function () {
            $XMLParser = $this->createParser('normal');
            verify($XMLParser->parse()->getAdditionalLinks())->count(2);
            verify($XMLParser->parse()->getAdditionalLinks()[0])
                ->equals('Original Soundtrack - Available for free from (http://somemusicsite.com/thislink)');
        });

        $this->specify('it can handle a missing additionals tag', function () {
            $XMLParser = $this->createParser('empty');
            verify($XMLParser->parse()->getAdditionalLinks())->count(0);
        });
    }

    public function testCreditsParsing()
    {
        $this->specify('credits are read from the xml file', function () {
            $XMLParser = $this->createParser('normal');
            verify($XMLParser->parse()->getCredits())->count(2);
            verify($XMLParser->parse()->getCredits()[1])
                ->equals('Another Nice Name - Freelancer (http://www.example.com/)');
        });

        $this->specify('it can handle a missing credits tag', function () {
            $XMLParser = $this->createParser('empty');
            verify($XMLParser->parse()->getCredits())->count(0);
        });
    }
}
