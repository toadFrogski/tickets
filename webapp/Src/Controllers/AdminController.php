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
        $managers = ManagerRepository::getAllManagers();
        $movies = MovieRepository::getAllMovies();
        return Template::view('admin/index.html', ['movies' => $movies, 'managers' => $managers]);
    }

    public function newManagerAction(Request $request)
    {
        return Template::view('admin/manager/new.html');
    }

    public function newManagerPostAction(Request $request)
    {
        if ($this->isValidEmailPassword($request->getParameters())) {
            $email = $request->getParameters()['email'];
            $password = md5($request->getParameters()['password']);
            if (!$this->isManagerExist($email, $password)) {
                ManagerRepository::newManager($email, $password);
                Router::getInstance()->redirect('/admin');
            }
            $err = 'Пользователь с таким email\'ом уже существует!';
        } else {
            $err = 'Все поля должны быть заполнены!';
        }
        return Template::view('admin/manager/new.html', ['error' => $err]);
    }
    public function editManagerAction(Request $request) {
        $manager = ManagerRepository::getManagerById($request->getParameters()['id']);
        return Template::view('admin/manager/edit.html', ['manager'=>$manager]);
    }

    private function isValidEmailPassword($data) {
        foreach (['email', 'password'] as $requirement) {
            $data[$requirement] = stripcslashes(trim($data[$requirement]));
            if (empty($data[$requirement])) return false;
        }
        return true;
    }
    private function isManagerExist($email, $password) {
        $managers = ManagerRepository::getAllManagers();
        foreach ($managers as $manager) {
            if ($email == $manager[0]) {
                return true;
            }
        }
        return false;
    }
    public function deleteManagerAction(Request $request) {
        $id = $request->getParameters()['id'];
        ManagerRepository::deleteManagerById($id);
        Router::getInstance()->redirect('/admin');

    }
    public function editManagerPostAction(Request $request)
    {
        $id = $request->getParameters()['id'];
        $manager = ManagerRepository::getManagerById($id);
        if ($this->isValidEmailPassword($request->getParameters())) {
            $email = $request->getParameters()['email'];
            $password = md5($request->getParameters()['password']);
            ManagerRepository::updateManager($id, $email, $password);
            Router::getInstance()->redirect('/admin');
        } else {
            $err = 'Все поля должны быть заполнены!';
        }
        return Template::view('admin/manager/edit.html', ['manager'=> $manager,'error' => $err]);
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
        $genres = MovieRepository::getAllGenres();
        return Template::view('admin/movie/new.html', ['genres' => $genres]);
    }

    public function movieNewPostAction(Request $request)
    {
        $params = $request->getParameters();
        if ($params = $this->validateMovie($params)) {
            MovieRepository::newMovie($params);
            Router::getInstance()->redirect('admin');
        }
    }

    public function movieEditAction(Request $request)
    {
        $id = $request->getParameters()['movie_id'];
        $movie = MovieRepository::getMovieById($id);
        $genres = MovieRepository::getAllGenres();
        return Template::view('admin/movie/edit.html', ['movie' => $movie, 'genres' => $genres]);
    }

    public function movieEditPostAction(Request $request)
    {
        $params = $request->getParameters();
        if ($params = $this->validateMovie($params)) {
            MovieRepository::updateMovie($params);
            Router::getInstance()->redirect('admin');
        }
    }

    public function movieDeleteAction(Request $request)
    {
        if (isset($request->getParameters()['movie_id'])) {
            MovieRepository::deleteMovie($request->getParameters()['movie_id']);
            Router::getInstance()->redirect('admin');
        }
    }

    private function validateMovie($data)
    {
        return $data;
    }

}