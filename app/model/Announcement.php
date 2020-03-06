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
    public function getAllAnnouncement($currentPage, $pageSize)
    {
        return $this->table('announcement')->field('announcement_id,content,created_at')-> pages($currentPage, $pageSize);
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

}