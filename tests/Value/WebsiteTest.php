<?php

use PHPUnit\Framework\TestCase;

use Presskit\Value\Website;

class WebsiteTest extends TestCase
{
    use Codeception\Specify;

    public function testValue()
    {
        $this->specify('website can be set and read', function () {
            $value = new Website('http://www.example.com/Test');
            verify($value)->equals('example.com (http://www.example.com/Test)');
            verify($value->url())->equals('http://www.example.com/Test');
            verify($value->name())->equals('example.com');
            verify($value->path())->equals('/Test');
        });

        $this->specify('when a empty website is set the value will be empty', function () {
            $value = new Website('');
            verify($value)->equals('');
        });

        $this->specify('when a empty website is set url and name will return false', function () {
            $value = new Website('');
            verify($value->url())->equals('');
            verify($value->name())->equals('');
        });

        $this->specify('when a null website is set the value will be empty', function () {
            $value = new Website(null);
            verify($value)->equals('');
        });

        $this->specify('when a null website is set url and name will return false', function () {
            $value = new Website(null);
            verify($value->url())->equals('');
            verify($value->name())->equals('');
        });

        $this->specify('when a invalid website is set the value will be empty', function () {
            $value = new Website('example.com');
            verify($value)->equals('');
        });

        $this->specify('when a invalid website is set the url and name will return false', function () {
            $value = new Website('example.com');
            verify($value->url())->equals('');
            verify($value->name())->equals('');
        });

        $this->specify('only http urls are accepted as valid for the website', function () {
            $value = new Website('ssh://example.com');
            verify($value)->equals('');
            verify($value->url())->equals('');
            verify($value->name())->equals('');
        });
    }
}
