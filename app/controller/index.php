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
    public function test()
    {
        $view = Factory::createView();
        $test = new \app\model\Test();
        $value = 'success';
        $value2 = 'wrong';
        $res = $test->query();
        if ($res) {
            $view->assign('name', $value);
            $view->display('test.html');
        } else {
            $view->assign('name2', $value2);
            $view->display('test2.html');
        }
    }
    public function register()
    {
        $view = Factory::createView();
        // $value = 'Hello';
        // $view->assign('name3', $value);
        $view->display('register.html');
    }
}
