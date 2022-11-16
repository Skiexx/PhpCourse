<?php

namespace Controllers;

use Exceptions\InvalidArgumentsException;
use Models\User;
use Services\UserAuthService;

class UsersController extends AbstractController
{
    public function signUp(): void
    {
        if (!empty($_POST)) {
            try {
                User::signUp($_POST);
            } catch (InvalidArgumentsException $e) {
                $this->view->renderHtml('users/signUp.php', ['error' => $e->getMessage()]);
                return;
            }
            header('Location: /users/login', response_code: 302);
            return;
        }
        $this->view->renderHtml('users/signUp.php');
    }

    public function signIn(): void
    {
        if (!empty($_POST)) {
            try {
                $user = User::signIn($_POST);
                UserAuthService::createToken($user);
            } catch (InvalidArgumentsException $e) {
                $this->view->renderHtml('users/signIn.php', ['error' => $e->getMessage()]);
                return;
            }
            header('Location: /', response_code: 302);
            return;
        }
        $this->view->renderHtml('users/signIn.php');
    }

    public function signOut(): void
    {
        UserAuthService::deleteToken();
        header('Location: /', response_code: 302);
    }
}