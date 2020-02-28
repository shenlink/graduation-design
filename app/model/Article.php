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

    // 处理搜索
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

    // 获取某一篇文章的数据
    public function getArticle($article_id)
    {
        return $this->table('article')->field('article_id,title,content,author,created_at,category,comment_count,praise_count,collect_count')->where(['article_id' => "{$article_id}"])->select();
    }

    // 获取个人页面的文章数据
    public function personal($author)
    {
        return $this->table('article')->field('article_id,title,content,author,created_at,category,comment_count,praise_count,collect_count')->where(['author'=>"{$author}"])->selectAll();
    }

    // 获取用户管理页面的文章数据
    public function manage($username)
    {
        return $this->table('article')->field('article_id,title,status,created_at,updated_at,category,comment_count,praise_count,collect_count,share_count')->where(['author' => "{$username}"])->order('article_id')->selectAll();
    }

    // 处理用户编辑文章页面传来的数据
    public function editArticle($article_id,$title,$content)
    {
        return $this->table('article')->where(['article_id' => "{$article_id}"])->update(['article_id' => "{$article_id}",'title'=>"{$title}",'content'=>"{$content}"]);
    }

    // 处理删除文章
    public function delArticle($article_id)
    {
        return $this->table('article')->where(['article_id'=>"{$article_id}"])->delete();
    }

    // 获取所有被管理员推荐的文章
    public function recommend()
    {
        return $this->table('article')->field('article_id,title')->where(['recommend'=>1])->order('article_id')->selectAll();
    }
}
