<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;


class Category extends Controller
{
    public function php()
    {
        $category = Factory::createCategory();
        $data = $category->php();
        $view = Factory::createView();
        $view->assign('data', $data);
        $view->display('php.html');
    }
    public function mysql()
    {
        $category = Factory::createCategory();
        $data = $category->mysql();
        $view = Factory::createView();
        $view->assign('data', $data);
        $view->display('mysql.html');
    }
    public function javaScript()
    {
        $category = Factory::createCategory();
        $data = $category->javaScript();
        $view = Factory::createView();
        $view->assign('data', $data);
        $view->display('javaScript.html');
    }
    public function html()
    {
        $category = Factory::createCategory();
        $data = $category->html();
        $view = Factory::createView();
        $view->assign('data', $data);
        $view->display('html.html');
    }
    public function python()
    {
        $category = Factory::createCategory();
        $data = $category->python();
        $view = Factory::createView();
        $view->assign('data', $data);
        $view->display('python.html');
    }
    public function java()
    {
        $category = Factory::createCategory();
        $data = $category->java();
        $view = Factory::createView();
        $view->assign('data', $data);
        $view->display('java.html');
    }

    public function foundation()
    {
        $category = Factory::createCategory();
        $data = $category->foundation();
        $view = Factory::createView();
        $view->assign('data',$data);
        $view->display('foundation.html');
    }

    public function __call($method, $args)
    {
        $view = Factory::createView();
        $view->display('notfound.html');
    }
}
