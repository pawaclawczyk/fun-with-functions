<?php

declare (strict_types = 1);

namespace FunWithFunctions\Functions;

function map($f)
{
    return function ($x) use ($f) {
        return is_object($x) ? $x->map($f) : array_map($f, $x);
    };
};
