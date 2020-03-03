<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;

class Comment extends Controller
{

    // 显示404页面
    public function displayNone()
    {
        $view = Factory::createView();
        $view->display('notfound.html');
    }

    // 发表评论
    public function addComment()
    {
        if (isset($_POST['article_id'])  && isset($_POST['author']) && isset($_POST['title']) && isset($_POST['content']) && isset($_POST['username'])) {
            $article_id = $_POST['article_id'];
            $author = $_POST['author'];
            $title = $_POST['title'];
            $content = $_POST['content'];
            $username = $_POST['username'];
            date_default_timezone_set('PRC');
            $comment_at = date('Y-m-d H:i:s', time());
            $comment =  Factory::createComment();
            $result = $comment->addComment($article_id, $author, $title,  $content, $username, $comment_at);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }

    // 删除评论
    public function delComment()
    {
        if (isset($_POST['article_id']) && isset($_POST['comment_id'])) {
            $comment_id = $_POST['comment_id'];
            $article_id = $_POST['article_id'];
            $comment  =  Factory::createComment();
            $result = $comment->delComment($article_id, $comment_id);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }
}
