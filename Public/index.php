<?php

declare(strict_types=1);

use Carbon\Carbon;
use Dotenv\Dotenv;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once __DIR__ . "/../vendor/autoload.php";

$loader = new FilesystemLoader(__DIR__ . "/../Public/Views");
$twig = new Environment($loader);

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', ['App\Controllers\ArticleController', "index"]);
    $r->addRoute('GET', '/search', ['App\Controllers\ArticleController', "search"]);
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
        [$class, $method] = [$handler[0], $handler[1]];
        $vars = $routeInfo[2];
        if ($method == "index") {
            $country = null;
            if (isset($_GET["country"])) $country = $_GET["country"];
            $response = (new $class())->{$method}($country);
        }
        if ($method == "search") {
            $from = null;
            $to = null;
            try {
                if (($_GET["from"]) != null) {
                    $from = (Carbon::parse($_GET["from"]))->format("Y-m-d");
                };
                if (($_GET["to"]) != null) $to = (Carbon::parse($_GET["to"]))->format("Y-m-d");

                $response = (new $class())->{$method}($_GET["search"], $from, $to);
            } catch (Exception $e) {
                echo header('Location: /');
            }


        }
        echo $twig->render($response->getViewName() . ".twig", $response->getData());
        break;
}