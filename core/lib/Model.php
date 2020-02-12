<?php

namespace core\lib;

use core\lib\Db;

/**
 * 模型类
 */
class Model extends Db
{
    public function __construct()
    {
        return Db::getInstance();

    }
}
