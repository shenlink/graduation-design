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

    public function user()
    {
        return $this->table('user')->field('user_id,username,role,article_count,follows_count,fans_count,created_at,status')->selectAll();
    }

    public function article()
    {
        return $this->table('article')->field('article_id,author_id,title,status,created_at,updated_at,category,comment_count,praise_count,collect_count')->selectAll();
    }

    public function category()
    {
        return $this->table('category')->field('category_id,category,status,article_count')->selectAll();
    }

    public function comment()
    {
        return $this->table('comment')->field('comment_id,content,status,created_at,article_id,username')->selectAll();
    }

    public function announcement()
    {
        return $this->table('announcement')->field('announcement_id,content,created_at,updated_at,status')->selectAll();
    }
}
