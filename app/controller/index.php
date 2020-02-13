<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;

class Index extends Controller
{
    public function index()
    {
        $view = Factory::createView();
        $view->display('index.html');
    }
    public function register()
    {
        $view = Factory::createView();
        $view->display('register.html');
    }
    public function login()
    {
        $view = Factory::createView();
        $view->display('login.html');
    }
    public function manage()
    {
        $view = Factory::createView();
        $view->display('manage.html');
    }

}
