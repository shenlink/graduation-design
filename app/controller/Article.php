<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;

class Article extends Controller
{
    public function search()
    {
        $search = $_POST['search'];
        $name = $_POST['name'];
        $article = Factory::createArticle();
        $data = $article->search($search,$name);
        if($name == '1'){
            $name = '用户名查询结果';
        }else{
            $name = '文章查询结果';
        }
        $view = Factory::createView();
        $view->assign('name',$name);
        $view->assign('data',$data);
        $view->display('search.html');
    }

    public function index()
    {
        $index = Factory::createArticle();
        $data = $index->index();
        return $data;

    }

    public function php()
    {
        $php = Factory::createArticle();
        $data = $php->php();
        return $data;

    }

    public function mysql()
    {
        $mysql = Factory::createArticle();
        $data = $mysql->mysql();
        return $data;

    }

    public function javaScript()
    {
        $javaScript = Factory::createArticle();
        $data = $javaScript->javaScript();
        return $data;

    }

    public function html()
    {
        $html = Factory::createArticle();
        $data = $html->html();
        return $data;
    }

    public function python()
    {
        $python = Factory::createArticle();
        $data = $python->python();
        return $data;
    }

    public function java()
    {
        $java = Factory::createArticle();
        $data = $java->java();
        return $data;
    }

    public function foundation()
    {
        $foundation = Factory::createArticle();
        $data = $foundation->foundation();
        return $data;
    }
    public function personal()
    {
        
    }
}