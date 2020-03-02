<?php

namespace app\model;

use core\lib\Model;

class Information extends Model
{

    private static $information;
    public static function getInstance()
    {
        if (self::$information) {
            return self::$information;
        } else {
            self::$information = new self();
            return self::$information;
        }
    }

    // 获取私信信息
    public function getInformation($username)
    {
        return $this->table('information')->field('information_id,username,content')->where(['username' => "{$username}"])->selectAll();
    }

    // 删除私信
    public function delInformation($information_id)
    {
        return $this->table('information')->where(['information_id' => "{$information_id}"])->delete();
    }
}