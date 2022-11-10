<?php

spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    require_once __DIR__ . '/' . $class . '.php';
});

//require_once 'Models/Article.php';
//require_once 'Models/User.php';

$author = new Models\User('John Doe');
$article = new Models\Article('Hello world', 'This is my first article', $author);
var_dump($article);