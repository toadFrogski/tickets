<?php

namespace Src\Controllers;

use Core\HttpFoundation\Request;
use Core\Template\Template;
use Src\Repository\CinemaRepository;

class CinemaController
{
    public function indexAction(Request $request)
    {
        return Template::view('cinemas/index.html', ['cinemas' => CinemaRepository::getAllCinemas()]);
    }
}