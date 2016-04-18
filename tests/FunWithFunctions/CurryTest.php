<?php

namespace FunWithFunctions\Tests;

use function FunWithFunctions\curry;

class CurryTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_return_callable()
    {
        $f = function () { return 42; };

        $g = curry($f);

        $this->assertIsCallable($g);
    }

    /** @test */
    public function it_returns_function_that_applied_returns_callable()
    {
        $f = function () { return 42; };

        $g = curry($f);

        $h = $g();

        $this->assertIsCallable($h);
    }

    /**
     * @test
     * @dataProvider functions
     */
    public function it_returns_function_that_is_applied_in_two_steps(
        $f,
        $firstApplicationArguments,
        $secondApplicationArguments,
        $expected
    ) {
        $g = curry($f);

        $this->assertEquals($expected, $g(...$firstApplicationArguments)(...$secondApplicationArguments));
    }

    /** @test */
    public function it_returns_function_that_can_be_curried()
    {
        $f = function ($x, $y, $z) {
            return $x + $y + $z;
        };

        $g = curry(curry($f));

        $this->assertIsCallable($g);
        $this->assertIsCallable($g(1));
        $this->assertIsCallable($g(1)(2));
        $this->assertEquals(42, $g(1)(2)(39));
    }

    public function functions()
    {
        return [
            [
                function () { return 42; },
                [],
                [],
                42,
            ],
            [
                function ($x) { return 21 + $x; },
                [21],
                [],
                42,
            ],
            [
                function ($x) { return 21 + $x; },
                [],
                [21],
                42,
            ],
            [
                function ($x, $y) { return $x + $y; },
                [20],
                [22],
                42,
            ],
            [
                function ($x, $y) { return $x + $y; },
                [20, 22],
                [],
                42,
            ],
            [
                function ($x, $y) { return $x + $y; },
                [],
                [20, 22],
                42,
            ],
            [
                function ($x, $y, $z) { return $x + $y + $z; },
                [1, 1],
                [40],
                42,
            ],
            [
                function ($x, $y, $z) { return $x + $y + $z; },
                [40],
                [1, 1],
                42,
            ],
        ];
    }

    private function assertIsCallable($actual)
    {
        $this->assertTrue(is_callable($actual));
    }
}
