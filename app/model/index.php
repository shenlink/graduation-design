<?php

namespace app\model;

use core\lib\Model;

class Index extends Model
{
    public function index()
    {
        return $this->table('article')->field('title, content,created_at,collect_count,comment_count')->selectAll();
    }
    public function test()
    {
        return $this->table('article')->field('title,content,created_at,collect_count,comment_count')->selectAll();
    }

}
