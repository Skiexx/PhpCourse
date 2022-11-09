<?php

require_once 'Models/Article.php';
require_once 'Models/User.php';

$author = new Models\User('John Doe');
$article = new Models\Article('Hello world', 'This is my first article', $author);
var_dump($article);