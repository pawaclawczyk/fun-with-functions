<?php

declare (strict_types = 1);

namespace FunWithFunctions\Types\Either;

final class RightProjection
{
    private $either;

    public function __construct(Either $either)
    {
        $this->either = $either;
    }

    public function map(callable $function) : Either
    {
        if ($this->either instanceof Right) {
            return new Right($function($this->either->value()));
        } else {
            return $this->either;
        }
    }
}
