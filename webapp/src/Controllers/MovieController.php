<?php

namespace Src\Controllers;

use Core\HttpFoundation\Request;
use Core\Template\Template;


class MovieController
{

    public function indexAction(Request $request)
    {
        return Template::view('movie/index.html');
    }
}