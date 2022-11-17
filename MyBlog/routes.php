<?php

return [
    '~^articles/(\d+)$~' => [\Controllers\ArticlesController::class, 'view'],
    '~^articles/(\d+)/edit$~' => [\Controllers\ArticlesController::class, 'edit'],
    '~^articles/add$~' => [\Controllers\ArticlesController::class, 'add'],
    '~^articles/(\d+)/delete$~' => [\Controllers\ArticlesController::class, 'delete'],
    '~^users/register$~' => [\Controllers\UsersController::class, 'signUp'],
    '~^users/login$~' => [\Controllers\UsersController::class, 'signIn'],
    '~^users/logout$~' => [\Controllers\UsersController::class, 'signOut'],
    '~^articles/(\d+)/comment$~' => [\Controllers\ArticlesController::class, 'addComment'],
    '~^comments/(\d+)/edit$~' => [\Controllers\ArticlesController::class, 'editComment'],
    '~^comments/(\d+)/delete$~' => [\Controllers\ArticlesController::class, 'deleteComment'],
    '~^$~' => [\Controllers\MainController::class, 'main'],
];