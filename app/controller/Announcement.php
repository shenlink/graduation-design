<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;

class Announcement extends Controller
{

    // 显示404页面
    public function displayNone()
    {
        $view = Factory::createView();
        $view->display('notfound.html');
    }

    // 删除公告
    public function delAnnouncement()
    {
        if (isset($_POST['announcement_id'])) {
            $announcement_id = $_POST['announcement_id'];
            $announcement  =  Factory::createAnnouncement();
            $result = $announcement->delAnnouncement($announcement_id);
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
        $view = Factory::createView();
        if (isset($_POST['addAnnouncement'])) {
            $addAnnouncement = $_POST['addAnnouncement'];
            $category = Factory::createCategory();
            $categorys = $category->getCategory();
            $view->assign('addAnnouncement', $addAnnouncement);
            $view->assign('categorys', $categorys);
            $view->display('add.html');
        } else {
            $this->displayNone();
        }
    }

    // 确认添加
    public function checkAddAnnouncement()
    {
        if (isset($_POST['content'])) {
            $content = $_POST['content'];
            $announcement  =  Factory::createAnnouncement();
            date_default_timezone_set('PRC');
            $created_at = date('Y-m-d H:i:s', time());
            $result = $announcement->checkAddAnnouncement($content, $created_at);
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
