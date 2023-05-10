<?php

use Core\Routing\Route;
use Core\Routing\Router;

use Src\Controllers\AdminController;
use Src\Controllers\HomeController;
use Src\Controllers\MovieController;
use Src\Controllers\TicketController;

$router = Router::getInstance([
    new Route('home', '/', [HomeController::class, 'indexAction'], 'GET'),
    new Route('movie', '/movie', [MovieController::class, 'indexAction'], 'GET'),
    new Route('ticket', '/checkout', [TicketController::class, 'indexAction'], 'GET'),
    new Route('login', '/admin/login', [AdminController::class, 'loginAction'], 'GET'),
    new Route('login_post', '/admin/login', [AdminController::class, 'loginPostAction'], 'POST')
]);

if (isset($_SESSION['admin'])) {
    $router->add(new Route('login', '/admin/logout', [AdminController::class, 'logoutAction'], 'GET'));
    $router->add(new Route('admin', '/admin', [AdminController::class, 'indexAction'], 'GET'));
}

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);