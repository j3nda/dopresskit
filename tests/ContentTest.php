<?php

use PHPUnit\Framework\TestCase;

class ContentTest extends TestCase
{
    use Codeception\Specify;

    private function createContent()
    {
        return new Presskit\Content;
    }

    public function testTitle()
    {
        $this->specify('title can be set', function () {
            $content = $this->createContent();
            verify($content->setTitle('A Title'))->isEmpty();
        });

        $this->specify('title can be read', function () {
            $content = $this->createContent();
            $content->setTitle('Another Title');
            verify($content->getTitle())->equals('Another Title');
        });

        $this->specify('a non-empty title is always a string', function () {
            $content = $this->createContent();
            $content->setTitle(100);
            verify($content->getTitle())->internalType('string');
        });

        $this->specify('when a title is not set getTitle will return false', function () {
            $content = $this->createContent();
            verify($content->getTitle())->false();
        });

        $this->specify('when a empty title is set getTitle will return false', function () {
            $content = $this->createContent();
            $content->setTitle('');
            verify($content->getTitle())->false();
        });

        $this->specify('when a null title is set getTitle will return false', function () {
            $content = $this->createContent();
            $content->setTitle(null);
            verify($content->getTitle())->false();
        });
    }
}
