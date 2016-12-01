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
        $this->specify('a title can be set', function() {
            verify($this->content->setTitle('A Title'))->isEmpty();
        });

        $this->specify('a title can be read', function() {
            $this->content->setTitle('Another Title');
            verify($this->content->getTitle())->equals('Another Title');
        });

        $this->specify('a title is always a string', function() {
            $this->content->setTitle(100);
            verify($this->content->getTitle())->internalType('string');
        });
    }
}
