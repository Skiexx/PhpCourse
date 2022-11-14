<?php

namespace Models;

class User extends ActiveRecordEntity
{
    private string $nickname;
    private string $email;
    protected bool $isConfirmed;
    private string $role;
    protected string $passwordHash;
    protected string $authToken;
    protected string $createAt;

    public function getNickname(): string
    {
        return $this->nickname;
    }

    protected static function getTableName(): string
    {
        return 'users';
    }
}