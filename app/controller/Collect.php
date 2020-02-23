<?php

namespace app\controller;

use core\lib\Controller;

class Collect extends Controller
{
    public function checkCollect()
    {
        // 思路：只有按钮，用户点击之后，先确认用户是否已经点赞，若已经点赞，则取消点赞，否则点赞加1
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['username']) && isset($_POST['article_id'])) {
            $username = $_POST['username'];
            $article_id = $_POST['article_id'];
            $collect = new \app\model\Collect();
            $res =  $collect->checkCollect($username, $article_id);
            if ($res) {
                // 如果已经点赞了，返回0,顺便取消点赞
                if ($this->cancelCollect($username, $article_id)) {
                    // 已经取消点赞
                    echo "0";
                }
            } else {
                // 如果还没有点赞
                if ($this->addCollect($username, $article_id)) {
                    // 已经点赞
                    echo "1";
                }
            }
        } else {
        }
    }

    public function cancelCollect($username, $article_id)
    {

        $collect = new \app\model\Collect();
        $res =  $collect->cancelCollect($username, $article_id);
        return $res;
    }

    public function addCollect($username, $article_id)
    {
        $collect = new \app\model\Collect();
        $res =  $collect->addCollect($username, $article_id);
        return $res;
    }
}