<?php

namespace Src\Controllers;

use Core\HttpFoundation\Request;
use Core\Template\Template;
use Src\Repository\MovieRepository;

class HomeController
{

    public function indexAction(Request $request)
    {
        return Template::view('home/index.html');
    }
}