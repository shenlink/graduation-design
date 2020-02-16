<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;

class Index extends Controller
{
    public function index()
    {
        $index = Factory::createArticle();
        $data = $index->index();
        $view = Factory::createView();
        $view->assign('data',$data);
        $view->display('index.html');
    }
    public function test()
    {
        $index = new \app\model\Index();
        $data = $index->test();
        // $view = Factory::createView();
        // $view->assign()
        // $view->display('test.html');
        echo '<pre>';
        var_dump($data);
    }

}
