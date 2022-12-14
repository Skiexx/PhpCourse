<?php

namespace Controllers;
use Models\Article;
use Views\View;

class MainController {
    private View $view;

    public function __construct() {
        $this->view = new View(__DIR__ . '/../templates/');
    }

    public function main(): void {
        $articles = Article::findAll();
        $this->view->renderHtml('main/main.php', ['articles' => $articles]);
    }
}