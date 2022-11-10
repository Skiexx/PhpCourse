<?php

spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    require_once __DIR__ . '/' . $class . '.php';
});

$controller = new MyApp\Controllers\MainController();
$controller->main();