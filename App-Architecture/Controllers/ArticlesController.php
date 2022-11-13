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
        var_dump($article);
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