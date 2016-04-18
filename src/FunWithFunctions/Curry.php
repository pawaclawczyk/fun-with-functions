<?php

namespace FunWithFunctions;

function curry($f)
{
    return function (...$args) use ($f) {
        return function ($x) use ($f, $args) {
            $args[] = $x;

            return $f(...$args);
        };
    };
}
