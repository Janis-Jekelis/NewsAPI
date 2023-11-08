<?php
declare(strict_types=1);
use App\Api;
require_once __DIR__."/../vendor/autoload.php";
$loader = new \Twig\Loader\FilesystemLoader(__DIR__."/../Public/Views");
$twig = new \Twig\Environment($loader);

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', ['App\Controllers\ArticleController',"index"]);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:

        $handler = $routeInfo[1];
        [$class,$method]=[$handler[0],$handler[1]];
        $vars = $routeInfo[2];
        $request=(new $class())->{$method}();
        echo $request->getViewName();
        break;
}