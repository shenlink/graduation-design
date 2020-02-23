<?php

namespace app\model;

use core\lib\Model;

class Article extends Model
{
    private static $article;
    public static function getInstance()
    {
        if (self::$article) {
            return self::$article;
        } else {
            self::$article = new self();
            return self::$article;
        }
    }

    public function search($search, $name)
    {
        $search = '%' . $search . '%';
        if ($name == '1') {
            $data = $this->table('user')->field('username,information,created_at,article_count,follows_count,fans_count')->where("username like \"{$search}\"")->selectAll();
        } else {
            $data = $this->table('article')->field('title,content,created_at,collect_count,comment_count')->where("content like \"{$search}\" or title like \"{$search}\"")->selectAll();
        }
        return $data;
    }

    public function index()
    {
        return $this->table('article')->field('title,content,created_at,collect_count,comment_count')->selectAll();
    }

    public function php()
    {
        return $this->table('article')->field('title,content,created_at,collect_count,comment_count')->where(['category' => 'php'])->selectAll();
    }

    public function mysql()
    {
        return $this->table('article')->field('title,content,created_at,collect_count,comment_count')->where(['category' => 'mysql'])->selectAll();
    }

    public function javaScript()
    {
        return $this->table('article')->field('title,content,created_at,collect_count,comment_count')->where(['category' => 'javaScript'])->selectAll();
    }

    public function getArticle($article_id)
    {
        return $this->table('article')->field('article_id,title,content,username,created_at,category,comment_count,praise_count,collect_count')->where(['article_id' => "{$article_id}"])->select();
    }

    public function personal($username)
    {
        return $this->table('article')->field('title,content,username,created_at,category,comment_count,praise_count,collect_count')->where(['username'=>"{$username}"])->selectAll();
    }

    public function manage($username)
    {
        return $this->table('article')->field('article,title,status,created_at,updated_at,category,comment_count,praise_count,collect_count,share_count')->where(['username' => "{$username}"])->order('article')->selectAll();
    }

    public function delArticle($article)
    {
        return $this->table('article')->where(['article'=>"{$article}"])->delete();
    }
}
