<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;


class Validate extends Controller
{
    public function checkName()
    {
        $view = Factory::createView();
        $user = new \app\model\User();
        $user->register();
        // $view->assign('name', $value);
        // $view->assign('name2', $value2);
        // $view->display('test.html');
    }
    public function register()
    {
        $view = Factory::createView();
        $user = new \app\model\User();
        $user->register();
        // $view->assign('name', $value);
        // $view->assign('name2', $value2);
        // $view->display('test.html');
    }
    public function login()
    {
        $view = Factory::createView();
        $user = new \app\model\User();
        $user->login();
    }
}
