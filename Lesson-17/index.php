<?php

function foundNumber(array $numbers, int $number): bool
{
    if (in_array($number, $numbers, true)) {
        return true;
    }

    return false;
}

function countOfNumberInArray(array $numbers, int $number): int
{
    $count = 0;

    foreach ($numbers as $value) {
        if ($value === $number) {
            $count++;
        }
    }

    return $count;
}