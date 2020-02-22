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

    public function html()
    {
        return $this->table('article')->field('title,content,created_at,collect_count,comment_count')->where(['category' => 'html'])->selectAll();
    }

    public function python()
    {
        return $this->table('article')->field('title,content,created_at,collect_count,comment_count')->where(['category' => 'python'])->selectAll();
    }

    public function java()
    {
        return $this->table('article')->field('title,content,created_at,collect_count,comment_count')->where(['category' => 'java'])->selectAll();
    }

    public function foundation()
    {
        return $this->table('article')->field('title,content,created_at,collect_count,comment_count')->where(['category' => 'foundation'])->selectAll();
    }

    public function getArticle($article)
    {
        return $this->table('article')->field('title,content,username,created_at,category,comment_count,praise_count,collect_count')->where(['article' => "{$article}"])->select();
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
