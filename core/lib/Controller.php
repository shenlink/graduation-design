<?php

namespace core\lib;

use core\lib\Log;
use core\common\Response;


/**
 * 控制器基类
 */
class Controller
{

    public $assign = array();
    const DEFAULT_TYPE = "json";

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
    /**
     * 返回json数据
     */
    public function renderJson($code, $message, $data)
    {
        Response::show($code, $message, $data);
    }
    /**
     * 返回成功的json数据
     */
    public function success($data)
    {
        $this->renderJson(0, '成功', $data);
    }
    /**
     * 返回失败的json数据
     */
    public function error($code, $message, $data)
    {
        $this->renderJson($code, $message, $data);
    }

    /**
     * 重定向
     */
    public function redirect($url)
    {
        header('location:' . $url);
        exit();
    }
}
