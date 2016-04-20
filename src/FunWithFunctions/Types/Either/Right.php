<?php

declare (strict_types = 1);

namespace FunWithFunctions\Types\Either;

final class Right extends Either
{
}

function Right($value) : Right
{
    return new Right($value);
}
