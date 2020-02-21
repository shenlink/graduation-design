<?php

namespace app\model;

use core\lib\Model;

class Index extends Model
{
    public function pagination()
    {
        return $this->table('article')->field('title,content,created_at,collect_count,comment_count')->pages(1,5);
    }

    public function mutativePage($currentPage,$pageSize)
    {
        return $this->table('article')->field('title,content,created_at,collect_count,comment_count')->pages($currentPage, $pageSize);
    }
}
