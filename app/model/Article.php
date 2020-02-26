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

    public function php()
    {
        return $this->table('article')->field('article_id,title,content,created_at,collect_count,comment_count')->where(['category' => 'php'])->selectAll();
    }

    public function mysql()
    {
        return $this->table('article')->field('article_id,title,content,created_at,collect_count,comment_count')->where(['category' => 'mysql'])->selectAll();
    }

    public function javaScript()
    {
        return $this->table('article')->field('article_id,title,content,created_at,collect_count,comment_count')->where(['category' => 'javaScript'])->selectAll();
    }

    public function getArticle($article_id)
    {
        return $this->table('article')->field('article_id,title,content,author,created_at,category,comment_count,praise_count,collect_count')->where(['article_id' => "{$article_id}"])->select();
    }

    public function personal($author)
    {
        return $this->table('article')->field('title,content,author,created_at,category,comment_count,praise_count,collect_count')->where(['author'=>"{$author}"])->selectAll();
    }

    public function manage($username)
    {
        return $this->table('article')->field('article_id,title,status,created_at,updated_at,category,comment_count,praise_count,collect_count,share_count')->where(['author' => "{$username}"])->order('article_id')->selectAll();
    }

    public function editArticle($article_id,$title,$content)
    {
        return $this->table('article')->where(['article_id' => "{$article_id}"])->update(['article_id' => "{$article_id}",'title'=>"{$title}",'content'=>"{$content}"]);
    }

    public function delArticle($article_id)
    {
        return $this->table('article')->where(['article_id'=>"{$article_id}"])->delete();
    }

    public function recommend()
    {
        return $this->table('article')->field('article_id,title')->where(['recommend'=>1])->order('article_id')->selectAll();
    }
}
