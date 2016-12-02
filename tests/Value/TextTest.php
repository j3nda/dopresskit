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
            verify($value->get())->equals('Test');
        });

        $this->specify('non-empty text is always a string', function () {
            $value = new Text(100);
            verify($value->get())->internalType('string');
        });

        $this->specify('when a empty value is set get will return false', function () {
            $value = new Text('');
            verify($value->get())->false();
        });

        $this->specify('when a null value is set get will return false', function () {
            $value = new Text(null);
            verify($value->get())->false();
        });
    }
}
