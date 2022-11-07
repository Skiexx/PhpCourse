<?php

$content = '<h1>Заголовок статьи</h1><p>Текст какой-то статьи</p>';
$header = '<h1>Заголовок страницы</h1>';
$sidebar = '<h2>Заголовок боковой панели</h2><p>Текст боковой панели</p>';
$footer = '<p>Подвал сайта</p>';

require __DIR__ . '/header.php';
require __DIR__ . '/sidebar.php';
require __DIR__ . '/content.php';
require __DIR__ . '/footer.php';
?>
