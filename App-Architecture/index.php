<?php

spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    require_once __DIR__ . '/' . $class . '.php';
});

$route = $_GET['route'] ?? '';
$routes = require __DIR__ . '/routes.php';

foreach ($routes as $pattern => $controllerAndAction) {
    if (preg_match($pattern, $route, $matches)) {
        $controllerName = $controllerAndAction[0];
        $actionName = $controllerAndAction[1];
        unset($matches[0]);
        $controller = new $controllerName();
        $controller->$actionName(...$matches);
        exit;
    }
}
http_response_code(404);
echo '<h1>Страница не найдена</h1>';