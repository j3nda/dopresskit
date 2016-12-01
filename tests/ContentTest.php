<?php

use PHPUnit\Framework\TestCase;

class ContentTest extends TestCase
{
    private $content;

    use Codeception\Specify;

    public function setUp()
    {
        $this->content = new Presskit\Content;
    }

    public function testTitle()
    {
        $this->specify('title can be set', function () {
            verify($this->content->setTitle('A Title'))->isEmpty();
        });

        $this->specify('title can be read', function () {
            $this->content->setTitle('Another Title');
            verify($this->content->getTitle())->equals('Another Title');
        });

        $this->specify('a non-empty title is always a string', function () {
            $this->content->setTitle(100);
            verify($this->content->getTitle())->internalType('string');
        });

        $this->specify('when a title is not set getTitle will return false', function () {
            $content = new Presskit\Content;
            verify($content->getTitle())->false();
        });

        $this->specify('when a empty title is set getTitle will return false', function () {
            $this->content->setTitle('');
            verify($this->content->getTitle())->false();
        });

        $this->specify('when a null title is set getTitle will return false', function () {
            $this->content->setTitle(null);
            verify($this->content->getTitle())->false();
        });
    }
}
