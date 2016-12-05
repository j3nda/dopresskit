<?php

use PHPUnit\Framework\TestCase;

use Presskit\Value\Credit;

class CreditTest extends TestCase
{
    use Codeception\Specify;

    public function testValue()
    {
        $this->specify('credit can be set and read', function () {
            $value = new Credit('Name', 'Role', 'http://www.example.com/');
            verify($value)->equals('Name - Role (http://www.example.com/)');
            verify($value->name())->equals('Name');
            verify($value->role())->equals('Role');
            verify($value->website())->equals('example.com (http://www.example.com/)');
        });

        $this->specify('when a empty name is set the credit will be empty', function () {
            $value = new Credit('', 'Role', 'http://www.example.com/');
            verify($value)->equals('');
            verify($value->name())->equals('');
            verify($value->role())->equals('');
            verify($value->website())->equals('');
        });

        $this->specify('when a empty role is set the credit link be empty', function () {
            $value = new Credit('Name', '', 'http://www.example.com/');
            verify($value)->equals('');
            verify($value->name())->equals('');
            verify($value->role())->equals('');
            verify($value->website())->equals('');
        });

        $this->specify('the website is optional in a credit', function () {
            $value = new Credit('Name', 'Role', '');
            verify($value)->equals('Name - Role');
            verify($value->name())->equals('Name');
            verify($value->role())->equals('Role');
            verify($value->website())->equals('');
        });
    }
}
