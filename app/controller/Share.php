<?php

namespace app\controller;

use core\lib\Controller;

class Share extends Controller
{
    public function checkShare()
    {
        // 思路：只有按钮，用户点击之后，先确认用户是否已经点赞，若已经点赞，则取消点赞，否则点赞加1
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['username']) && isset($_POST['article_id'])) {
            $username = $_POST['username'];
            $article_id = $_POST['article_id'];
            $share = new \app\model\Share();
            $res =  $share->checkShare($username, $article_id);
            if ($res) {
                $cancel = $share->cancelShare($username, $article_id);
                if ($cancel) {
                    echo "0";
                }
            } else {
                $add = $share->addShare($username, $article_id);
                if ($add) {
                    echo "1";
                }
            }
        } else {
            echo '404';
        }
    }
}
