<?php

declare (strict_types = 1);

namespace FunWithFunctions\Types;

final class Some implements Maybe
{
    private $x;

    public function __construct($x)
    {
        $this->x = $x;
    }

    public function map(callable $f) : Some
    {
        return new self($f($this->x));
    }
}
