<?php

namespace core\lib;

use core\lib\Config;

use core\lib\Db;

/**
 * 模型类
 */
class Model extends Db
{

    // public $pdo;
    public function __construct()
    {
        $config = Config::all('database');
        parent::__construct($config);
    }
}
