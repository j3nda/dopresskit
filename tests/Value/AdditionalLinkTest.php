<?php

use PHPUnit\Framework\TestCase;

use Presskit\Value\AdditionalLink;

class AdditionalLinkTest extends TestCase
{
    use Codeception\Specify;

    public function testValue()
    {
        $this->specify('a additional link can be set and read', function () {
            $value = new AdditionalLink('Title', 'Description', 'http://www.example.com/');
            verify($value)->equals('Title - Description (http://www.example.com/)');
            verify($value->title())->equals('Title');
            verify($value->description())->equals('Description');
            verify($value->website())->equals('example.com (http://www.example.com/)');
        });

        $this->specify('when a empty title is set the additional link will be empty', function () {
            $value = new AdditionalLink('', 'Description', 'http://www.example.com/');
            verify($value)->equals('');
            verify($value->title())->equals('');
            verify($value->description())->equals('');
            verify($value->website())->equals('');
        });

        $this->specify('when a empty description is set the additional link will be empty', function () {
            $value = new AdditionalLink('Title', '', 'http://www.example.com/');
            verify($value)->equals('');
            verify($value->title())->equals('');
            verify($value->description())->equals('');
            verify($value->website())->equals('');
        });

        $this->specify('when a empty website is set the additional link will be empty', function () {
            $value = new AdditionalLink('Title', 'Description', '');
            verify($value)->equals('');
            verify($value->title())->equals('');
            verify($value->description())->equals('');
            verify($value->website())->equals('');
        });
    }
}
