<?php

use function FunWithFunctions\curry;

$loader = require __DIR__.'/../vendor/autoload.php';

echo '2 + 3 = ';

// (Int, Int) -> Int
$addTwoArguments = function($a, $b) {
    return $a + $b;
};

// Int -> Int -> Int
$curriedAddTwoArguments = curry($addTwoArguments);

echo $curriedAddTwoArguments(2)(3);

echo "\n";

echo '2 + 3 + 4 = ';

// (Int, Int, Int) -> Int
$addThreeArguments = function ($a, $b, $c) {
    return $a + $b + $c;
};

// Int -> Int -> Int -> Int
$curriedAddThreeArguments = curry(curry($addThreeArguments));

echo $curriedAddThreeArguments(2)(3)(4);

echo "\n";

// Callable -> [A] -> [B]
$map = curry(array_map);

// Int -> Int
$square = function ($x) { return $x * $x; };

// Int -> _
$echo = function ($x) { echo $x."\n"; };

// [Int] -> [Int]
$mapToSquares = $map($square);

// [A] -> _
$echoAll = $map($echo);

$echoAll($mapToSquares([1, 2, 3, 4, 5, 6, 7, 8, 9]));
