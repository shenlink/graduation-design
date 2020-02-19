<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;

class Index extends Controller
{
    public function index()
    {
        $article = Factory::createArticle();
        $data = $article->index();
        $view = Factory::createView();
        $view->assign('data',$data);
        $view->display('index.html');
    }
    public function __call($method, $args)
    {
        $view = Factory::createView();
        $view->display('notfound.html');
    }
}
