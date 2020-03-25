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

    public function manage($type = 'user', $pagination = 1)
    {
        if ($this->username === 'shen') {
            $pagination = $type == 'article' ? $pagination : 1;
            $data = $this->article->getAllArticle($pagination, 5);
            $articles = $data['items'];
            $articlePage = $data['pageHtml'];
            $this->view->assign('articlePage', $articlePage);

            $pagination = $type == 'announcement' ? $pagination : 1;
            $data = $this->announcement->getAllAnnouncement($pagination, 5);
            $announcements = $data['items'];
            $announcementPage = $data['pageHtml'];
            $this->view->assign('announcementPage', $announcementPage);

            $pagination = $type == 'category' ? $pagination : 1;
            $data = $this->category->getAllCategory($pagination, 5);
            $AllCategorys = $data['items'];
            $categoryPage = $data['pageHtml'];
            $this->view->assign('categoryPage', $categoryPage);

            $pagination = $type == 'comment' ? $pagination : 1;
            $data = $this->comment->getAllComment($pagination, 5);
            $comments = $data['items'];
            $commentPage = $data['pageHtml'];
            $this->view->assign('commentPage', $commentPage);

            $pagination = $type == 'message' ? $pagination : 1;
            $data = $this->message->getAllMessage($pagination, 5);
            $messages = $data['items'];
            $messagePage = $data['pageHtml'];
            $this->view->assign('messagePage', $messagePage);

            $pagination = $type == 'user' ? $pagination : 1;
            $data = $this->user->getAllUser($pagination, 5);
            $users = $data['items'];
            $userPage = $data['pageHtml'];
            $this->view->assign('userPage', $userPage);
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
