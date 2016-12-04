<?php

use PHPUnit\Framework\TestCase;

use Presskit\Value\TrailerLocation;

class TrailerLocationTest extends TestCase
{
    use Codeception\Specify;

    public function testValue()
    {
        $this->specify('location can be set and read', function () {
            $value = new TrailerLocation('Format', 'Path');
            verify($value)->equals('format (Path)');
            verify($value->format())->equals('format');
            verify($value->path())->equals('Path');
        });

        $this->specify('the format will be converted to lower case', function () {
            $value = new TrailerLocation('Format', 'Path');
            verify($value->format())->equals('format');
        });

        $this->specify('the youtube format return a correct string', function () {
            $value = new TrailerLocation('youtube', '12345');
            verify($value)->equals('https://www.youtube.com/watch?v=12345');
        });

        $this->specify('the vimeo format return a correct string', function () {
            $value = new TrailerLocation('vimeo', '12345');
            verify($value)->equals('https://vimeo.com/12345');
        });

        $this->specify('the mov format return a correct string', function () {
            $value = new TrailerLocation('mov', '12345');
            verify($value)->equals('12345.mov');
        });

        $this->specify('the mp4 format return a correct string', function () {
            $value = new TrailerLocation('mp4', '12345');
            verify($value)->equals('12345.mp4');
        });

        $this->specify('when a empty format is set the trailer location will be empty', function () {
            $value = new TrailerLocation('', 'Path');
            verify($value)->equals('');
        });

        $this->specify('when a null format is set the trailer location will be empty', function () {
            $value = new TrailerLocation(null, 'Path');
            verify($value)->equals('');
        });

        $this->specify('when a empty path is set the trailer location will be empty', function () {
            $value = new TrailerLocation('Format', '');
            verify($value)->equals('');
        });

        $this->specify('when a null path is set the trailer location will be empty', function () {
            $value = new TrailerLocation('Format', null);
            verify($value)->equals('');
        });
    }
}
