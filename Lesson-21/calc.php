<?php

switch (true){
    case empty($_GET): {
        return 'Ничего не передано!';
    }
    case empty($_GET['operation']): {
        return 'Не передана операция';
    }
    case ($_GET['x1'] === '') || ($_GET['x2'] === ''): {
        return 'Не переданы аргументы';
    }
    case (!is_numeric($_GET['x1'])) || (!is_numeric($_GET['x2'])): {
        return 'Аргументы не являются числами';
    }
    default: {
        $x1 = (int)$_GET['x1'];
        $x2 = (int)$_GET['x2'];
        $operation = $_GET['operation'];
        switch ($operation){
            case '+': {
                return "$x1 + $x2 = " . $x1 + $x2;
            }
            case '-': {
                return "$x1 - $x2 = " . $x1 - $x2;
            }
            case '*': {
                return "$x1 * $x2 = " . $x1 * $x2;
            }
            case '/': {
                if ($x2 === 0){
                    return 'Деление на ноль!';
                }
                return "$x1 / $x2 = " . $x1 / $x2;
            }
            default: {
                return 'Неизвестная операция';
            }
        }
    }
}