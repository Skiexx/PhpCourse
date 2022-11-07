<?php

$carsSpeeds = [
    30,
    60,
    90,
];

$averageSpeed = array_sum($carsSpeeds) / count($carsSpeeds); // для слабых

$sumOfSpeeds = 0;
$countOfCars = 0;

foreach ($carsSpeeds as $speed) {
    $sumOfSpeeds += $speed;
    $countOfCars++;
}

$averageSpeed = $sumOfSpeeds / $countOfCars; // для сильных