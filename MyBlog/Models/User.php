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
    protected $createdAt;

    public function getNickname(): string
    {
        return $this->nickname;
    }

    protected static function getTableName(): string
    {
        return 'users';
    }

    public function getAuthToken(): string
    {
        return $this->authToken;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @throws InvalidArgumentsException
     */
    public static function signUp(array $userData): User
    {
        $error = '';

        switch (true) {
            case empty($userData['nickname']):
            {
                $error .= 'Поле "Nickname" не заполнено<br>';
                break;
            }
            case !preg_match('/^[a-zA-Z0-9]+$/', $userData['nickname']):
            {
                $error .= 'Поле "Nickname" должно содержать только латинские буквы и цифры<br>';
                break;
            }
            case !empty(static::findOneByColumn('nickname', $userData['nickname'])):
            {
                $error .= 'Пользователь с таким "Nickname" уже существует<br>';
                break;
            }
        }

        switch (true) {
            case empty($userData['email']):
            {
                $error .= 'Поле "Email" не заполнено<br>';
                break;
            }
            case !filter_var($userData['email'], FILTER_VALIDATE_EMAIL):
            {
                $error .= 'Поле "Email" заполнено некорректно<br>';
                break;
            }
            case !empty(static::findOneByColumn('email', $userData['email'])):
            {
                $error .= 'Пользователь с таким "Email" уже существует<br>';
                break;
            }
        }

        switch (true) {
            case empty($userData['password']):
            {
                $error .= 'Поле "Пароль" не заполнено<br>';
                break;
            }
            case strlen($userData['password']) < 8:
            {
                $error .= 'Поле "Пароль" должно содержать не менее 8 символов<br>';
                break;
            }
        }

        if (!empty($error))
        {
            throw new \Exceptions\InvalidArgumentsException($error);
        }

        $user = new User();
        $user->nickname = $userData['nickname'];
        $user->email = $userData['email'];
        $user->passwordHash = password_hash($userData['password'], PASSWORD_DEFAULT);
        $user->role = 'user';
        $user->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
        $user->save();

        return $user;
    }

    /**
     * @throws InvalidArgumentsException
     */
    public static function signIn(array $userData): User
    {
        $error = '';

        switch (true) {
            case empty($userData['nickname']):
            {
                $error .= 'Поле "Nickname" не заполнено<br>';
                break;
            }
            case !preg_match('/^[a-zA-Z0-9]+$/', $userData['nickname']):
            {
                $error .= 'Поле "Nickname" должно содержать только латинские буквы и цифры<br>';
                break;
            }
        }

        switch (true) {
            case empty($userData['password']):
            {
                $error .= 'Поле "Пароль" не заполнено<br>';
                break;
            }
            case strlen($userData['password']) < 8:
            {
                $error .= 'Поле "Пароль" должно содержать не менее 8 символов<br>';
                break;
            }
        }

        if (!empty($error))
        {
            throw new \Exceptions\InvalidArgumentsException($error);
        }

        $user = static::findOneByColumn('nickname', $userData['nickname']);

        if (empty($user))
        {
            throw new \Exceptions\InvalidArgumentsException('Пользователь не найден');
        }

        if ($user instanceof User && password_verify($userData['password'], $user->passwordHash)) {
            $user->refreshAuthToken();
            $user->save();
            return $user;
        } else {
            throw new \Exceptions\InvalidArgumentsException('Неверный пароль');
        }
    }

    private function refreshAuthToken()
    {
        $this->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
    }
}