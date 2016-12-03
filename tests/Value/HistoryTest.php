<?php

use PHPUnit\Framework\TestCase;

use Presskit\Value\History;

class HistoryTest extends TestCase
{
    use Codeception\Specify;

    public function testValue()
    {
        $this->specify('history can be set and read', function () {
            $value = new History('Heading', 'Body');
            verify($value)->equals('Heading: Body');
            verify($value->heading())->equals('Heading');
            verify($value->body())->equals('Body');
        });

        $this->specify('when a empty heading is set the history will be empty', function () {
            $value = new History('', 'Body');
            verify($value)->equals('');
            verify($value->heading())->equals('');
            verify($value->body())->equals('');
        });

        $this->specify('when a empty body is set the history will be empty', function () {
            $value = new History('Heading', '');
            verify($value)->equals('');
            verify($value->heading())->equals('');
            verify($value->body())->equals('');
        });
    }
}
