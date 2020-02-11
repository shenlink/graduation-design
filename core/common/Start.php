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
        $ctrollerFile = APP . '/controller/' . $controller . '.php';
        $ctrollerClass = '\\' . MODULE . '\controller\\' . $controller;
        if (is_file($ctrollerFile)) {
            include $ctrollerFile;
            $ctrl = new $ctrollerClass();
            $ctrl->beforeAction($action);
            $ctrl->$action();
            $ctrl->afterAction($action);
            log::log('controller:' . $ctrollerClass . 'action:' . $action);
        } else {
            log: log('找不到控制器' . $ctrollerClass);
            throw new \Exception('找不到控制器' . $ctrollerClass);
        }
    }
}