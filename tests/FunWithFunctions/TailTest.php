<?php

namespace FunWithFunctions\Tests;

use function FunWithFunctions\tail;

class TailTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_returns_tail_of_collection()
    {
        $xs = [11, 22, 33];

        $this->assertEquals([22, 33], tail($xs));
    }
}
