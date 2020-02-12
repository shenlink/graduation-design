<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;
use core\lib\View;

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
        $view = new View();
        $model = new \app\model\Index();
        $value = 'success';
        $value2 = 'wrong';
        $res = $model->user();
        if($res){
            $view->assign('name', $value);
            $view->display('test.tpl');
        }else{
            $view->assign('name2', $value2);
            $view->display('test2.tpl');
        }

    }
}
