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
    
    public function redirect()
    {
        $this->redirect('/');
    }

}
