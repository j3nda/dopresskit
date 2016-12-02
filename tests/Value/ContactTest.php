<?php

use PHPUnit\Framework\TestCase;

use Presskit\Value\Contact;

class ContactTest extends TestCase
{
    use Codeception\Specify;

    public function testValue()
    {
        $this->specify('a contact can be set and read', function () {
            $value = new Contact('Name', 'http://www.example.com/');
            verify($value)->equals('Name (http://www.example.com/)');
            verify($value->name())->equals('Name');
            verify($value->uri())->equals('http://www.example.com/');
        });

        $this->specify('when a empty name is set the contact will be empty', function () {
            $value = new Contact('', 'http://www.example.com/');
            verify($value)->equals('');
            verify($value->name())->equals('');
            verify($value->uri())->equals('');
        });

        $this->specify('when a empty URI is set the contact will be empty', function () {
            $value = new Contact('Name', '');
            verify($value)->equals('');
            verify($value->name())->equals('');
            verify($value->uri())->equals('');
        });
    }
}
