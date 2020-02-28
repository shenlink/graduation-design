<?php

namespace app\model;

use core\lib\Model;

class Announcement extends Model
{

    // 获取公告信息
    public function getAnnouncement()
    {
        return $this->table('announcement')->field('content')->where(['status'=>1])->selectAll();
    }

    // 添加公告
    public function addAnnouncement($content)
    {
        return $this->table('announcement')->insert(['content'=>"{$content}"]);
    }

    // 删除公告
    public function delAnnouncement($announcement_id)
    {
        return $this->table('announcement')->where(['announcement_id'=> "{$announcement_id}"])->delete();
    }
}