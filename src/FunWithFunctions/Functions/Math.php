<?php

declare (strict_types = 1);

namespace FunWithFunctions\Functions;

define('square', 'FunWithFunctions\Functions\square');
define('add',    'FunWithFunctions\Functions\add');
define('sub',    'FunWithFunctions\Functions\sub');
define('neg',    'FunWithFunctions\Functions\neg');

function square($x)
{
    return $x * $x;
}

function add($y)
{
    return function ($x) use ($y) {
        return $x + $y;
    };
}

function sub($y)
{
    return function ($x) use ($y) {
        return $x - $y;
    };
}

function neg($x)
{
    return -$x;
}
