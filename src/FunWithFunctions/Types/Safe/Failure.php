<?php

declare (strict_types = 1);

namespace FunWithFunctions\Types\Safe;

final class Failure extends Safe
{
    public function map(callable $function) : Failure
    {
        return $this;
    }
}

function Failure($value) : Failure
{
    return new Failure($value);
}
