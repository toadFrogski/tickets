<?php

namespace Src\Controllers;

use Core\HttpFoundation\Request;
use Core\Template\Template;
use Src\Repository\MovieRepository;

class HomeController
{

    public function indexAction(Request $request)
    {
        if (isset($request->getParameters()['name']) && $name=$request->getParameters()['name'])
            return Template::view('home/index.html', ['movies' => MovieRepository::getSimilarByName($name)]);


        return Template::view('home/index.html', ['movies' => MovieRepository::getAllAvailableMovies()]);
    }
}