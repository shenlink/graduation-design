<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;

class Message extends Controller
{
    // 显示404页面
    public function displayNone()
    {
        $view = Factory::createView();
        $view->display('notfound.html');
    }

    public function addMessage()
    {
        session_start();
        if (isset($_POST['author'])) {
            $username = $_SESSION['username'];
            $author = $_POST['author'];
            $view = Factory::createView();
            $category = Factory::createCategory();
            $categorys = $category->getCategory();
            $view->assign('categorys', $categorys);
            $view->assign('author', $author);
            $view->assign('username', $username);
            $view->display('add.html');
        } else {
            $this->displayNone();
        }
    }

    // 处理私信数据
    public function checkAddMessage()
    {
        if (isset($_POST['author']) && isset($_POST['content'])) {
            $author = $_POST['author'];
            $content = $_POST['content'];
            $message = Factory::createMessage();
            date_default_timezone_set('PRC');
            $created_at = date('Y-m-d H:i:s', time());
            $result = $message->checkAddMessage($author, $content, $created_at);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }

    // 删除私信
    public function delMessage()
    {
        if (isset($_POST['message_id'])) {
            $message_id = $_POST['message_id'];
            $message  =  Factory::createMessage();
            $result = $message->delMessage($message_id);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        }
    }
}
