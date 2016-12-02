<?php

use PHPUnit\Framework\TestCase;

use Presskit\Value\Website;

class WebsiteTest extends TestCase
{
    use Codeception\Specify;

    public function testValue()
    {
        $this->specify('website can be set and read', function () {
            $value = new Website('http://www.example.com/');
            verify($value)->equals('example.com (http://www.example.com/)');
            verify($value->url())->equals('http://www.example.com/');
            verify($value->name())->equals('example.com');
        });

        $this->specify('when a empty website is set the value will be empty', function () {
            $value = new Website('');
            verify($value)->equals('');
        });

        $this->specify('when a empty website is set url and name will return false', function () {
            $value = new Website('');
            verify($value->url())->false();
            verify($value->name())->false();
        });

        $this->specify('when a null website is set the value will be empty', function () {
            $value = new Website(null);
            verify($value)->equals('');
        });

        $this->specify('when a null website is set url and name will return false', function () {
            $value = new Website(null);
            verify($value->url())->false();
            verify($value->name())->false();
        });

        $this->specify('when a invalid website is the value will be empty', function () {
            $value = new Website('example.com');
            verify($value)->equals('');
        });

        $this->specify('when a invalid website is set url and name will return false', function () {
            $value = new Website('example.com');
            verify($value->url())->false();
            verify($value->name())->false();
        });

        $this->specify('only http urls are accepted as valid for the website', function () {
            $value = new Website('ssh://example.com');
            verify($value)->equals('');
            verify($value->url())->false();
            verify($value->name())->false();
        });
    }
}
