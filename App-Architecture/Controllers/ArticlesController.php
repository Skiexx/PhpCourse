<?php

namespace Controllers;
use Views\View;
use Models;

class ArticlesController
{
    private View $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../templates/');
    }

    public function edit($id): void
    {
        $article = Models\Article::getById($id);
        if ($article === null)
        {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }
        $article->setName($_POST['name']);
        $article->setText($_POST['text']);

        $article->save();
    }

    public function add(): void
    {
        $article = new Models\Article();
        $article->setName($_POST['name']);
        $article->setText($_POST['text']);
        $article->setAuthorId($_POST['authorId']);

        $article->save();
    }

    public function view(int $id): void
    {
        $article = Models\Article::getById($id);

        if (empty($article)) {
            $this->view->renderHtml('errors/404.php', code: 404);
            return;
        }

        $this->view->renderHtml('articles/view.php',
            [
                'article' => $article,
                'title' => $article->getName()
            ]
        );
    }
}