<?php

namespace app\controller;

use core\lib\Controller;
use app\controller\Validate;
use core\lib\Factory;

class Admin extends Controller
{

    // 显示404页面
    public function displayNone()
    {
        $view = Factory::createView();
        $view->display('notfound.html');
    }

    // 显示管理员的管理页面
    public function manage()
    {
        // 确认权限，为1时允许操作
        $access = Validate::checkAccess();
        $view = Factory::createView();
        if ($access == '1') {
            $username = $_SESSION['username'];
            $announcement =  Factory::createAnnouncement();
            $article = Factory::createArticle();
            $category = Factory::createCategory();
            $comment =  Factory::createComment();
            $message = Factory::createMessage();
            $user = Factory::createUser();
            $announcements = $announcement->getAllAnnouncement();
            $articles = $article->getAllArticle();
            $categorys = $category->getAllCategory();
            $comments = $comment->getAllComment();
            $messages = $message->getAllMessage();
            $users = $user->getAllUser();
            $view->assign('username', $username);
            $view->assign('announcements', $announcements);
            $view->assign('articles', $articles);
            $view->assign('categorys', $categorys);
            $view->assign('comments', $comments);
            $view->assign('messages', $messages);
            $view->assign('users', $users);
            $view->display('admin.html');
        } else if ($access == '2') {
            $view->display('noadmin.html');
        } else {
            $view->display('nologin.html');
        }
    }

    // 当用户调用Admin类中不存在的方法时，提示404页面
    public function __call($method, $args)
    {
        $view = Factory::createView();
        $view->display('notfound.html');
    }
}
