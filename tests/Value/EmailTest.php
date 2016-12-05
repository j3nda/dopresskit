<?php

use PHPUnit\Framework\TestCase;

use Presskit\Value\Email;

class EmailTest extends TestCase
{
    use Codeception\Specify;

    public function testValue()
    {
        $this->specify('email can be set and read', function () {
            $value = new Email('test@example.com');
            verify($value)->equals('test@example.com');
        });

        $this->specify('when a empty email address is set the value will be empty', function () {
            $value = new Email('');
            verify($value)->equals('');
        });

        $this->specify('when a null email address is set the value will be empty', function () {
            $value = new Email(null);
            verify($value)->equals('');
        });

        $this->specify('when a invalid email address is set the value will be empty', function () {
            $value = new Email('example.com');
            verify($value)->equals('');
        });
    }
}
