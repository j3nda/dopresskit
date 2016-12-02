<?php

use PHPUnit\Framework\TestCase;

use Presskit\Value\Text;

class TextTest extends TestCase
{
    use Codeception\Specify;

    public function testValue()
    {
        $this->specify('text can be set and read', function () {
            $value = new Text('Test');
            verify($value)->equals('Test');
        });

        $this->specify('non-empty text is always a string', function () {
            $value = new Text(100);
            verify($value)->notInternalType('string');
        });

        $this->specify('when a empty value is set the value will be empty', function () {
            $value = new Text('');
            verify($value)->equals('');
        });

        $this->specify('when a null value is set the value will be empty', function () {
            $value = new Text(null);
            verify($value)->equals('');
        });
    }
}
