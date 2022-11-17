<?php

namespace Models;

use Exceptions\InvalidArgumentsException;

class Article extends ActiveRecordEntity
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $text;

    /** @var int */
    protected $authorId;

    /** @var string */
    protected $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getAuthor(): User
    {
        return User::getById($this->authorId);
    }

    public function setAuthor(User $author): void
    {
        $this->authorId = $author->getId();
    }

    protected static function getTableName(): string
    {
        return 'articles';
    }

    /**
     * @throws InvalidArgumentsException
     */
    public static function createFromArray(array $fields, User $user): Article
    {
        $error = '';

        if (empty($fields['name'])) {
            $error .= 'Не передано название статьи';
        }
        if (empty($fields['text'])) {
            $error .= 'Не передан текст статьи';
        }

        if (!empty($error)) {
            throw new InvalidArgumentsException($error);
        }

        $article = new Article();
        $article->setName($fields['name']);
        $article->setText($fields['text']);
        $article->setAuthor($user);
        $article->save();

        return Article::getLatest();
    }

    /**
     * @throws InvalidArgumentsException
     */
    public function updateFromArray(array $fields): Article
    {
        $error = '';

        if (empty($fields['name'])) {
            $error .= 'Не передано название статьи';
        }
        if (empty($fields['text'])) {
            $error .= 'Не передан текст статьи';
        }

        if (!empty($error)) {
            throw new InvalidArgumentsException($error);
        }

        $this->setName($fields['name']);
        $this->setText($fields['text']);
        $this->save();

        return $this;
    }
}