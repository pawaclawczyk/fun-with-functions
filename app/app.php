<?php

use function FunWithFunctions\curry;
use function FunWithFunctions\Functions\None;
use function FunWithFunctions\Functions\Some;
use function FunWithFunctions\compose;
use function FunWithFunctions\composeN;
use function FunWithFunctions\Functions\map;
use function FunWithFunctions\Functions\add;
use function FunWithFunctions\Functions\square;
use function FunWithFunctions\Functions\sub;
use function FunWithFunctions\Functions\neg;
use function FunWithFunctions\Types\Either\Left;
use function FunWithFunctions\Types\Either\Right;
use function FunWithFunctions\Types\Safe\Success;
use function FunWithFunctions\Types\Safe\Failure;

$loader = require __DIR__.'/../vendor/autoload.php';

function printTitle($title)
{
    echo "\n+++ $title +++\n\n";
}

function printLn($line)
{
    echo "$line\n";
}

printTitle('Currying');
echo '2 + 3 = ';

// (Int, Int) -> Int
$addTwoArguments = function ($a, $b) {
    return $a + $b;
};

// Int -> Int -> Int
$curriedAddTwoArguments = curry($addTwoArguments);

dump($curriedAddTwoArguments(2)(3));

echo '2 + 3 + 4 = ';

// (Int, Int, Int) -> Int
$addThreeArguments = function ($a, $b, $c) {
    return $a + $b + $c;
};

// Int -> Int -> Int -> Int
$curriedAddThreeArguments = curry(curry($addThreeArguments));

dump($curriedAddThreeArguments(2)(3)(4));

printTitle('Composition');

$compositionA = compose(map(add(5)), map(neg));
$compositionB = map(compose(add(5), square));

printLn('compose(map(add(5)), map(square))([1, 2, 3, 4, 5, 6, 7, 8, 9])');

dump($compositionA([1, 2, 3, 4, 5, 6, 7, 8, 9]));

printLn('map(compose(add(5), square))([1, 2, 3, 4, 5, 6, 7, 8, 9])');

dump($compositionB([1, 2, 3, 4, 5, 6, 7, 8, 9]));

$composition = composeN(sub(3), neg, add(2), square);

printLn('composeN(add(4), neg, sub(2), sqrt)(5)');

dump($composition(5));

printTitle('Maybe[Some, None]');

$withdraw = curry(function ($amount, $balance) { return $amount > $balance ? None() : Some($balance - $amount); });
$returnPercent = curry(function ($percent, $amount, $balance) { return $balance + ($percent / 100) * $amount; });

$getTwenty = compose(map($returnPercent(5, 20)), $withdraw(20));

dump($getTwenty(100));

dump($getTwenty(10));

printTitle('Either[Left, Right]');

printLn("Left('Water')->left()->map(strlen)");
dump(Left('Water')->left()->map(strlen));

printLn('Right(42)->left()->map(square)');
dump(Right(42)->left()->map(square));

printLn("Left('Water')->right()->map(strlen)");
dump(Left('Water')->right()->map(strlen));

printLn('Right(42)->right()->map(square)');
dump(Right(42)->left()->map(square));

printTitle('Safe[Success, Failure]');

$onlyPositive = function ($x) {
    if (0 <= $x) {
        return $x;
    } else {
        throw new \Exception('Number has to be positive!.');
    }
};

printLn('Success(5)->map(square)');
dump(Success(5)->map(square));

printLn("Failure('ERROR !!!')->map(square)");
dump(Failure('ERROR !!!')->map(square));

printLn('$onlyPositive(x) throw exception if x < 0');
printLn('map(compose(square, $onlyPositive))(Success(5))');

dump(map(compose(square, $onlyPositive))(Success(5)));

printLn('map(compose(square, $onlyPositive))(Success(-5))');

dump(map(compose(square, $onlyPositive))(Success(-5)));
