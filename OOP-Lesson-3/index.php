<?php

require_once 'PaidLesson.php';

$lesson = new PaidLesson(
    'Урок о наследовании в PHP',
    'Лол, кек, чебурек',
    'Ложитесь спать, утро вечера мудренее',
    "99.90");

var_dump($lesson);