<?php

namespace app\controller;

use core\lib\Controller;

class Announcement extends Controller
{

    // 显示404页面
    public function displayNone()
    {
        $this->view->assign('error', 'error');
        $this->view->display('error.html');
    }

    // 删除公告
    public function delAnnouncement()
    {
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['announcement_id'])) {
            $announcement_id = $_POST['announcement_id'];
            $result = $this->announcement->delAnnouncement($announcement_id);
            echo $result ? '1' : '0';
        } else {
            $this->displayNone();
        }
    }

    // 添加页面，共有添加分类，公告功能
    public function addAnnouncement()
    {
        if($_SESSION['username']=='shen'){
            $addAnnouncement = $_POST['addAnnouncement'];
            $recommends = $this->article->recommend();
            $this->view->assign('addAnnouncement', $addAnnouncement);
            $this->view->assign('recommends', $recommends);
            $this->view->display('add.html');
        } else {
            $this->displayNone();
        }
        // header("Content-type:text/html;charset=utf-8");
        // if (isset($_POST['addAnnouncement'])) {
        //     $addAnnouncement = $_POST['addAnnouncement'];
        //     $recommends = $this->article->recommend();
        //     $this->view->assign('addAnnouncement', $addAnnouncement);
        //     $this->view->assign('recommends', $recommends);
        //     $this->view->display('add.html');
        // }
    }

    // 确认添加
    public function checkAddAnnouncement()
    {
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['content'])) {
            $content = $_POST['content'];
            $result = $this->announcement->checkAddAnnouncement($content, $this->time);
            echo $result ? '1' : '0';
        } else {
            $this->displayNone();
        }
    }

    public function __call($method, $args)
    {
        $this->view->assign('error','error');
        $this->view->display('error.html');
    }
}
