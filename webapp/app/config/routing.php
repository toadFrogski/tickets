<?php

use Core\Routing\Route;
use Core\Routing\Router;

use Src\Controllers\AdminController;
use Src\Controllers\CinemaController;
use Src\Controllers\HomeController;
use Src\Controllers\MovieController;
use Src\Controllers\TicketController;

$router = Router::getInstance([
    new Route('home', '/', [HomeController::class, 'indexAction'], 'GET'),
    new Route('movie', '/movie', [MovieController::class, 'indexAction'], 'GET'),
    new Route('cinemas', '/cinemas', [CinemaController::class, 'indexAction'], 'GET'),
    new Route('ticket', '/checkout', [TicketController::class, 'indexAction'], 'GET'),
    new Route('ticket_post', '/checkout', [TicketController::class, 'buyAction'], 'POST'),
    new Route('login', '/admin/login', [AdminController::class, 'loginAction'], 'GET'),
    new Route('login_post', '/admin/login', [AdminController::class, 'loginPostAction'], 'POST')
]);

if (isset($_SESSION['admin'])) {
    $router->add(new Route('admin', '/admin', [AdminController::class, 'indexAction'], 'GET'));
    $router->add(new Route('logout', '/admin/logout', [AdminController::class, 'logoutAction'], 'GET'));
    $router->add(new Route('admin_movie_new', '/admin/movie/new', [AdminController::class, 'movieNewAction'], 'GET'));
    $router->add(new Route('admin_movie_new_post', '/admin/movie/new', [AdminController::class, 'movieNewPostAction'], 'POST'));
    $router->add(new Route('admin_movie_edit', '/admin/movie/edit', [AdminController::class, 'movieEditAction'], 'GET'));
    $router->add(new Route('admin_movie_edit_post', '/admin/movie/edit', [AdminController::class, 'movieEditPostAction'], 'POST'));
    $router->add(new Route('admin_movie_delete', '/admin/movie/delete', [AdminController::class, 'movieDeleteAction'], 'GET'));
}

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);