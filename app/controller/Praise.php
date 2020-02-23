<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;

class Praise extends Controller
{
    public function checkPraise()
    {
        // 思路：只有按钮，用户点击之后，先确认用户是否已经点赞，若已经点赞，则取消点赞，否则点赞加1
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['username']) && isset($_POST['article_id'])) {
            $username = $_POST['username'];
            $article_id = $_POST['article_id'];
            $praise = new \app\model\Praise();
            $res =  $praise->checkPraise($username, $article_id);
            if ($res) {
                // 如果已经点赞了，返回0,顺便取消点赞
                $res = $praise->cancelPraise($username, $article_id);
                if ($res) {
                    // 已经取消点赞
                    echo "0";
                }
            } else {
                // 如果还没有点赞
                $res = $praise->addPraise($username, $article_id);
                if ($res) {
                    // 已经点赞
                    echo "1";
                }
            }
        } else {
            echo '404';
        }
    }
}
