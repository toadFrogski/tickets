<?php

namespace Src\Controllers;

use Core\HttpFoundation\Request;
use Core\Template\Template;
use Src\Repository\CinemahallRepository;
use Src\Repository\MovieRepository;

class HomeController
{

    public function indexAction(Request $request)
    {
        // $cinemahalls = CinemahallRepository::getAllCinemahalls();
        $movies = MovieRepository::getMovieById(2);
        return Template::view('user/index.html');
    }
}