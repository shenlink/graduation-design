<?php

namespace app\model;

use core\lib\Model;

class Comment extends Model
{
    public function manage($username)
    {
        return $this->table('comment')->field('comment_id,content,created_at,article_id,username')->where(['username' => "{$username}"])->selectAll();
    }

    public function delComment($comment_id)
    {
        return $this->table('comment')->where(['comment_id'=>"{$comment_id}"])->delete();
    }
}