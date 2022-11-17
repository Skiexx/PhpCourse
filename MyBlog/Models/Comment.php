<?php

namespace Models;

use Exceptions\InvalidArgumentsException;
use Services\Db;

class Comment extends ActiveRecordEntity
{
    protected $authorId;
    protected $articleId;
    protected $text;
    protected $createdAt;

    protected static function getTableName(): string
    {
        return 'comments';
    }

    /**
     * @throws InvalidArgumentsException
     */
    public static function createFromArray(array $fields, User $author, int $articleId): self
    {
        if (empty($fields['text'])) {
            throw new InvalidArgumentsException('Не передан текст комментария');
        }

        $comment = new self();
        $comment->authorId = $author->getId();
        $comment->articleId = $articleId;
        $comment->text = $fields['text'];
        $comment->save();

        return $comment->getLatest();
    }

    public function getAuthor(): User
    {
        return User::getById($this->authorId);
    }

    public function getArticle(): Article
    {
        return Article::getById($this->articleId);
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public static function getByArticleId(int $articleId): ?array
    {
        $db = Db::getInstance();
        $comments = [];
        $result = $db->execQuery('SELECT * FROM ' . static::getTableName() . ' WHERE article_id = ' . $articleId, [], static::class);
        foreach ($result as $comment) {
            $comments[] = $comment;
        }
        return $comments ?? null;
    }

    /**
     * @throws InvalidArgumentsException
     */
    public function updateFromArray(array $fields): self
    {
        if (empty($fields['text'])) {
            throw new InvalidArgumentsException('Не передан текст комментария');
        }
        $this->text = $fields['text'];
        $this->save();
        return $this;
    }
}