<?php
declare(strict_types=1);
// First task
function minValue(float $x, float $y, float $z): float
{
    switch (true) {
        case $x < $y && $x < $z:
            return $x;
        case $y < $x && $y < $z:
            return $y;
        case $z < $x && $z < $y:
            return $z;
    }
}

// Second task
function multiplyByTwo(float &$x, float &$y): void
{
    $x *= 2;
    $y *= 2;
}

// Third task
function factorial(int $x): int
{
    if ($x === 0) {
        return 1;
    }
    return $x * factorial($x - 1);
}

// Fourth task
function printNumbers(int $x): void
{
    if ($x > 0) {
        printNumbers($x - 1);
        echo $x . ' ';
    }
}