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
            if (isset($_POST['pageNumber'])) {
                $pageNumber = $_POST['pageNumber'];
                $article = Factory::createArticle();
                $data = $article->changePage($pageNumber, 5);
                $articles = $data['items'];
                $articlePage = $data['pageHtml'];
                $view->assign('articlePage', $articlePage);

                $announcement =  Factory::createAnnouncement();
                $data = $announcement->changePage($pageNumber, 5);
                $announcements = $data['items'];
                $announcementPage = $data['pageHtml'];
                $view->assign('announcementPage', $announcementPage);

                $category = Factory::createCategory();
                $data = $category->changePage($pageNumber, 5);
                $categorys = $data['items'];
                $categoryPage = $data['pageHtml'];
                $view->assign('categoryPage', $categoryPage);

                $comment = Factory::createComment();
                $data = $comment->changePage($pageNumber, 5);
                $comments = $data['items'];
                $commentPage = $data['pageHtml'];
                $view->assign('commentPage', $commentPage);

                $message = Factory::createMessage();
                $data = $message->changePage($pageNumber, 5);
                $messages = $data['items'];
                $messagePage = $data['pageHtml'];
                $view->assign('messagePage', $messagePage);

                $user = Factory::createUser();
                $data = $user->changePage($pageNumber, 5);
                $users = $data['items'];
                $userPage = $data['pageHtml'];
                $view->assign('userPage', $userPage);
            }else{
                $article = Factory::createArticle();
                $data = $article->firstPage();
                $articles = $data['items'];
                $articlePage = $data['pageHtml'];
                $view->assign('articlePage', $articlePage);

                $announcement =  Factory::createAnnouncement();
                $data = $announcement->firstPage();
                $announcements = $data['items'];
                $announcementPage = $data['pageHtml'];
                $view->assign('announcementPage', $announcementPage);

                $category = Factory::createCategory();
                $data = $category->firstPage();
                $categorys = $data['items'];
                $categoryPage = $data['pageHtml'];
                $view->assign('categoryPage', $categoryPage);

                $comment =  Factory::createComment();
                $data = $comment->firstPage();
                $comments = $data['items'];
                $commentPage = $data['pageHtml'];
                $view->assign('commentPage', $commentPage);

                $message = Factory::createMessage();
                $data = $message->firstPage();
                $messages = $data['items'];
                $messagePage = $data['pageHtml'];
                $view->assign('messagePage', $messagePage);

                $user = Factory::createUser();
                $data = $user->firstPage();
                $users = $data['items'];
                $userPage = $data['pageHtml'];
                $view->assign('userPage', $userPage);
            }
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
