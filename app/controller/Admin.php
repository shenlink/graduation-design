<?php

namespace app\controller;

use core\lib\Controller;
use app\controller\Validate;
use core\lib\Factory;

class Admin extends Controller
{
    public function manage()
    {
        $access = Validate::checkAccess();
        $view = Factory::createView();
        if ($access == '1') {
            $admin = Factory::createAdmin();;
            $user = $admin->user();
            $article = $admin->article();
            $category = $admin->category();
            $comment = $admin->comment();
            $announcement = $admin->announcement();
            $view->assign('user', $user);
            $view->assign('article', $article);
            $view->assign('category', $category);
            $view->assign('comment', $comment);
            $view->assign('announcement', $announcement);
            $view->display('manage.html');
        } else if ($access == '2') {
            $view->display('noadmin.html');
        } else {
            $view->display('nologin.html');
        }
    }
}
