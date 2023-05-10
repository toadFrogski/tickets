<?php

namespace Src\Controllers;

use Core\HttpFoundation\Request;
use Core\Template\Template;

class ADminController
{
    public function indexAction(Request $request)
    {
        return Template::view('admin/index.html');
    }
}