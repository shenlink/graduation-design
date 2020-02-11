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
        $value2 = 'Hello World';
        $view = new View();
        $view->assign('name',$value);
        $view->assign('name2',$value2);
        $view->display('test.tpl');
    }
}
