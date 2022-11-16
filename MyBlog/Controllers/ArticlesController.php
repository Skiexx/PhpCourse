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
}