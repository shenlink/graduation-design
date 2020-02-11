<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Model;
use core\lib\View;

class index extends Controller
{
    public function index()
    {
        $model = new Model();
        $sql = "select * form user";
        // $res = $model->query($sql);
        // $res = $res->fetchAll();

    }
    public function test(){
        $data = 'Hello World';
        $view = new View();
        $view = $view->init();
        $view->assign('data',$data);
        $view->display('test.html');
    }
}
