<?php

use PHPUnit\Framework\TestCase;

use Presskit\Value\Quote;

class QuoteTest extends TestCase
{
    use Codeception\Specify;

    public function testValue()
    {
        $this->specify('a quote can be set and read', function () {
            $value = new Quote('Description', 'Name', 'http://www.example.com/', 'Example');
            verify($value)->equals('Description - Name (http://www.example.com/)');
            verify($value->description())->equals('Description');
            verify($value->name())->equals('Name');
            verify($value->website())->equals('example.com (http://www.example.com/)');
            verify($value->websiteName())->equals('Example');
        });

        $this->specify('when a empty description is set the quote will be empty', function () {
            $value = new Quote('', 'Name', 'http://www.example.com/', 'Example');
            verify($value)->equals('');
            verify($value->name())->equals('');
            verify($value->description())->equals('');
            verify($value->website())->equals('');
            verify($value->websiteName())->equals('');
        });

        $this->specify('when a name description is set the quote will be empty', function () {
            $value = new Quote('Description', '', 'http://www.example.com/', 'Example');
            verify($value)->equals('');
            verify($value->name())->equals('');
            verify($value->description())->equals('');
            verify($value->website())->equals('');
            verify($value->websiteName())->equals('');
        });

        $this->specify('when a empty website is set website and websiteName will be empty', function () {
            $value = new Quote('Description', 'Name', '', 'Example');
            verify($value)->equals('Description - Name');
            verify($value->description())->equals('Description');
            verify($value->name())->equals('Name');
            verify($value->website())->equals('');
            verify($value->websiteName())->equals('');
        });

        $this->specify('when a empty websiteName is set website and websiteName will be empty', function () {
            $value = new Quote('Description', 'Name', 'http://www.example.com/', '');
            verify($value)->equals('Description - Name');
            verify($value->description())->equals('Description');
            verify($value->name())->equals('Name');
            verify($value->website())->equals('');
            verify($value->websiteName())->equals('');
        });
    }
}
