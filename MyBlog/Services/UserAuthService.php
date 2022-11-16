<?php

namespace Services;

class UserAuthService
{
    public static function createToken(\Models\User $user): void
    {
        $token = $user->getId() . ':' . $user->getAuthToken();
        setcookie('token', $token, time() + 3600 * 24 * 30, '/', '', false, true);
    }

    public static function getUserByToken(): ?\Models\User
    {
        if (empty($_COOKIE['token'])) {
            return null;
        }

        $tokenData = explode(':', $_COOKIE['token']);
        if (count($tokenData) !== 2) {
            return null;
        }

        $user = \Models\User::getById($tokenData[0]);
        if ($user === null) {
            return null;
        }

        if ($user->getAuthToken() !== $tokenData[1]) {
            return null;
        }
        return $user;
    }

    public static function deleteToken(): void
    {
        setcookie('token', '', time() - 3600, '/', '', false, true);
    }
}