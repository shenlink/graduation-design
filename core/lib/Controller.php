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
    /**
     * 执行前调用
     */
    public function beforeAction($action)
    {
        Log::log('beforeAction:' . $action);
    }
    /**
     * 执行后调用
     */
    public function afterAction($action)
    {
        Log::log('afterAction:' . $action);
    }

    public static function check()
    {
        $route = new Route();
        $controller = $route->controller;
        $action = $route->action;
        $controllerFile = APP . '/controller/' . $controller . '.php';
        // 反斜杠究竟要用一个还是两个？
        $controllerClass = '\\app' . '\\controller\\' . $controller;
        if (is_file($controllerFile)) {
            include $controllerFile;
            $controller = new $controllerClass();
            $controller->beforeAction($action);
            $controller->$action();
            $controller->afterAction($action);
            // action前有空格
            Log::log('controller:' . $controllerClass . ' action:' . $action);
        } else {
            Log::log('找不到控制器' . $controllerClass);
            $view = Factory::createView();
            $view->display('notfound.html');

        }
    }
}
