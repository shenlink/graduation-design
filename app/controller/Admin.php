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
        $view->assign('error', 'error');
        $view->display('error.html');
    }

    // 显示管理员的管理页面
    public function manage()
    {
        // 确认权限，为1时允许操作
        $access = Validate::checkAccess();
        $view = Factory::createView();
        $announcement =  Factory::createAnnouncement();
        $article = Factory::createArticle();
        $category = Factory::createCategory();
        $comment = Factory::createComment();
        $message = Factory::createMessage();
        $user = Factory::createUser();
        if ($access == '1') {
            $username = $_SESSION['username'];
            if (isset($_POST['type'])) {
                if ($_POST['articlePages']) {
                    $data = $article->getAllArticle($_POST['articlePages'], 5);
                } else {
                    $data = $article->getAllArticle(1, 5);
                }
                $articles = $data['items'];
                $articlePage = $data['pageHtml'];
                $view->assign('articlePage', $articlePage);

                if ($_POST['announcementPages']) {
                    $data = $announcement->getAllAnnouncement($_POST['announcementPages'], 5);
                } else {
                    $data = $announcement->getAllAnnouncement(1, 5);
                }
                $announcements = $data['items'];
                $announcementPage = $data['pageHtml'];
                $view->assign('announcementPage', $announcementPage);

                if ($_POST['categoryPages']) {
                    $data = $category->getAllCategory($_POST['categoryPages'], 5);
                } else {
                    $data = $category->getAllCategory(1, 5);
                }
                $categorys = $data['items'];
                $categoryPage = $data['pageHtml'];
                $view->assign('categoryPage', $categoryPage);

                if ($_POST['commentPages']) {
                    $data = $comment->getAllComment($_POST['commentPages'], 5);
                } else {
                    $data = $comment->getAllComment(1, 5);
                }
                $comments = $data['items'];
                $commentPage = $data['pageHtml'];
                $view->assign('commentPage', $commentPage);

                if ($_POST['messagePages']) {
                    $data = $message->getAllMessage($_POST['messagePages'], 5);
                } else {
                    $data = $message->getAllMessage(1, 5);
                }
                $messages = $data['items'];
                $messagePage = $data['pageHtml'];
                $view->assign('messagePage', $messagePage);

                if ($_POST['userPages']) {
                    $data = $user->getAllUser($_POST['userPages'], 5);
                } else {
                    $data = $user->getAllUser(1, 5);
                }
                $users = $data['items'];
                $userPage = $data['pageHtml'];
                $view->assign('userPage', $userPage);
            } else {
                $data = $article->getAllArticle();
                $articles = $data['items'];
                $articlePage = $data['pageHtml'];
                $view->assign('articlePage', $articlePage);

                $data = $announcement->getAllAnnouncement();
                $announcements = $data['items'];
                $announcementPage = $data['pageHtml'];
                $view->assign('announcementPage', $announcementPage);

                $data = $category->getAllCategory();
                $categorys = $data['items'];
                $categoryPage = $data['pageHtml'];
                $view->assign('categoryPage', $categoryPage);

                $data = $comment->getAllComment();
                $comments = $data['items'];
                $commentPage = $data['pageHtml'];
                $view->assign('commentPage', $commentPage);

                $data = $message->getAllMessage();
                $messages = $data['items'];
                $messagePage = $data['pageHtml'];
                $view->assign('messagePage', $messagePage);

                $data = $user->getAllUser();
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
            $view->assign('noadmin', 'noadmin');
            $view->display('error.html');
        } else {
            $view->assign('nologin', 'nologin');
            $view->display('error.html');
        }
    }

    public function __call($method, $args)
    {
        $view = Factory::createView();
        $view->assign('error', 'error');
        $view->display('error.html');
    }
}
