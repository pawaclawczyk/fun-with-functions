<?php

namespace FunWithFunctions;

function curry($f)
{
    return function (...$leftArgs) use ($f) {
        return function (...$rightArgs) use ($f, $leftArgs) {
            return $f(...array_merge($leftArgs, $rightArgs));
        };
    };
}
