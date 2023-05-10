<?php

namespace Src\Controllers;

use Core\HttpFoundation\Request;
use Core\Routing\Router;
use Core\Template\Template;
use Src\Repository\ManagerRepository;
use Src\Repository\MovieRepository;

class AdminController
{
    public function indexAction(Request $request)
    {
        $movies = MovieRepository::getAllMovies();
        return Template::view('admin/index.html', ['movies' => $movies]);
    }

    public function loginAction(Request $request)
    {
        return Template::view('admin/login.html');
    }

    public function loginPostAction(Request $request)
    {
        if ($this->validateLogin($request->getParameters())) {
            $_SESSION['admin'] = true;
            Router::getInstance()->redirect('/admin');
        }
    }

    public function logoutAction(Request $request)
    {
        session_unset();
        Router::getInstance()->redirect('home');
    }

    private function validateLogin($data)
    {
        foreach (['email', 'password'] as $requirement) {
            if (!isset($data[$requirement])) {
                return false;
            }
        }
        $managers = ManagerRepository::getAllManagers();
        foreach ($managers as $manager) {
            if ($data['email'] == $manager[0] && md5($data['password']) == $manager[1]) {
                return true;
            }
        }
        return false;
    }

    public function movieNewAction(Request $request)
    {
    }

    public function movieNewPostAction(Request $request)
    {
    }

    public function movieEditAction(Request $request)
    {
        $id = $request->getParameters()['movie_id'];
        $movie = MovieRepository::getMovieById($id);
        $genres = MovieRepository::getAllGenres();
        return Template::view('admin/movie/edit.html', ['movie' =>$movie , 'genres' => $genres]);
    }

    public function movieEditPostAction(Request $request)
    {
        $params = $request->getParameters();
        $movie_id = $params['movie_id'];
        $movie_name = $params['movie_name'];
        $movie_description = $params['movie_description'];
        $movie_price = $params['movie_price'];
        $movie_producer = $params['movie_producer'];
        $movie_year = $params['movie_year'];
        $movie_duration = $params['movie_duration'];
        $genres = $params['genres'];
        $trailer = $params['trailer'];

    }

    public function movieDeleteAction(Request $request)
    {
    }

}