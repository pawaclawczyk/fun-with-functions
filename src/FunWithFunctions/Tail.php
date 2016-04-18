<?php

function tail($xs)
{
    return array_values(array_filter($xs, function ($k) { return 0 !== $k; }, ARRAY_FILTER_USE_KEY));
}
