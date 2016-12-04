<?php

use PHPUnit\Framework\TestCase;

use Presskit\Value\Award;

class AwardTest extends TestCase
{
    use Codeception\Specify;

    public function testValue()
    {
        $this->specify('a award can be set and read', function () {
            $value = new Award('Award', 'Description');
            verify($value)->equals('Award (Description)');
            verify($value->award())->equals('Award');
            verify($value->description())->equals('Description');
        });

        $this->specify('when a empty award is set the award will be empty', function () {
            $value = new Award('', 'Description');
            verify($value)->equals('');
            verify($value->award())->equals('');
            verify($value->description())->equals('');
        });

        $this->specify('when a empty description is set the award will be empty', function () {
            $value = new Award('Award', '');
            verify($value)->equals('');
            verify($value->award())->equals('');
            verify($value->description())->equals('');
        });
    }
}
