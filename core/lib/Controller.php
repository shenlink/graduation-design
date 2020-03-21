<?php

namespace core\lib;

use core\lib\Log;
use core\lib\Route;
use core\lib\Factory;

/**
 * 控制器基类
 */
class Controller
{

    public function __construct()
    {
        $this->announcement =  Factory::createAnnouncement();
        $this->article = Factory::createArticle();
        $this->category = Factory::createCategory();
        $this->collect = Factory::createCollect();
        $this->comment = Factory::createComment();
        $this->follow = Factory::createFollow();
        $this->message = Factory::createMessage();
        $this->praise = Factory::createPraise();
        $this->receive = Factory::createReceive();
        $this->share = Factory::createShare();
        $this->user = Factory::createUser();
        $this->view = Factory::createView();
    }

    // 执行前调用
    public function beforeAction($action)
    {
        session_start();
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            Log::log("用户{$username}:" . 'beforeAction:' .  $action);
        } else {
            Log::log('beforeAction:' . $action);
        }
    }

    // 执行后调用
    public function afterAction($action)
    {
        session_start();
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            Log::log("用户{$username}:" . 'afterAction:' . $action);
        } else {
            Log::log('afterAction:' . $action);
        }
    }

    public static function check()
    {
        $route = new Route();
        $controller = $route->controller;
        $action = $route->action;
        $controllerFile = APP . '/controller/' . $controller . '.php';
        $controllerClass = '\\app' . '\\controller\\' . $controller;
        if (is_file($controllerFile)) {
            include $controllerFile;
            $controller = new $controllerClass();
            $controller->beforeAction($action);
            $controller->$action();
            $controller->afterAction($action);
            session_start();
            if (isset($_SESSION['username'])) {
                $username = $_SESSION['username'];
                Log::log("用户{$username}:" . 'controller:' . $controllerClass . ' action:' . $action);
            } else {
                Log::log('controller:' . $controllerClass . ' action:' . $action);
            }
        } else {
            session_start();
            if (isset($_SESSION['username'])) {
                $username = $_SESSION['username'];
                Log::log("用户{$username}:" . '找不到控制器' . $controllerClass);
            } else {
                Log::log('找不到控制器' . $controllerClass);
            }
            $view = Factory::createView();
            $view->assign('error', 'error');
            $view->display('error.html');
        }
    }
}
