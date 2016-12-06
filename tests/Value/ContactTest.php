<?php

use PHPUnit\Framework\TestCase;

use Presskit\Value\Contact;

class ContactTest extends TestCase
{
    use Codeception\Specify;

    public function testValue()
    {
        $this->specify('a contact can be set and read', function () {
            $value = new Contact('Name', 'http://www.example.com/', 'test@example.com');
            verify($value)->equals('Name (http://www.example.com/)');
            verify($value->name())->equals('Name');
            verify($value->uri())->equals('http://www.example.com/');
            verify($value->website())->equals('example.com (http://www.example.com/)');
            verify($value->email())->equals('test@example.com');
        });

        $this->specify('when a empty name is set the contact will be empty', function () {
            $value = new Contact('', 'http://www.example.com/', 'test@example.com');
            verify($value)->equals('');
            verify($value->name())->equals('');
            verify($value->uri())->equals('');
            verify($value->website())->equals('');
            verify($value->email())->equals('');
        });

        $this->specify('when a contact lacks both a URI and email it will be empty', function () {
            $value = new Contact('Name', '', '');
            verify($value)->equals('');
            verify($value->name())->equals('');
            verify($value->uri())->equals('');
            verify($value->website())->equals('');
            verify($value->email())->equals('');
        });

        $this->specify('a contact can handle a missing URI if it has a email address', function () {
            $value = new Contact('Name', '', 'test@example.com');
            verify($value->name())->equals('Name');
            verify($value->uri())->equals('');
            verify($value->website())->equals('');
            verify($value->email())->equals('test@example.com');
        });

        $this->specify('a contact can handle a missing email address if it has a URI', function () {
            $value = new Contact('Name', 'http://www.example.com/', '');
            verify($value->name())->equals('Name');
            verify($value->uri())->equals('http://www.example.com/');
            verify($value->website())->equals('example.com (http://www.example.com/)');
            verify($value->email())->equals('');
        });
    }
}
