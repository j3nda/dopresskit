<?php

use PHPUnit\Framework\TestCase;

class PresskitTest extends TestCase
{
    private $presskit;

    use Codeception\Specify;

    public function setUp()
    {
        $this->presskit = new Presskit\Presskit;
    }

    public function testFileParsing()
    {
        $this->specify('a file has to exist', function () {
            verify($this->presskit->parse('/file/not/found'))->false();
        });

        $this->specify('a file has to be xml', function () {
            verify($this->presskit->parse(__DIR__ . '/PresskitTest.php'))->false();
        });

        $this->specify('a xml file is accepted', function () {
            verify($this->presskit->parse(__DIR__ . '/fixtures/data.xml'))->notEquals(false);
        });
    }
}
