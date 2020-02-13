<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;


class Category extends Controller
{
    public function php()
    {
        $view = Factory::createView();
        $view->display('php.html');
    }
    public function mysql()
    {
        $view = Factory::createView();
        $view->display('mysql.html');
    }
    public function javaScript()
    {
        $view = Factory::createView();
        $view->display('javaScript.html');
    }
    public function html()
    {
        $view = Factory::createView();
        $view->display('html.html');
    }
    public function python()
    {
        $view = Factory::createView();
        $view->display('python.html');
    }
    public function java()
    {
        $view = Factory::createView();
        $view->display('java.html');
    }
    public function operation()
    {
        $view = Factory::createView();
        $view->display('operation.html');
    }
    public function foundation()
    {
        $view = Factory::createView();
        $view->display('foundation.html');
    }
    public function write()
    {
        $view = Factory::createView();
        $view->display('write.html');
    }
    
}