<?php

require_once 'CalculateSquare.php';

class Circle implements CalculateSquare
{
    const PI = 3.1416;

    private $r;

    public function calculateSquare(): float {
        return self::PI * ($this->r ** 2);
    }

    public function __construct($r) {
        $this->r = $r;
    }
}