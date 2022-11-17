<?php include __DIR__ . '/../header.php'; ?>
    <h1>Изменение комментария</h1>
<?php if(!empty($error)): ?>
    <div style="background-color: red;padding: 5px;margin: 15px"><?= $error ?></div>
<?php endif; ?>
    <form action="/comments/<?= $comment->getId() ?>/edit" method="post">
        <label for="text">Текст комментария</label><br>
        <textarea name="text" id="text" rows="10" cols="80"><?= $_POST['text'] ?? $comment->getText() ?></textarea><br>
        <br>
        <input type="submit" value="Изменить">
    </form>
<?php include __DIR__ . '/../footer.php'; ?>