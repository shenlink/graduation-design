<?php

namespace core\common;
use core\lib\Route;
use core\lib\Log;

class Start{
    /**
     * 启动框架
     */
    static public function run()
    {
        Log::init();
        $route = new Route();
        $controller = $route->controller;
        $action = $route->action;
        $controllerFile = APP . '/controller/' . $controller . '.php';
        $controllerClass = '\\' . MODULE . '\controller\\' . $controller;
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
            throw new \Exception('找不到控制器' . $controllerClass);
        }
    }
}