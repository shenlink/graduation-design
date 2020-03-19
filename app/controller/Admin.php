<?php

namespace app\controller;

use core\lib\Controller;
use app\controller\Validate;

class Admin extends Controller
{

    public function displayNone()
    {
        $this->view->assign('error', 'error');
        $this->view->display('error.html');
    }

    public function manage()
    {
        $access = Validate::checkAccess();
        if ($access == '1') {
            $username = $_SESSION['username'];
            if (isset($_POST['type'])) {
                if ($_POST['articlePages']) {
                    $data = $this->article->getAllArticle($_POST['articlePages'], 5);
                } else {
                    $data = $this->article->getAllArticle(1, 5);
                }
                $articles = $data['items'];
                $articlePage = $data['pageHtml'];
                $this->view->assign('articlePage', $articlePage);

                if ($_POST['announcementPages']) {
                    $data = $this->announcement->getAllAnnouncement($_POST['announcementPages'], 5);
                } else {
                    $data = $this->announcement->getAllAnnouncement(1, 5);
                }
                $announcements = $data['items'];
                $announcementPage = $data['pageHtml'];
                $this->view->assign('announcementPage', $announcementPage);

                if ($_POST['categoryPages']) {
                    $data = $this->category->getAllCategory($_POST['categoryPages'], 5);
                } else {
                    $data = $this->category->getAllCategory(1, 5);
                }
                $categorys = $data['items'];
                $categoryPage = $data['pageHtml'];
                $this->view->assign('categoryPage', $categoryPage);

                if ($_POST['commentPages']) {
                    $data = $this->comment->getAllComment($_POST['commentPages'], 5);
                } else {
                    $data = $this->comment->getAllComment(1, 5);
                }
                $comments = $data['items'];
                $commentPage = $data['pageHtml'];
                $this->view->assign('commentPage', $commentPage);

                if ($_POST['messagePages']) {
                    $data = $this->message->getAllMessage($_POST['messagePages'], 5);
                } else {
                    $data = $this->message->getAllMessage(1, 5);
                }
                $messages = $data['items'];
                $messagePage = $data['pageHtml'];
                $this->view->assign('messagePage', $messagePage);

                if ($_POST['userPages']) {
                    $data = $this->user->getAllUser($_POST['userPages'], 5);
                } else {
                    $data = $this->user->getAllUser(1, 5);
                }
                $users = $data['items'];
                $userPage = $data['pageHtml'];
                $this->view->assign('userPage', $userPage);
                $type = $_POST['type'];
            } else {
                $data = $this->article->getAllArticle();
                $articles = $data['items'];
                $articlePage = $data['pageHtml'];
                $this->view->assign('articlePage', $articlePage);

                $data = $this->announcement->getAllAnnouncement();
                $announcements = $data['items'];
                $announcementPage = $data['pageHtml'];
                $this->view->assign('announcementPage', $announcementPage);

                $data = $this->category->getAllCategory();
                $categorys = $data['items'];
                $categoryPage = $data['pageHtml'];
                $this->view->assign('categoryPage', $categoryPage);

                $data = $this->comment->getAllComment();
                $comments = $data['items'];
                $commentPage = $data['pageHtml'];
                $this->view->assign('commentPage', $commentPage);

                $data = $this->message->getAllMessage();
                $messages = $data['items'];
                $messagePage = $data['pageHtml'];
                $this->view->assign('messagePage', $messagePage);

                $data = $this->user->getAllUser();
                $users = $data['items'];
                $userPage = $data['pageHtml'];
                $this->view->assign('userPage', $userPage);
                $type = 'user';
            }
            $this->view->assign('username', $username);
            $this->view->assign('announcements', $announcements);
            $this->view->assign('articles', $articles);
            $this->view->assign('categorys', $categorys);
            $this->view->assign('comments', $comments);
            $this->view->assign('messages', $messages);
            $this->view->assign('type', $type);
            $this->view->assign('users', $users);
            $this->view->display('admin.html');
        } else if ($access == '2') {
            $this->view->assign('noadmin', 'noadmin');
            $this->view->display('error.html');
        } else {
            $this->view->assign('nologin', 'nologin');
            $this->view->display('error.html');
        }
    }

    public function __call($method, $args)
    {
        $this->view->assign('error', 'error');
        $this->view->display('error.html');
    }
}
