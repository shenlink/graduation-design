<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\View;
use core\lib\Model;

class Index extends Controller
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
    public function test(){
        $value3 = 'Hello World3';
        $value4 = 'Hello World4';
        $view = new View();
        $view->assign('name3', $value3);
        $view->assign('name4', $value4);
        $view->display('test.tpl');

    }
}
