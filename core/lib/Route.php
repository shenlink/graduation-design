<?php

namespace core\lib;

use core\lib\Config;

class Route
{

    public $controller;
    public $action;

    /**
     * 1. 隐藏index.php
     * 2. 获取URL参数部分
     * 3. 返回对应的控制器和方法
     */
    public function __construct()
    {
        // xxx.com/index.php/index/index
        if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/') {
            // 解析 /index/index
            $path = $_SERVER['REQUEST_URI'];
            $patharr = explode('/', trim($path, '/'));
            if (isset($patharr[0])) {
                $this->controller = $patharr[0];
                // unset($patharr[0]);
            }
            if (isset($patharr[1])) {
                $this->action = $patharr[1];
                // unset($patharr[1]);
            }
            $count = count($patharr) + 2;
            $i = 2;
            while ($i < $count) {
                if (isset($patharr[$i + 1])) {
                    $_GET[$patharr[$i]] = $patharr[$i + 1];
                }
                $i = $i + 2;
            }
        } else {
            $this->controller = Config::get('DEFAULT_CONTROLLER', 'route');
            $this->action = Config::get('DEFAULT_ACTION', 'route');
        }
    }
}
