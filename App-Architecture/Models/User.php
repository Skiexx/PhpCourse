<?php

namespace Models;

class User extends ActiveRecordEntity
{
    private string $nickname;
    private string $email;
    private bool $isConfirmed;
    private string $role;
    private string $passwordHash;
    private string $authToken;
    private string $createAt;

    public function getNickname(): string
    {
        return $this->nickname;
    }

    protected static function getTableName(): string
    {
        return 'users';
    }
}