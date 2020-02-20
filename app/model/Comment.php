<?php

namespace app\model;

use core\lib\Model;

class Comment extends Model
{
    public function manage($username)
    {
        return $this->table('comment')->field('content,created_at,article_id,username')->where(['username' => "{$username}"])->selectAll();
    }
}