<?php

namespace Controllers;

use Models\User;
use Services\UserAuthService;
use Views\View;

abstract class AbstractController
{
    /** @var View  */
    protected $view;

    /** @var User|null */
    protected $user;

    public function __construct()
    {
        $this->user = UserAuthService::getUserByToken();
        $this->view = new View(__DIR__ . '/../templates/');
        $this->view->setVar('user', $this->user);
    }
}