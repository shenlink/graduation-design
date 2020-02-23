<?php

namespace app\controller;

use core\lib\Controller;

class Fans extends Controller
{
    public function checkFans()
    {
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['author']) && isset($_POST['username'])) {
            $author = $_POST['author'];
            $username = $_POST['username'];
            $fans = new \app\model\Fans();
            $res =  $fans->checkFans($author, $username);
            if ($res) {

                if ($this->cancelFans($author, $username)) {

                    echo "0";
                }
            } else {

                if ($this->addFans($author, $username)) {

                    echo "1";
                }
            }
        } else {
        }
    }

    public function cancelFans($author, $username)
    {
        $fans = new \app\model\Fans();
        $res =  $fans->cancelFans($author, $username);
        return $res;
    }

    public function addFans($author, $username)
    {
        $fans = new \app\model\Fans();
        $res =  $fans->addFans($author, $username);
        return $res;
    }
}