<?php
if (!empty($_FILES['attachment'])) {
    $file = $_FILES['attachment'];

    // собираем путь до нового файла - папка uploads в текущей директории
    // в качестве имени оставляем исходное файла имя во время загрузки в браузере
    $srcFileName = $file['name'];
    $newFilePath = __DIR__ . '/uploads/' . $srcFileName;

    if ($file['error'] === UPLOAD_ERR_INI_SIZE) {
        echo 'Файл слишком большой';
    } elseif ($file['error'] !== UPLOAD_ERR_OK) {
        echo 'Ошибка при загрузке файла';
    } elseif (getimagesize($file['tmp_name']) === false) {
        echo 'Файл не является изображением';
    } elseif (getimagesize($file['tmp_name'])[0] > 1280 || getimagesize($file['tmp_name'])[1] > 720) {
        echo 'Размер изображения превышает 1280x720';
    } elseif (file_exists($newFilePath)) {
        echo 'Файл с таким именем уже существует';
    } elseif (!move_uploaded_file($file['tmp_name'], $newFilePath)) {
        echo 'Не удалось переместить файл';
    } else {
        $result = __DIR__ . '/uploads/' . $srcFileName;
    }
}
?>

<html>
<head>
    <title>Загрузка файла</title>
</head>
<body>
<?php if (!empty($error)): ?>
    <?= $error ?>
<?php elseif (!empty($result)): ?>
    <?= $result ?>
<?php endif; ?>
<br>
<form action="/upload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="attachment">
    <input type="submit">
</form>
</body>
</html>