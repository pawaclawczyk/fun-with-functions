<?php

namespace FunWithFunctions\Tests;

use function FunWithFunctions\id;

class IdTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider arguments
     */
    public function it_returns_what_it_takes_as_argument($argument)
    {
        $y = id($argument);

        $this->assertEquals($argument, $y);
    }

    public function arguments()
    {
        return [
            [null],
            [42],
            [4.2],
            ['a'],
            ['text'],
            [new \stdClass()],
        ];
    }
}
