<?php

declare (strict_types = 1);

namespace FunWithFunctions\Types\Maybe;

class None implements Maybe
{
    public function map(callable $f) : None
    {
        return $this;
    }
}
