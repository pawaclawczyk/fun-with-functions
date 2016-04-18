<?php

namespace FunWithFunctions;

function compose($f, $g)
{
    return function (...$args) use ($f, $g) {
        return $f($g(...$args));
    };
}

function composeN(...$fs)
{
    if (1 === count($fs)) {
        return compose(head($fs), id);
    } elseif (2 === count($fs)) {
        return compose(head($fs), head(tail($fs)));
    } else {
        return composeN(
            compose(
                head($fs),
                head(tail($fs))
            ),
            ...tail(
                tail($fs)
            )
        );
    }
};
