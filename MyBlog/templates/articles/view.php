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
    <?php if (empty($comments)): ?>
        <p>Комментариев пока нет</p>
        <hr>
    <?php endif; ?>
    <?php foreach ($comments as $comment): ?>
        <div class="comment">
            <h3><?= $comment->getAuthor()->getNickname() ?></h3>
            <p><?= $comment->getText() ?></p>
            <?php if ($user->getId() === $comment->getAuthor()->getId()): ?>
                <a href="/comments/<?= $comment->getId() ?>/edit">Редактировать</a>
                <a style="margin-left: 10px;" href="/comments/<?= $comment->getId() ?>/delete">Удалить</a>
                <?php elseif ($user->getRole() === 'admin'): ?>
                <a href="/comments/<?= $comment->getId() ?>/delete">Удалить</a>
            <?php endif; ?>
        </div>
        <hr>
    <?php endforeach; ?>
    <?php if ($user !== null): ?>
        <form action="/articles/<?= $article->getId() ?>/comment" method="post">
            <?php if(!empty($error)): ?>
                <div style="background-color: red;padding: 5px;margin: 15px"><?= $error ?></div>
            <?php endif; ?>
            <label for="text">Текст комментария</label><br>
            <textarea name="text" id="text" rows="10" cols="80"></textarea><br>
            <input type="submit" value="Добавить комментарий">
        </form>
    <?php else : ?>
        <p>Чтобы оставить комментарий, <a href="/users/login">войдите</a> или <a href="/users/signup">зарегистрируйтесь</a></p>
    <?php endif; ?>
<?php include __DIR__ . '/../footer.php'; ?>
