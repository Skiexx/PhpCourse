<?php
require_once 'EnglishHuman.php';
require_once 'RussianHuman.php';

$englishHuman = new EnglishHuman('John');
echo $englishHuman->introduceYourself();

$russianHuman = new RussianHuman('Вася');
echo $russianHuman->introduceYourself();