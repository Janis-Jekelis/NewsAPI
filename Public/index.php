<?php
declare(strict_types=1);
use App\ArticleCollection;
require_once __DIR__."/../vendor/autoload.php";

$loader = new \Twig\Loader\FilesystemLoader(__DIR__."/../Public/Views");
$twig = new \Twig\Environment($loader);

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', ['App\Controllers\ArticleController',"index"]);
    $r->addRoute('GET', '/search', ['App\Controllers\ArticleController',"search"]);
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
        if ($method=="index") {
            $country = null;
            if (isset($_GET["country"])) $country = $_GET["country"];
            $response = (new $class())->{$method}($country);
        }
        if ($method=="search"){
            $from=null;
            $to=null;
            if (isset($_GET["from"])) $from = $_GET["from"];
            if (isset($_GET["to"])) $to = $_GET["to"];
            $response = (new $class())->{$method}($_GET["search"],$from,$to);

        }
        echo $twig->render($response->getViewName() . ".twig", $response->getData());
        break;
}