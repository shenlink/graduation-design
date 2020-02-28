<?php

namespace app\model;

use core\lib\Model;

class Index extends Model
{
    // 当用户访问首页时，执行此方法
    public function pagination()
    {
        return $this->table('article')->field('article_id,title,content,created_at,collect_count,comment_count')->pages(1,5);
    }

    // 当用户点击首页下的页码时，执行此方法
    public function mutativePage($currentPage,$pageSize)
    {
        return $this->table('article')->field('article_id,title,content,created_at,collect_count,comment_count')->pages($currentPage, $pageSize);
    }
}
