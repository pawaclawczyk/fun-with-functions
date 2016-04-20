<?php

declare (strict_types = 1);

namespace FunWithFunctions\Types;

interface Maybe
{
    public function map(callable $f);
}
