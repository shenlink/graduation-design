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



    // 当用户访问首页时，执行此方法,感觉这个方法可以和下面的方法合二为一
    public function firstManagePage()
    {
        return $this->table('receive')->field('receive_id,content,receive_at')->pages(1, 5);
    }

    // 当用户点击首页下的页码时，执行此方法
    public function changeManagePage($currentPage, $pageSize)
    {
        return $this->table('receive')->field('receive_id,content,receive_at')->pages($currentPage, $pageSize);
    }
}
