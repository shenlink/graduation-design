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
        if (isset($_POST['announcement_id'])) {
            $announcement_id = $_POST['announcement_id'];
            $result = $this->announcement->delAnnouncement($announcement_id);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }

    // 添加页面，共有添加分类，公告功能
    public function addAnnouncement()
    {
        if (isset($_POST['addAnnouncement'])) {
            $addAnnouncement = $_POST['addAnnouncement'];
            $categorys = $this->category->getCategory();
            $recommends = $this->article->recommend();
            $this->view->assign('addAnnouncement', $addAnnouncement);
            $this->view->assign('categorys', $categorys);
            $this->view->assign('recommends', $recommends);
            $this->view->display('add.html');
        } else {
            $this->displayNone();
        }
    }

    // 确认添加
    public function checkAddAnnouncement()
    {
        if (isset($_POST['content'])) {
            $content = $_POST['content'];
            date_default_timezone_set('PRC');
            $created_at = date('Y-m-d H:i:s', time());
            $result = $this->announcement->checkAddAnnouncement($content, $created_at);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
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
