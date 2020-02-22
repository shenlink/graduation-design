<?php

namespace app\model;

use core\lib\Model;

class Announcement extends Model
{
    public function addAnnouncement()
    {
        return $this->table('announcement')->insert([]);
    }

    public function delAnnouncement($announcement_id)
    {
        return $this->table('announcement')->where(['announcement_id'=> "{$announcement_id}"])->delete();
    }
}