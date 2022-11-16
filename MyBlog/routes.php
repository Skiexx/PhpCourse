<?php

return [
    '~^articles/(\d+)$~' => [\Controllers\ArticlesController::class, 'view'],
    '~^articles/(\d+)/edit$~' => [\Controllers\ArticlesController::class, 'edit'],
    '~^articles/add$~' => [\Controllers\ArticlesController::class, 'add'],
    '~^articles/(\d+)/delete$~' => [\Controllers\ArticlesController::class, 'delete'],
    '~^users/register$~' => [\Controllers\UsersController::class, 'signUp'],
    '~^users/login$~' => [\Controllers\UsersController::class, 'signIn'],
    '~^users/logout$~' => [\Controllers\UsersController::class, 'signOut'],
    '~^comments/(\d+)/add$~' => [\Controllers\CommentsController::class, 'add'],
    '~^comments/(\d+)/edit$~' => [\Controllers\CommentsController::class, 'edit'],
    '~^$~' => [\Controllers\MainController::class, 'main'],
];