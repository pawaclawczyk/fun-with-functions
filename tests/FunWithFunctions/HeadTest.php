<?php

namespace FunWithFunctions\Tests;

use function FunWithFunctions\head;

class HeadTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_returns_first_element_of_collection()
    {
        $xs = [11, 22, 33];

        $this->assertEquals(11, head($xs));
    }
}
