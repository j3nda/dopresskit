<?php

use PHPUnit\Framework\TestCase;

use Presskit\Value\Trailer;

class TrailerTest extends TestCase
{
    use Codeception\Specify;

    public function testValue()
    {
        $this->specify('trailer can be set and read', function () {
            $value = new Trailer('Test', ['youtube' => '123']);
            verify($value)->equals('Test');
        });

        $this->specify('when a empty name is set the value will be empty', function () {
            $value = new Trailer('', ['youtube' => '123']);
            verify($value)->equals('');
        });

        $this->specify('when a null name is set the value will be empty', function () {
            $value = new Trailer('', ['youtube' => '123']);
            verify($value)->equals('');
        });

        $this->specify('a trailer does not require locations', function () {
            $value = new Trailer('Test', []);
            verify($value)->equals('Test');
        });

        $this->specify('locations are ignored if they are not in a array', function () {
            $value = new Trailer('Test', 'youtube: 123');
            verify($value->locations())->count(0);
        });

        $this->specify('youtube returns a youtube id if a youtube location exists', function () {
            $value = new Trailer('Test', ['youtube' => '123']);
            verify($value->youtube())->equals('123');
        });

        $this->specify('youtube returns a empty string if a youtube location does not exist', function () {
            $value = new Trailer('Test', []);
            verify($value->youtube())->equals('');
        });

        $this->specify('vimeo returns a vimeo url if a vimeo location exists', function () {
            $value = new Trailer('Test', ['vimeo' => '123']);
            verify($value->vimeo())->equals('123');
        });

        $this->specify('vimeo returns a empty string if a vimeo location does not exist', function () {
            $value = new Trailer('Test', []);
            verify($value->vimeo())->equals('');
        });
    }
}
