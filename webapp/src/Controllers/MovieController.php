<?php

namespace Src\Controllers;

use Core\HttpFoundation\Request;
use Core\Template\Template;
use Src\Repository\MovieRepository;
use Src\Repository\SessionRepository;


class MovieController
{

    public function indexAction(Request $request)
    {
        $id = 1;
        return Template::view('movie/index.html', ['movie' => MovieRepository::getMovieById($id), 'sessions' => SessionRepository::getAllAvaiableMovieSessions($id)]);
    }
}