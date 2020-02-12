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
        $view = new View();
        $model = new Model();
        $value = 'success';
        $value2 = 'wrong';
        $res = $model->table('user')->select();
        if($res == 1){
            $view->assign('name', $value);
            $view->display('test.tpl');
        }else{
            $view->assign('name2', $value2);
            $view->display('test2.tpl');
        }

    }
}
