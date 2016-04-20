<?php

declare (strict_types = 1);

namespace FunWithFunctions\Types\Safe;

use FunWithFunctions\Types\Container;

abstract class Safe
{
    use Container;

    abstract public function map(callable $function);
}
