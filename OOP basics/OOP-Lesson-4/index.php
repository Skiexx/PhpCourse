<?php

require_once 'Circle.php';
require_once 'Square.php';
require_once 'Rectangle.php';

$objects = [
    new Circle(5),
    new Square(5),
    new Rectangle(5, 10),
];

foreach ($objects as $object) {
    if ($object instanceof CalculateSquare) {
        echo 'Обьект реализует интерфейс CalculateSquare. Является обьектом класса ' . get_class($object) . '. Площадь: ' . $object->calculateSquare() . PHP_EOL;
    } else {
        echo 'Обьект класса ' . get_class($object) . ' не реализует интерфейс CalculateSquare' . PHP_EOL;
    }
}