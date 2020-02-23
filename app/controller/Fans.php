<?php

namespace app\controller;

use core\lib\Controller;

class Fans extends Controller
{
    // 关注和取消关注
    public function checkFans()
    {
        // 思路：只有按钮，用户点击之后，先确认用户是否已经点赞，若已经点赞，则取消点赞，否则点赞加1
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['username']) && isset($_POST['article_id'])) {
            $username = $_POST['username'];
            $article_id = $_POST['article_id'];
            $fans = new \app\model\Fans();
            $res =  $fans->checkFans($username, $article_id);
            if ($res) {

                if ($this->cancelFans($username, $article_id)) {

                    echo "0";
                }
            } else {

                if ($this->addFans($username, $article_id)) {

                    echo "1";
                }
            }
        } else {
        }
    }

    public function cancelFans($username, $article_id)
    {

        $fans = new \app\model\Fans();
        $res =  $fans->cancelFans($username, $article_id);
        return $res;
    }

    public function addFans($username, $article_id)
    {
        $fans = new \app\model\Fans();
        $res =  $fans->addFans($username, $article_id);
        return $res;
    }
}