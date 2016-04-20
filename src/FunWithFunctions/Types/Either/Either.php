<?php

declare (strict_types = 1);

namespace FunWithFunctions\Types\Either;

use FunWithFunctions\Types\Container;

abstract class Either
{
    use Container;

    public function right() : RightProjection
    {
        return new RightProjection($this);
    }

    public function left() : LeftProjection
    {
        return new LeftProjection($this);
    }
}
