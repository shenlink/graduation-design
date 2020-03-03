<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;

class Praise extends Controller
{

    // 显示404页面
    public function displayNone()
    {
        $view = Factory::createView();
        $view->display('notfound.html');
    }

    // 确认点赞
    public function checkPraise()
    {
        // 思路：只有按钮，用户点击之后，先确认用户是否已经点赞，若已经点赞，则取消点赞，否则点赞加1
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['username']) && isset($_POST['article_id']) && isset($_POST['author']) && isset($_POST['title'])) {
            $username = $_POST['username'];
            $article_id = $_POST['article_id'];
            $author = $_POST['author'];
            $title = $_POST['title'];
            $praise =  Factory::createPraise();
            $result =  $praise->checkPraise($username, $article_id);
            if ($result) {
                // 如果已经点赞了，返回0,顺便取消点赞
                $cancel = $praise->cancelPraise($username, $article_id);
                if ($cancel) {
                    // 已经取消点赞
                    echo "0";
                }
            } else {
                // 如果还没有点赞
                date_default_timezone_set('PRC');
                $praise_at = date('Y-m-d H:i:s', time());
                $add = $praise->addPraise($article_id, $author, $title, $username, $praise_at);
                if ($add) {
                    // 已经点赞
                    echo "1";
                }
            }
        } else {
            $this->displayNone();
        }
    }

    public function delPraise()
    {
        if (isset($_POST['article_id']) && isset($_POST['praise_id'])) {
            $article_id = $_POST['article_id'];
            $praise_id = $_POST['praise_id'];
            $praise =  Factory::createPraise();
            $result = $praise->delPraise($article_id, $praise_id);
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
