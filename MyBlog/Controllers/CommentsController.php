<?php

namespace Controllers;

use Exceptions\NotFoundException;
use Models\Article;

class CommentsController extends AbstractController
{
    /**
     * @throws NotFoundException
     */
    public function add(int $articleId): void
    {
        $article = Article::getById($articleId);

        if (empty($article)) {
            throw new \Exceptions\NotFoundException();
        }

        if (!empty($_POST)) {
            try {
                $comment = \Models\Comment::createFromArray($_POST, $this->user, $articleId);
            } catch (\Exceptions\InvalidArgumentsException $e) {
                $this->view->renderHtml('articles/view', ['errors' => $e->getMessage()]);
                header('Location: /articles/' . $articleId, true, 302);
                return;
            }
        }

        header('Location: /articles/' . $article->getId(), true, 302);
    }
}