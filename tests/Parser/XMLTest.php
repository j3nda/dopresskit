<?php

use PHPUnit\Framework\TestCase;

class XMLTest extends TestCase
{
    private $content;
    private $XMLParser;

    use Codeception\Specify;

    public function setUp()
    {
        $this->content = new Presskit\Content;
        $this->XMLParser = new Presskit\Parser\XML(__DIR__ . '/../fixtures/normal.xml', $this->content);
    }

    public function testParsing()
    {
        $this->specify('parse returns the content object', function () {
            verify($this->XMLParser->parse())->isInstanceOf('Presskit\Content');
        });

        $this->specify('it can handle a empty xml file', function () {
            $content = new Presskit\Content;
            $XMLParser = new Presskit\Parser\XML(__DIR__ . '/../fixtures/empty.xml', $content);
            verify($XMLParser->parse())->isInstanceOf('Presskit\Content');
        });
    }

    public function testTitleParsing()
    {
        $this->specify('the title is read from the xml file', function () {
            verify($this->XMLParser->parse()->getTitle())->equals('Example Title');
        });

        $this->specify('it can handle a missing title tag', function () {
            $content = new Presskit\Content;
            $XMLParser = new Presskit\Parser\XML(__DIR__ . '/../fixtures/empty.xml', $content);
            verify($XMLParser->parse()->getTitle())->false();
        });
    }
}
