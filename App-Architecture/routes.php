<?php

return [
    '~^hello/(.*)$~' => [\Controllers\MainController::class, 'sayHello'],
    '~^articles/(\d+)$~' => [\Controllers\ArticlesController::class, 'view'],
    '~^articles/(\d+)/edit$~' => [\Controllers\ArticlesController::class, 'edit'],
    '~^$~' => [\Controllers\MainController::class, 'main'],
];