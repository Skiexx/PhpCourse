<?php

return [
    'db' => [
        'host' => 'db',
        'dbname' => getenv('DB_DATABASE'),
        'user' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD'),
    ]
];