<?php

use PHPUnit\Framework\TestCase;

class PresskitTest extends TestCase
{
    use Codeception\Specify;

    private function createPresskit()
    {
        return new Presskit\Presskit;
    }

    public function testFileParsing()
    {
        $this->specify('file has to exist', function () {
            $presskit = $this->createPresskit();
            verify($presskit->parse('/file/not/found'))->false();
        });

        $this->specify('file has to be xml', function () {
            $presskit = $this->createPresskit();
            verify($presskit->parse(__DIR__ . '/PresskitTest.php'))->false();
        });

        $this->specify('xml files are accepted', function () {
            $presskit = $this->createPresskit();
            verify($presskit->parse(__DIR__ . '/fixtures/normal.xml'))->isInstanceOf('Presskit\Content');
        });
    }
}
