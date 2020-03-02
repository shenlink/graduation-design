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
        if (isset($_POST['content']) && isset($_POST['username']) && isset($_POST['article_id']) && isset($_POST['title'])  && isset($_POST['author'])) {
            $content = $_POST['content'];
            $username = $_POST['username'];
            $article_id = $_POST['article_id'];
            $title = $_POST['title'];
            $author = $_POST['author'];
            date_default_timezone_set('PRC');
            $comment_at = date('Y-m-d H:i:s', time());
            $comment =  Factory::createComment();
            $result = $comment->addComment($content, $username, $article_id, $title, $author, $comment_at);
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
        if (isset($_POST['comment_id'])) {
            $comment_id = $_POST['comment_id'];
            $comment  =  Factory::createComment();
            $result = $comment->delComment($comment_id);
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