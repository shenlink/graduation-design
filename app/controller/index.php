<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;

class Index extends Controller
{
    public function index()
    {
        session_start();
        if(isset($_SESSION['username'])){
            $username = $_SESSION['username'];
        }
        $article = Factory::createArticle();
        $data = $article->index();
        $view = Factory::createView();
        $view->assign('username', $username);
        $view->assign('data',$data);
        $view->display('index.html');
    }
    public function __call($method, $args)
    {
        $view = Factory::createView();
        $view->display('notfound.html');
    }
}
