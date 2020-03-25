<?php

namespace core\lib;

use core\lib\Config;
use core\lib\Db;
use core\lib\Factory;

class Route extends Db
{

    public $controller;
    public $action;
    // 1. 隐藏index.php
    // 2. 获取URL参数部分
    // 3. 返回对应的控制器和方法
    public function __construct()
    {
        if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/') {
            $path = $_SERVER['REQUEST_URI'];
            $patharr = explode('/', trim($path, '/'));
            if (isset($patharr[0])) {
                $this->controller = $patharr[0];
            }
            if (isset($patharr[1])) {
                $this->action = $patharr[1];
            }
            if ($patharr[0] == 'admin' && $patharr[1] == 'manage') {
                $typeArr = ['user', 'article', 'category', 'comment', 'announcement', 'message'];
                if (in_array($patharr[2], $typeArr)) {
                    $this->type = $patharr[2];

                    $this->pagination = $patharr[3];
                }
            }
            if ($patharr[0] == 'category' && $patharr[2] = 'pagination') {
                $category = $this->table('category')->field('category')->where(['category' => "{$patharr[1]}"])->select();
                if ($category) {
                    $this->type = 'pagination';
                    $this->pagination = $patharr[3];
                }
            }
            if ($patharr[0] == 'index' && $patharr[1] == 'index' && $patharr[2] = 'pagination' || $path = '/') {
                $this->type = 'pagination';
                $this->pagination = $patharr[3];
            }
            if ($patharr[0] == 'user') {
                $manageType = ['article', 'comment', 'follow', 'fans'];
                $userType = ['article', 'comment', 'praise', 'collect','share'];
                $username = $this->table('user')->where(['username' => "{$patharr[1]}", 'status' => 1])->select();
                if ($patharr[1] == 'manage') {
                    if (in_array($patharr[2], $manageType)) {
                        $this->type = $patharr[2];
                        $this->pagination = $patharr[3];
                    }
                }
                if ($username) {
                    if (in_array($patharr[2], $userType)) {
                        $this->type = $patharr[2];
                        $this->pagination = $patharr[3];
                    }
                }
            }
        } else {
            $this->controller = Config::get('DEFAULT_CONTROLLER', 'route');
            $this->action = Config::get('DEFAULT_ACTION', 'route');
        }
    }
}
