<?php

namespace app\controller;

use core\lib\Controller;

use core\lib\Factory;

class Comment extends Controller
{
    public function addComment()
    {
        if (isset($_POST['username']) && isset($_POST['article_id'])) {
            $username = $_POST['username'];
            $article_id = $_POST['article_id'];
            $comment = new \app\model\Comment();
            $res = $comment->addComment($username, $article_id);
            if ($res) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
        }
    }

    public function delComment()
    {
        if (isset($_POST['comment_id'])) {
            // 要下判断是不是这个用户的评论
            $comment_id = $_POST['comment_id'];
            $comment = new \app\model\Comment();
            $res = $comment->delComment($comment_id);
            if ($res) {
                echo '1';
            } else {
                echo '0';
            }
        }
    }
}
