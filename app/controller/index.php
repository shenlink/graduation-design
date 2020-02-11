<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\View;
use core\lib\Model;

class index extends Controller
{
    public function index()
    {
        $value = 'Hello World';
        $view = new View();
        $view->assign('name',$value);
        $view->display('test.tpl');
    }
}
