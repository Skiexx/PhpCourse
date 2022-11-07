<?php

// First task
$array = [1, 3, 2];

sort($array);
$string = implode(':', $array);

// Second task
function getArray(array $array):array {
    return [$array[1], $array[2], $array[3]];
}

$array = [1, 2, 3, 4, 5];