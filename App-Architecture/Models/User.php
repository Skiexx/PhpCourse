<?php

namespace Models;

use Exceptions\InvalidArgumentsException;

class User extends ActiveRecordEntity
{
    /** @var string */
    protected $nickname;

    /** @var string */
    protected $email;

    /** @var bool */
    protected $isConfirmed;

    /** @var string */
    protected $role;

    /** @var string */
    protected $passwordHash;

    /** @var string */
    protected $authToken;

    /** @var string */
    protected $createAt;

    public function getNickname(): string
    {
        return $this->nickname;
    }

    protected static function getTableName(): string
    {
        return 'users';
    }

    /**
     * @throws InvalidArgumentsException
     */
    public static function signUp(array $userData)
    {
        $error = '';

        if (empty($userData['nickname']))
        {
            $error .= 'Поле "Nickname" не заполнено<br>';
        }
        if (empty($userData['email']))
        {
            $error .= 'Поле "Email" не заполнено<br>';
        }
        if (empty($userData['password']))
        {
            $error .= 'Поле "Пароль" не заполнено<br>';
        }
        if (!preg_match('/^[a-zA-Z0-9]+$/', $userData['nickname']))
        {
            $error .= 'Поле "Nickname" должно содержать только латинские буквы и цифры<br>';
        }
        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL))
        {
            $error .= 'Поле "Email" заполнено некорректно<br>';
        }
        if (mb_strlen($userData['password']) < 8)
        {
            $error .= 'Поле "Пароль" должно содержать не менее 8 символов<br>';
        }

        if (!empty($error))
        {
            throw new \Exceptions\InvalidArgumentsException($error);
        }
    }
}