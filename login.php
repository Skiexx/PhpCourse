<?php
$login = !empty($_GET['login']) ? $_GET['login'] : '';
$password = !empty($_GET['password']) ? $_GET['password'] : '';
$response = '';

if ($login !== 'admin') {
    $response = 'Неверный логин';
} elseif ($password !== 'Pa$$w0rd') {
    $response = 'Неверный пароль';
} else {
    $response = 'Логин и пароль верные!';
}
?>

<html>
<head>
    <title>Результат авторизации</title>
</head>
<body>
<p>
    <?= $response ?>
</p>
</body>
</html>