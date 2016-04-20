<?php

declare (strict_types = 1);

namespace FunWithFunctions\Functions;

use FunWithFunctions\Types\None;
use FunWithFunctions\Types\Some;

function Some($x) : Some
{
    return new Some($x);
}

function None() : None
{
    return new None();
}
