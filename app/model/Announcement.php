<?php

namespace app\model;

use core\lib\Model;

class Announcement extends Model
{
    // 添加公告
    public function addAnnouncement()
    {
        return $this->table('announcement')->insert([]);
    }

    // 删除公告
    public function delAnnouncement($announcement_id)
    {
        return $this->table('announcement')->where(['announcement_id'=> "{$announcement_id}"])->delete();
    }
}