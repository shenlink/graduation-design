<?php

namespace app\controller;

use core\lib\Controller;
use app\controller\Validate;
use core\lib\Factory;


class Category extends Controller
{

    public function checkDisplay()
    {
        return  Validate::checkAccess();
    }

    public function php()
    {
        $access = $this->checkDisplay();
        if($access == 1 || $access == 2){
            $username = $_SESSION['username'];
        }
        $category = Factory::createCategory();
        $data = $category->php();
        $view = Factory::createView();
        $view->assign('username',$username);
        $view->assign('data', $data);
        $view->display('php.html');
    }

    public function mysql()
    {
        $access = $this->checkDisplay();
        if ($access == 1 || $access == 2) {
            $username = $_SESSION['username'];
        }
        $category = Factory::createCategory();
        $data = $category->mysql();
        $view = Factory::createView();
        $view->assign('username', $username);
        $view->assign('data', $data);
        $view->display('mysql.html');
    }

    public function javaScript()
    {
        $access = $this->checkDisplay();
        if ($access == 1 || $access == 2) {
            $username = $_SESSION['username'];
        }
        $category = Factory::createCategory();
        $data = $category->javaScript();
        $view = Factory::createView();
        $view->assign('username', $username);
        $view->assign('data', $data);
        $view->display('javaScript.html');
    }

    public function html()
    {
        $access = $this->checkDisplay();
        if ($access == 1 || $access == 2) {
            $username = $_SESSION['username'];
        }
        $category = Factory::createCategory();
        $data = $category->html();
        $view = Factory::createView();
        $view->assign('username', $username);
        $view->assign('data', $data);
        $view->display('html.html');
    }
    public function python()
    {
        $access = $this->checkDisplay();
        if ($access == 1 || $access == 2) {
            $username = $_SESSION['username'];
        }
        $category = Factory::createCategory();
        $data = $category->python();
        $view = Factory::createView();
        $view->assign('username', $username);
        $view->assign('data', $data);
        $view->display('python.html');
    }
    public function java()
    {
        $access = $this->checkDisplay();
        if ($access == 1 || $access == 2) {
            $username = $_SESSION['username'];
        }
        $category = Factory::createCategory();
        $data = $category->java();
        $view = Factory::createView();
        $view->assign('username', $username);
        $view->assign('data', $data);
        $view->display('java.html');
    }

    public function foundation()
    {
        $access = $this->checkDisplay();
        if ($access == 1 || $access == 2) {
            $username = $_SESSION['username'];
        }
        $category = Factory::createCategory();
        $data = $category->foundation();
        $view = Factory::createView();
        $view->assign('username', $username);
        $view->assign('data', $data);
        $view->display('foundation.html');
    }

    public function __call($method, $args)
    {
        $view = Factory::createView();
        $view->display('notfound.html');
    }
}
