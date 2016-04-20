<?php

declare (strict_types = 1);

namespace FunWithFunctions\Types\Safe;

final class Success extends Safe
{
    public function map(callable $function) : Safe
    {
        try {
            return new self($function($this->value()));
        } catch (\Throwable $e) {
            return new Failure($e);
        }
    }
}

function Success($value) : Success
{
    return new Success($value);
}
