<?php

namespace app\model;

use core\lib\Model;

class Comment extends Model
{

    private static $comment;
    public static function getInstance()
    {
        if (self::$comment) {
            return self::$comment;
        } else {
            self::$comment = new self();
            return self::$comment;
        }
    }

    // 获取所有用户的文章的评论数据
    public function manage($username)
    {
        return $this->table('comment')->field('comment_id,content,created_at,article_id,username')->where(['username' => "{$username}"])->selectAll();
    }

    // 处理删除评论
    public function delComment($comment_id, $article_id)
    {
        $comment = $this->table('comment')->where(['comment_id'=>"{$comment_id}"])->delete();
        $article =  $this->table('article')->field('comment_ount')->where(['article_id' => "{$article_id}"])->update('comment_ount = comment_ount-1');
        return $comment && $article;
    }

    // 处理添加评论
    public function addComment($content, $username, $article_id, $title, $author, $comment_at)
    {
        $comment = $this->table('comment')->insert(['content'=>"{$content}",'username'=>"{$username}",'article_id'=>"{$article_id}", 'title'=>"{$title}", 'author' => "{$author}", 'comment_at' => "{$comment_at}"]);
        $article =  $this->table('article')->field('comment_ount')->where(['article_id' => "{$article_id}"])->update('comment_ount = comment_ount+1');
        return $comment && $article;
    }

    // 处理每篇文章要获取的评论
    public function getArticleComment($article_id)
    {
        return $this->table('comment')->field('comment_id,content,username,comment_at')->where(['article_id'=>"{$article_id}"])->order('comment_at desc')->selectAll();
    }

    public function getComment($username)
    {
        return $this->table('comment')->field('comment_id,content,article_id,title,author,username,comment_at')->where(['username' => "{$username}"])->order('comment_at desc')->selectAll();
    }

    // 查询comment表中的数据
    public function getAllComment()
    {
        return $this->table('comment')->field('comment_id,content,status,comment_at,article_id,username')->selectAll();
    }
}