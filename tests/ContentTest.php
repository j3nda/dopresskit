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

        $this->specify('title can handle not being set', function () {
            $content = $this->createContent();
            verify($content->getTitle())->equals('');
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

        $this->specify('foundingDate can handle not being set', function () {
            $content = $this->createContent();
            verify($content->getFoundingDate())->equals('');
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

        $this->specify('releaseDate can handle not being set', function () {
            $content = $this->createContent();
            verify($content->getReleaseDate())->equals('');
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
            verify($content->getWebsite())->equals('example.com (http://www.example.com/)');
            verify($content->getWebsite()->url())->equals('http://www.example.com/');
            verify($content->getWebsite()->name())->equals('example.com');
        });

        $this->specify('website can handle not being set', function () {
            $content = $this->createContent();
            verify($content->getWebsite())->equals('');
        });
    }

    public function testPressContact()
    {
        $this->specify('pressContact can be set', function () {
            $content = $this->createContent();
            verify($content->setPressContact('press@example.com'))->isEmpty();
        });

        $this->specify('pressContact can be read', function () {
            $content = $this->createContent();
            $content->setPressContact('press@example.com');
            verify($content->getPressContact())->equals('press@example.com');
        });

        $this->specify('pressContact can handle not being set', function () {
            $content = $this->createContent();
            verify($content->getPressContact())->equals('');
        });
    }

    public function testLocation()
    {
        $this->specify('location can be set', function () {
            $content = $this->createContent();
            verify($content->setLocation('City, Country'))->isEmpty();
        });

        $this->specify('location can be read', function () {
            $content = $this->createContent();
            $content->setLocation('City, Country');
            verify($content->getLocation())->equals('City, Country');
        });

        $this->specify('location can handle not being set', function () {
            $content = $this->createContent();
            verify($content->getLocation())->equals('');
        });
    }

    public function testSocialContacts()
    {
        $this->specify('social contacts can be added', function () {
            $content = $this->createContent();
            verify($content->addSocialContact('Name', 'http://www.example.com/'))->isEmpty();
        });

        $this->specify('social contacts can be read', function () {
            $content = $this->createContent();
            $content->addSocialContact('Name', 'http://www.example.com/');
            verify($content->getSocialContacts())->count(1);
            verify($content->getSocialContacts()[0]->name())->equals('Name');
            verify($content->getSocialContacts()[0]->URI())->equals('http://www.example.com/');
        });

        $this->specify('social contacts can handle not being added', function () {
            $content = $this->createContent();
            verify($content->getSocialContacts())->count(0);
        });
    }

    public function testAddress()
    {
        $this->specify('social contacts can be added', function () {
            $content = $this->createContent();
            verify($content->addAddressLine('Address Line'))->isEmpty();
        });

        $this->specify('address can be read', function () {
            $content = $this->createContent();
            $content->addAddressLine('Address Line');
            verify($content->getAddress())->count(1);
            verify($content->getAddress()[0])->equals('Address Line');
        });

        $this->specify('address can handle lines not being added', function () {
            $content = $this->createContent();
            verify($content->getAddress())->count(0);
        });
    }

    public function testPhone()
    {
        $this->specify('phone can be set', function () {
            $content = $this->createContent();
            verify($content->setPhone('123456'))->isEmpty();
        });

        $this->specify('phone can be read', function () {
            $content = $this->createContent();
            $content->setPhone('123456');
            verify($content->getPhone())->equals('123456');
        });

        $this->specify('phone can handle not being set', function () {
            $content = $this->createContent();
            verify($content->getPhone())->equals('');
        });
    }

    public function testDescription()
    {
        $this->specify('description can be set', function () {
            $content = $this->createContent();
            verify($content->setDescription('A description'))->isEmpty();
        });

        $this->specify('description can be read', function () {
            $content = $this->createContent();
            $content->setDescription('A description');
            verify($content->getDescription())->equals('A description');
        });

        $this->specify('description can handle not being set', function () {
            $content = $this->createContent();
            verify($content->getDescription())->equals('');
        });
    }

    public function testHistory()
    {
        $this->specify('history can be added', function () {
            $content = $this->createContent();
            verify($content->addHistory('Heading', 'Body'))->isEmpty();
        });

        $this->specify('history can be read', function () {
            $content = $this->createContent();
            $content->addHistory('Heading', 'Body');
            verify($content->getHistory())->count(1);
            verify($content->getHistory()[0]->heading())->equals('Heading');
            verify($content->getHistory()[0]->body())->equals('Body');
        });

        $this->specify('history can handle nothing being added', function () {
            $content = $this->createContent();
            verify($content->getHistory())->count(0);
        });
    }
}
