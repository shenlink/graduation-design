<?php

namespace app\model;

use core\lib\Model;

class Information extends Model
{
    public function getInformation($username)
    {
        return $this->table('information')->field('information_id,user_id,content')->where(['username' => "{$username}"])->selectAll();
    }

    // 应该传入id
    public function delInformation($information_id)
    {
        return $this->table('information')->where(['information_id' => "{$information_id}"])->delete();
    }
}