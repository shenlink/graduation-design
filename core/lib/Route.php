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
            $pathArray = explode('/', trim($path, '/'));
            if (count($pathArray) > 4) {
                $view = Factory::createView();
                $view->assign('error', 'error');
                $view->display('error.html');
                exit();
            }
            if (isset($pathArray[0])) {
                $this->controller = $pathArray[0];
            }
            if (isset($pathArray[1])) {
                $this->action = $pathArray[1];
            }
            $pathArray[3] = $pathArray[3] ?? 1;
            if (preg_match('/^([1-9][0-9]*){1,10}$/', $pathArray[3])) {
                if ($pathArray[0] == 'admin' && $pathArray[1] == 'manage') {
                    $typeArr = ['user', 'article', 'category', 'comment', 'announcement', 'message'];
                    if (in_array($pathArray[2], $typeArr)) {
                        $this->type = $pathArray[2];
                        $this->pagination = $pathArray[3];
                    }
                }

                if ($pathArray[0] == 'category') {
                    $category = $this->table('category')->field('category')->where(['category' => "{$pathArray[1]}"])->select();
                    if ($category) {
                        $this->type = 'pagination';
                        $this->pagination = $pathArray[3];
                    }
                    if (isset($pathArray[2]) && $pathArray[2] != 'pagination') {
                        $view = Factory::createView();
                        $view->assign('error', 'error');
                        $view->display('error.html');
                        exit();
                    }
                }

                if ($pathArray[0] == 'index' && $pathArray[1] == 'index' && $pathArray[2] == 'pagination') {
                    $this->type = 'pagination';
                    $this->pagination = $pathArray[3];
                }
                if ($pathArray[0] == 'index' && $pathArray[1] == 'index' && $pathArray[2] != 'pagination') {
                    $view = Factory::createView();
                    $view->assign('error', 'error');
                    $view->display('error.html');
                    exit();
                }

                if ($pathArray[0] == 'user') {
                    $manageType = ['article', 'comment', 'follow', 'fans'];
                    $userType = ['article', 'comment', 'praise', 'collect', 'share'];
                    $username = $this->table('user')->where(['username' => "{$pathArray[1]}", 'status' => 1])->select();
                    if ($pathArray[1] == 'manage') {
                        if (in_array($pathArray[2], $manageType)) {
                            $this->type = $pathArray[2];
                            $this->pagination = $pathArray[3];
                        }
                        if(!in_array($pathArray[2], $manageType)){
                            $view = Factory::createView();
                            $view->assign('error', 'error');
                            $view->display('error.html');
                            exit();
                        }
                    }
                    if ($username) {
                        if (in_array($pathArray[2], $userType)) {
                            $this->type = $pathArray[2];
                            $this->pagination = $pathArray[3];
                        }
                        if (!in_array($pathArray[2], $userType)) {
                            $view = Factory::createView();
                            $view->assign('error', 'error');
                            $view->display('error.html');
                            exit();
                        }
                    }
                }
            } else {
                $view = Factory::createView();
                $view->assign('error', 'error');
                $view->display('error.html');
                exit();
            }
        } else {
            $this->controller = Config::get('DEFAULT_CONTROLLER', 'route');
            $this->action = Config::get('DEFAULT_ACTION', 'route');
        }
    }
}
