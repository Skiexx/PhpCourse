<?php

namespace Controllers;
use Models\Article;

class MainController extends AbstractController
{
    public function main(): void {
        $articles = Article::findAll();
        sort($articles);
        $this->view->renderHtml('main/main.php', ['articles' => $articles]);
    }
}