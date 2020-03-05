<?php

namespace app\model;

use core\lib\Model;

class Announcement extends Model
{

    private static $announcement;
    public static function getInstance()
    {
        if (self::$announcement) {
            return self::$announcement;
        } else {
            self::$announcement = new self();
            return self::$announcement;
        }
    }

    // 获取公告信息
    public function getAnnouncement()
    {
        return $this->table('announcement')->field('content')->selectAll();
    }

    // 查询announcement表中的数据
    public function getAllAnnouncement()
    {
        return $this->table('announcement')->field('announcement_id,content,created_at')->selectAll();
    }

    // 添加公告
    public function checkAddAnnouncement($content, $created_at)
    {
        return $this->table('announcement')->insert(['content'=>"{$content}", 'created_at'=>"{$created_at}"]);
    }

    // 删除公告
    public function delAnnouncement($announcement_id)
    {
        return $this->table('announcement')->where(['announcement_id'=> "{$announcement_id}"])->delete();
    }





    // 当用户访问首页时，执行此方法,感觉这个方法可以和下面的方法合二为一
    public function firstPage()
    {
        return $this->table('announcement')->field('announcement_id,content,created_at')->pages(1, 5);
    }

    // 当用户点击首页下的页码时，执行此方法
    public function changePage($currentPage, $pageSize)
    {
        return $this->table('announcement')->field('announcement_id,content,created_at')->pages($currentPage, $pageSize);
    }

}