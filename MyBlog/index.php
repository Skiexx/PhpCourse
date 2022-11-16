<?php

try {
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
    throw new \Exceptions\NotFoundException();
} catch (\Exceptions\DbException $e) {
    $view = new \Views\View(__DIR__ . '/templates/errors/');
    $view->renderHtml('500.php', ['error' => $e->getMessage()], 500);
} catch (\Exceptions\NotFoundException $e) {
    $view = new \Views\View(__DIR__ . '/templates/errors/');
    $view->renderHtml('404.php', ['error' => $e->getMessage()], 404);
} catch (\Exceptions\UnauthorizedException $e) {
    $view = new \Views\View(__DIR__ . '/templates/errors/');
    $view->renderHtml('401.php', ['error' => $e->getMessage()], 401);
} catch (\Exceptions\ForbiddenException $e) {
    $user = \Services\UserAuthService::getUserByToken();
    $view = new \Views\View(__DIR__ . '/templates/errors/');
    $view->renderHtml('403.php', [
        'error' => $e->getMessage(),
        'user' => $user
        ], 403);
}