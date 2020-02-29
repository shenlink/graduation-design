<?php

namespace app\model;

use core\lib\Model;

class Admin extends Model
{
    private static $admin;
    public static function getInstance()
    {
        if (self::$admin) {
            return self::$admin;
        } else {
            self::$admin = new self();
            return self::$admin;
        }
    }

    // 查询user表中的数据
    public function user()
    {
        return $this->table('user')->field('user_id,username,role,article_count,follows_count,fans_count,created_at,status')->selectAll();
    }

    // 查询article表中的数据
    public function article()
    {
        return $this->table('article')->field('article_id,author,title,status,created_at,updated_at,category,comment_count,praise_count,collect_count')->selectAll();
    }

    // 查询category表中的数据
    public function category()
    {
        return $this->table('category')->field('category_id,category,status,article_count')->selectAll();
    }

    // 查询comment表中的数据
    public function comment()
    {
        return $this->table('comment')->field('comment_id,content,status,created_at,article_id,username')->selectAll();
    }

    // 查询announcement表中的数据
    public function announcement()
    {
        return $this->table('announcement')->field('announcement_id,content,created_at')->selectAll();
    }

    // 拉黑某篇文章
    public function defriendArticle()
    {
        return $this->table('article')->field('status')->update(['status' => 0]);
    }
}
