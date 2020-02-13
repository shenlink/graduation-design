<?php

namespace core\lib;

use core\lib\Log;

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
}
