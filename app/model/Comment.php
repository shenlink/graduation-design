<?php

namespace app\model;

use core\lib\Model;

class Comment extends Model
{
    // 获取所有用户的文章的评论数据
    public function manage($username)
    {
        return $this->table('comment')->field('comment_id,content,created_at,article_id,username')->where(['username' => "{$username}"])->selectAll();
    }

    // 处理删除评论
    public function delComment($comment_id)
    {
        return $this->table('comment')->where(['comment_id'=>"{$comment_id}"])->delete();
    }

    // 处理添加评论
    public function addComment($content, $username, $article_id, $title, $author, $comment_at)
    {
        return $this->table('comment')->insert(['content'=>"{$content}",'username'=>"{$username}",'article_id'=>"{$article_id}", 'title'=>"{$title}", 'author' => "{$author}", 'comment_at' => "{$comment_at}"]);
    }

    // 处理每篇文章要获取的评论
    public function getArticleComment($article_id)
    {
        return $this->table('comment')->field('comment_id,content,username,comment_at')->where(['article_id'=>"{$article_id}"])->order('comment_at desc')->selectAll();
    }

    public function getComment($username)
    {
        return $this->table('comment')->field('comment_id,content,article_id,title,author,username,comment_at')->where(['username' => "{$username}"])->selectAll();
    }

    // 查询comment表中的数据
    public function comment()
    {
        return $this->table('comment')->field('comment_id,content,status,created_at,article_id,username')->selectAll();
    }
}