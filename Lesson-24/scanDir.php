<?php

$files = scandir(__DIR__ . '/');
foreach ($files as $file) {
    if (is_dir($file)) {
        echo $file . '<br>';
    }
}