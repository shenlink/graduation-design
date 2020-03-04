<?php

namespace app\model;

use core\lib\Model;

class Receive extends Model
{

    private static $receive;
    public static function getInstance()
    {
        if (self::$receive) {
            return self::$receive;
        } else {
            self::$receive = new self();
            return self::$receive;
        }
    }

    public function getReceive($username)
    {
        // 获取私信信息
        return $this->table('receive')->field('receive_id,content,receive_at')->where(['username' => "{$username}"])->order('receive_at desc')->selectAll();
    }

    // 删除私信
    public function delReceive($receive_id)
    {
        return $this->table('receive')->where(['receive_id' => "{$receive_id}"])->delete();
    }
}
