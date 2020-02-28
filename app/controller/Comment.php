<?php

namespace app\controller;

use core\lib\Controller;

use core\lib\Factory;

class Comment extends Controller
{

    public function displayNone()
    {
        $view = Factory::createView();
        $view->display('notfound.html');
    }

    // 确认添加评论
    public function addComment()
    {
        if (isset($_POST['content']) && isset($_POST['username']) && isset($_POST['article_id'])) {
            $content = $_POST['content'];
            $username = $_POST['username'];
            $article_id = $_POST['article_id'];
            $comment = new \app\model\Comment();
            $res = $comment->addComment($content, $username, $article_id);
            if ($res) {
                echo $res;
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }

    // 确认删除评论
    public function delComment()
    {
        if (isset($_POST['comment_id'])) {
            // 要判断是不是这个用户的评论，在HTML页面用评论的username鱼SESSION的username作比较
            $comment_id = $_POST['comment_id'];
            $comment = new \app\model\Comment();
            $res = $comment->delComment($comment_id);
            if ($res) {
                echo '1';
            } else {
                echo '0';
            }
        }else{
            $this->displayNone();
        }
    }
}
