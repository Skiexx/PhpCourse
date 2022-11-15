<?php

namespace Controllers;
use Exceptions\NotFoundException;
use Views\View;
use Models;

class ArticlesController
{
    private View $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../templates/');
    }

    /**
     * @throws NotFoundException
     */
    public function edit($id): void
    {
        $article = Models\Article::getById($id);
        if ($article === null)
        {
            throw new NotFoundException();
        }
        $article->setName($_POST['name']);
        $article->setText($_POST['text']);

        $article->save();
    }

    public function add(): void
    {
        $article = new Models\Article();
        $author = Models\User::getById($_POST['authorId']);

        $article->setName($_POST['name']);
        $article->setText($_POST['text']);
        $article->setAuthorId($author);

        $article->save();
    }

    /**
     * @throws NotFoundException
     */
    public function delete($id): void
    {
        $article = Models\Article::getById($id);
        if ($article === null)
        {
            throw new NotFoundException();
        }
        $article->delete();
    }

    /**
     * @throws NotFoundException
     */
    public function view(int $id): void
    {
        $article = Models\Article::getById($id);

        if (empty($article)) {
            throw new NotFoundException();
        }

        $this->view->renderHtml('articles/view.php',
            [
                'article' => $article,
                'title' => $article->getName()
            ]
        );
    }
}