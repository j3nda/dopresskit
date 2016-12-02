<?php

use PHPUnit\Framework\TestCase;

use Presskit\Value\URI;

class URITest extends TestCase
{
    use Codeception\Specify;

    public function testValue()
    {
        $this->specify('URI can be set and read', function () {
            $value = new URI('http://www.example.com/');
            verify($value)->equals('http://www.example.com/');
        });

        $this->specify('when a empty URI is set the URI will be empty', function () {
            $value = new URI('');
            verify($value)->equals('');
        });

        $this->specify('when a null URI is set the URI will be empty', function () {
            $value = new URI(null);
            verify($value)->equals('');
        });

        $this->specify('when a invalid URI is given the URI will be empty', function () {
            $value = new URI('example.com');
            verify($value)->equals('');
        });

        $this->specify('URI accepts non-http URLs', function () {
            $value = new URI('ssh://example.com');
            verify($value)->equals('ssh://example.com');
        });

        $this->specify('URI accepts callto: URIs', function () {
            $value = new URI('callto:Example');
            verify($value)->equals('callto:Example');
        });
    }
}
