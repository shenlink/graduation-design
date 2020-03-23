<?php

namespace app\controller;

use core\lib\Controller;

class Admin extends Controller
{

    public function displayNone()
    {
        $this->view->assign('error', 'error');
        $this->view->display('error.html');
    }

    public function manage()
    {
        if ($this->username === 'shen') {
            $articlePages = $_POST['articlePages'] ?? 1;
            $data = $this->article->getAllArticle($articlePages, 5);
            $articles = $data['items'];
            $articlePage = $data['pageHtml'];
            $this->view->assign('articlePage', $articlePage);

            $announcementPages = $_POST['announcementPages'] ?? 1;
            $data = $this->announcement->getAllAnnouncement($announcementPages, 5);
            $announcements = $data['items'];
            $announcementPage = $data['pageHtml'];
            $this->view->assign('announcementPage', $announcementPage);

            $categoryPages = $_POST['categoryPages'] ?? 1;
            $data = $this->category->getAllCategory($categoryPages, 5);
            $AllCategorys = $data['items'];
            $categoryPage = $data['pageHtml'];
            $this->view->assign('categoryPage', $categoryPage);

            $commentPages = $_POST['commentPages'] ?? 1;
            $data = $this->comment->getAllComment($commentPages, 5);
            $comments = $data['items'];
            $commentPage = $data['pageHtml'];
            $this->view->assign('commentPage', $commentPage);

            $messagePages = $_POST['messagePages'] ?? 1;
            $data = $this->message->getAllMessage($messagePages, 5);
            $messages = $data['items'];
            $messagePage = $data['pageHtml'];
            $this->view->assign('messagePage', $messagePage);

            $userPages = $_POST['userPages'] ?? 1;
            $data = $this->user->getAllUser($userPages, 5);
            $users = $data['items'];
            $userPage = $data['pageHtml'];
            $this->view->assign('userPage', $userPage);
            $type = isset($_POST['type']) ? $_POST['type'] : 'user';
            $this->view->assign('announcements', $announcements);
            $this->view->assign('articles', $articles);
            $this->view->assign('AllCategorys', $AllCategorys);
            $this->view->assign('comments', $comments);
            $this->view->assign('messages', $messages);
            $this->view->assign('type', $type);
            $this->view->assign('users', $users);
            $this->view->display('admin.html');
        } else if ($this->username !== 'shen') {
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
