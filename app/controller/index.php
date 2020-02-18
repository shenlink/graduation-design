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
}
