<?php

namespace FunWithFunctions;

function compose($f, $g)
{
    return function (...$args) use ($f, $g) {
        return $f($g(...$args));
    };
}

function composeN(...$functions)
{
    $first = head;
    $second = compose(head, tail);
    $rest = compose(tail, tail);
    $composeLeftmostTwo = compose($first($functions), $second($functions));

    if (count($functions) > 2) {
        return composeN($composeLeftmostTwo, ...$rest($functions));
    } else {
        return $composeLeftmostTwo;
    }
};
