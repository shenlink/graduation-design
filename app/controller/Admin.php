<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;

class Admin extends Controller
{
    public function manage()
    {
        $admin = Factory::createAdmin();;
        $view = Factory::createView();
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
    }
}