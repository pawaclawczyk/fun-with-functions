<?php

declare (strict_types = 1);

namespace FunWithFunctions\Types\Either;

final class Left extends Either
{
}

function Left($value) : Left
{
    return new Left($value);
}
