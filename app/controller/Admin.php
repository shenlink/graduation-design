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
            if (isset($_POST['articlePagination'])) {
                $articlePagination = $_POST['articlePagination'];
                $article = Factory::createArticle();
                $data = $article->changePage($articlePagination, 5);
                $articles = $data['items'];
                $articlePage = $data['pageHtml'];
                $view->assign('articlePage', $articlePage);

                $announcementPagination = $_POST['announcementPagination'];
                $announcement =  Factory::createAnnouncement();
                $data = $announcement->changePage($announcementPagination, 5);
                $announcements = $data['items'];
                $announcementPage = $data['pageHtml'];
                $view->assign('announcementPage', $announcementPage);

                $categoryPagination = $_POST['categoryPagination'];
                $category = Factory::createCategory();
                $data = $category->changePage($categoryPagination, 5);
                $categorys = $data['items'];
                $categoryPage = $data['pageHtml'];
                $view->assign('categoryPage', $categoryPage);

                $commentPagination = $_POST['commentPagination'];
                $comment = Factory::createComment();
                $data = $comment->changePage($commentPagination, 5);
                $comments = $data['items'];
                $commentPage = $data['pageHtml'];
                $view->assign('commentPage', $commentPage);

                $messagePagination = $_POST['messagePagination'];
                $message = Factory::createMessage();
                $data = $message->changePage($messagePagination, 5);
                $messages = $data['items'];
                $messagePage = $data['pageHtml'];
                $view->assign('messagePage', $messagePage);

                $userPagination = $_POST['userPagination'];
                $user = Factory::createUser();
                $data = $user->changePage($userPagination, 5);
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
            // $announcement =  Factory::createAnnouncement();
            // $article = Factory::createArticle();
            // $category = Factory::createCategory();
            // $comment =  Factory::createComment();
            // $message = Factory::createMessage();
            // $user = Factory::createUser();
            // $announcements = $announcement->getAllAnnouncement();
            // $data = $article->firstPage();
            // $articles = $data['article'];
            // $pageHtml = $data['pageHtml'];
            // // $articles = $article->getAllArticle();
            // $categorys = $category->getAllCategory();
            // $comments = $comment->getAllComment();
            // $messages = $message->getAllMessage();
            // $users = $user->getAllUser();
            $view->assign('username', $username);
            $view->assign('announcements', $announcements);
            $view->assign('articles', $articles);
            $view->assign('categorys', $categorys);
            $view->assign('comments', $comments);
            // $view->assign('pageHtml', $pageHtml);
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
