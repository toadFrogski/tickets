<?php

namespace Src\Controllers;

use Core\HttpFoundation\Request;
use Core\Template\Template;
use Src\Repository\ManagerRepository;

class AdminController
{
    public function indexAction(Request $request)
    {
        return Template::view('admin/index.html');
    }

    public function loginAction(Request $request)
    {
        return Template::view('admin/login.html');
    }

    public function loginPostAction(Request $request) {
        if ($this->validateLogin($request->getParameters())) {
            $_SESSION['admin'] = true;
        }
    }

    private function validateLogin($data) {
        foreach (['email', 'password'] as $requirement) {
            if (!isset($data[$requirement])) {
                return false;
            }
        }

        $managers = ManagerRepository::getAllManagers();
        foreach ($managers as $manager) {

        }
    }
}