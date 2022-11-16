<?php include __DIR__ . '/../header.php'; ?>

    <h1><?= $article->getName() ?></h1>
    <h3>Автор: <?= $article->getAuthor()->getNickname() ?></h3>
    <p><?= $article->getText() ?></p>
    <?php switch ($user) {
        case null:
            break;
        case $user->getRole() === 'admin':
            ?>
            <a href="/articles/<?= $article->getId() ?>/edit">Редактировать</a>
            <a style="margin-left: 10px;" href="/articles/<?= $article->getId() ?>/delete">Удалить</a>
            <?php
            break;
    } ?>
    <h2>Комментарии</h2>
    <?php foreach ($comments as $comment): ?>
        <div class="comment">
            <h3 name="comment<?= $comment->getId() ?>"><?= $comment->getAuthor()->getNickname() ?></h3>
            <p><?= $comment->getText() ?></p>
            <p><?= $comment->getCreatedAt() ?></p>
        </div>
    <?php endforeach; ?>
    <?php if ($user !== null): ?>
        <form action="/comments/<?= $article->getId() ?>/add" method="post">
            <?php if(!empty($error)): ?>
                <div style="color: red;"><?= $error ?></div>
            <?php endif; ?>
            <label for="text">Текст комментария</label><br>
            <textarea name="text" id="text" rows="10" cols="80"></textarea><br>
            <input type="submit" value="Добавить комментарий">
        </form>
    <?php endif; ?>
<?php include __DIR__ . '/../footer.php'; ?>
