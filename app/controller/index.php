<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\View;
use core\lib\Model;

class index extends Controller
{
    public function index()
    {
        $data = 'Hello World';
        $view = new View();
        $view->assign('data',$data);
        $view->display('test.html');
    }
}
