<?php include __DIR__ . '/../header.php'; ?>
    <h1><?= $article->getName() ?></h1>
    <h3>Автор: <?= $article->getAuthor()->getNickname() ?></h3>
    <p><?= $article->getText() ?></p>
<?php include __DIR__ . '/../footer.php'; ?>