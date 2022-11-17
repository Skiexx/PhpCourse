<?php

namespace Controllers;
use Exceptions\ForbiddenException;
use Exceptions\InvalidArgumentsException;
use Exceptions\NotFoundException;
use Exceptions\UnauthorizedException;
use Models;

class ArticlesController extends AbstractController
{
    /**
     * @throws NotFoundException
     * @throws UnauthorizedException
     * @throws ForbiddenException
     */
    public function edit($id): void
    {
        $article = Models\Article::getById($id);

        if (empty($article)) {
            throw new NotFoundException();
        }

        switch ($this->user) {
            case null:
                throw new UnauthorizedException();
            case $this->user->getRole() !== 'admin':
                throw new ForbiddenException();
        }

        if (!empty($_POST)) {
            try {
                $article = $article->updateFromArray($_POST);
            } catch (InvalidArgumentsException $e) {
                $this->view->renderHtml('errors', ['errors' => $e->getMessage()]);
                return;
            }

            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }

        $this->view->renderHtml('articles/edit.php', ['article' => $article]);
    }

    /**
     * @throws UnauthorizedException|ForbiddenException
     */
    public function add(): void
    {
        switch ($this->user)
        {
            case null:
                throw new \Exceptions\UnauthorizedException();
            case $this->user->getRole() !== 'admin':
                throw new \Exceptions\ForbiddenException();
        }

        if (!empty($_POST)) {
            try {
                $article = Models\Article::createFromArray($_POST, $this->user);
            } catch (InvalidArgumentsException $e) {
                $this->view->renderHtml('articles/add', ['error' => $e->getMessage()]);
                return;
            }
            header('Location: /articles/' . $article->getId(), true, 302);
            return;
        }

        $this->view->renderHtml('articles/add.php');
    }

    /**
     * @throws NotFoundException
     * @throws ForbiddenException|UnauthorizedException
     */
    public function delete($id): void
    {
        $article = Models\Article::getById($id);
        if ($article === null)
        {
            throw new NotFoundException();
        }

        switch ($this->user)
        {
            case null:
                throw new \Exceptions\UnauthorizedException();
            case $this->user->getRole() !== 'admin':
                throw new \Exceptions\ForbiddenException();
        }

        $article->delete();

        header('Location: /', true, 302);
    }

    /**
     * @throws NotFoundException
     */
    public function view(int $id): void
    {
        $article = Models\Article::getById($id);
        $comments = Models\Comment::getByArticleId($id);
        sort($comments);

        if ($article === null)
        {
            throw new NotFoundException();
        }

        $this->view->renderHtml('articles/view.php',
            [
                'article' => $article,
                'title' => $article->getName(),
                'comments' => $comments
            ]
        );
    }

    /**
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public function addComment(int $articleId): void
    {
        if ($this->user === null)
        {
            throw new \Exceptions\UnauthorizedException();
        }
        $article = Models\Article::getById($articleId);
        if ($article === null)
        {
            throw new NotFoundException();
        }
        $comments = Models\Comment::getByArticleId($articleId);
        sort($comments);
        if (!empty($_POST)) {
            try {
                $comment = Models\Comment::createFromArray($_POST, $this->user, $articleId);
            } catch (InvalidArgumentsException $e) {
                $this->view->renderHtml('articles/view.php', [
                    'article' => $article,
                    'error' => $e->getMessage(),
                    'comments' => $comments
                ]);
                return;
            }
            header('Location: /articles/' . $articleId, true, 302);
        }
    }

    /**
     * @throws ForbiddenException|UnauthorizedException
     * @throws NotFoundException
     */
    public function editComment(int $commentId): void
    {
        $comment = Models\Comment::getById($commentId);
        if ($comment === null)
        {
            throw new NotFoundException();
        }
        switch ($this->user)
        {
            case null:
                throw new \Exceptions\UnauthorizedException();
            case $this->user->getId() !== $comment->getAuthor()->getId():
                throw new \Exceptions\ForbiddenException();
        }
        if (!empty($_POST)) {
            try {
                $comment = $comment->updateFromArray($_POST);
            } catch (InvalidArgumentsException $e) {
                $article = $comment->getArticle();
                $comments = Models\Comment::getByArticleId($article->getId());
                sort($comments);
                $this->view->renderHtml('articles/view.php', [
                    'article' => $article,
                    'error' => $e->getMessage(),
                    'comments' => $comments
                ]);
                return;
            }
            header('Location: /articles/' . $comment->getArticle()->getId(), true, 302);
        }
        $this->view->renderHtml('articles/comment.php', ['comment' => $comment]);
    }

    /**
     * @throws ForbiddenException|UnauthorizedException
     * @throws NotFoundException
     */
    public function deleteComment(int $commentId): void
    {
        $comment = Models\Comment::getById($commentId);
        if ($comment === null)
        {
            throw new NotFoundException();
        }
        switch ($this->user)
        {
            case null:
                throw new \Exceptions\UnauthorizedException();
            case $this->user->getId() !== $comment->getAuthor()->getId() && $this->user->getRole() !== 'admin':
                throw new \Exceptions\ForbiddenException();
        }
        $comment->delete();
        header('Location: /articles/' . $comment->getArticle()->getId(), true, 302);
    }
}