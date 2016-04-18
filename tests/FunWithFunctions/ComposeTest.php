<?php

namespace FunWithFunctions\Tests;

use function FunWithFunctions\compose;
use function FunWithFunctions\composeN;

class ComposeTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_returns_callable()
    {
        $f = function ($x) { return $x; };
        $g = function ($x) { return 2 * $x; };

        $h = compose($f, $g);

        $this->assertIsCallable($h);
    }

    /** @test */
    public function it_applies_both_functions_from_right_side()
    {
        $f = function ($x) { return $x + 2; };
        $g = function ($x) { return 2 * $x; };

        $h = compose($f, $g);

        $this->assertEquals(42, $h(20));
    }

    /** @test */
    public function it_returns_function_that_takes_same_number_of_arguments_as_the_right_function()
    {
        $f = function ($x) { return $x + 2; };
        $g = function ($x, $y) { return $x + $y; };

        $h = compose($f, $g);

        $this->assertEquals(42, $h(18, 22));
    }

    /** @test */
    public function left_function_in_composition_should_have_one_argument()
    {
        $f = function ($x, $y) { return $x + $y; };
        $g = function ($x) { return $x; };

        $h = compose($f, $g);

        try {
            $h(42);
        } catch (\PHPUnit_Framework_Error_Warning $w) {
        }
    }

    /** @test */
    public function right_function_can_return_collection()
    {
        $f = function ($xs) { return $xs[2]; };
        $g = function ($x) { return [$x, $x * $x, $x * $x * $x]; };

        $h = compose($f, $g);

        $this->assertEquals(27, $h(3));
    }

    /** @test */
    public function composition_can_have_more_than_two_functions()
    {
        $f = function ($x) { return $x + 1; };
        $g = function ($x) { return $x * 2; };
        $h = function ($x) { return -$x; };

        $z = composeN($h, $g, $f);

        $this->assertIsCallable($z);

        $this->assertEquals(-8, $z(3));
    }

    private function assertIsCallable($actual)
    {
        $this->assertTrue(is_callable($actual));
    }
}
