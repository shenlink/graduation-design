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

    // 处理删除评论
    public function delComment($article_id, $comment_id)
    {
        $comments = $this->table('comment')->where(['comment_id' => "{$comment_id}"])->delete();
        $articles =  $this->table('article')->where(['article_id' => "{$article_id}"])->update('comment_count = comment_count-1');
        return $comments && $articles;
    }

    // 处理添加评论
    public function addComment($article_id, $author, $title, $content, $username, $comment_at)
    {
        $comments = $this->table('comment')->insert(['article_id' => "{$article_id}", 'author' => "{$author}", 'title' => "{$title}", 'content' => "{$content}", 'username' => "{$username}", 'comment_at' => "{$comment_at}"]);
        $articles =  $this->table('article')->where(['article_id' => "{$article_id}"])->update('comment_count = comment_count+1');
        return $comments && $articles;
    }

    // 处理每篇文章要获取的评论
    public function getArticleComment($article_id)
    {
        return $this->table('comment')->field('comment_id,content,username,comment_at')->where(['article_id' => "{$article_id}"])->order('comment_at desc')->selectAll();
    }

    public function getAllComment($currentPage, $pageSize)
    {
        return $this->table('comment')->field('comment_id,content,username,comment_at')->pages($currentPage, $pageSize);
    }


    public function getComment($username, $currentPage, $pageSize)
    {
        return $this->table('comment')->field('comment_id,content,username,comment_at')->where(['status' => 1, 'username' => "{$username}"])->pages($currentPage, $pageSize);
    }

    public function getManageComment($username, $currentPage, $pageSize)
    {
        return $this->table('comment')->field('comment_id,content,username,comment_at')->where(['status' => 1, 'username' => "{$username}"])->pages($currentPage, $pageSize);
    }

}
