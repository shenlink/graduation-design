<?php

namespace app\model;

use core\lib\Model;

class Post extends Model
{
    public function test($article_id)
    {
        return $this->table('article')->field('title,content,username,created_at,category_id,comment_count,praise_count,collect_count')->where(['article_id' => "{$article_id}"])->select();
    }
}