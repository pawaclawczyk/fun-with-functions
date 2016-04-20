<?php

declare (strict_types = 1);

namespace FunWithFunctions\Types\Maybe;

interface Maybe
{
    public function map(callable $f);
}
