<?php

use Core\Routing\Route;
use Core\Routing\Router;

use Src\Controllers\HomeController;
use Src\Controllers\MovieController;
use Src\Controllers\TicketController;

$router = Router::getInstance([
    new Route('home', '/', [HomeController::class, 'indexAction'], 'GET'),
    new Route('movie', '/movie', [MovieController::class, 'indexAction'], 'GET'),
    new Route('ticket', '/checkout', [TicketController::class, 'indexAction'], 'GET')
]);

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);