<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Model;
use core\lib\View;

class index extends Controller
{
    public function index()
    {
        $data = 'Hello World';
        $view = new View();
        $view->assign('data', 'Hello world');
        $view->display('test.html');
    }
}
