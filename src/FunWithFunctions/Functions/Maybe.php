<?php

declare (strict_types = 1);

namespace FunWithFunctions\Functions;

use FunWithFunctions\Types\Maybe\None;
use FunWithFunctions\Types\Maybe\Some;

function Some($x) : Some
{
    return new Some($x);
}

function None() : None
{
    return new None();
}
