<?php

namespace app\controller;

use core\lib\Controller;
use app\controller\Validate;
use core\lib\Factory;

class Admin extends Controller
{
    public function checkSattus()
    {

    }
    public function manage()
    {
        $access = Validate::checkAccess();
        $view = Factory::createView();
        if ($access == '1') {
            $username = $_SESSION['username'];
            $admin = Factory::createAdmin();;
            $user = $admin->user();
            $article = $admin->article();
            $category = $admin->category();
            $comment = $admin->comment();
            $announcement = $admin->announcement();
            $view->assign('username',$username);
            $view->assign('user', $user);
            $view->assign('article', $article);
            $view->assign('category', $category);
            $view->assign('comment', $comment);
            $view->assign('announcement', $announcement);
            $view->display('admin.html');
        } else if ($access == '2') {
            $view->display('noadmin.html');
        } else {
            $view->display('nologin.html');
        }
    }

    public function __call($method, $args)
    {
        $view = Factory::createView();
        $view->display('notfound.html');
    }
}
