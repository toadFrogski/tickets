<?php

use Core\Routing\Route;
use Core\Routing\Router;

use Src\Controllers\HomeController;

$router = new Router([
    new Route('home', '/', [HomeController::class, 'indexAction'], 'GET')
]);

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);