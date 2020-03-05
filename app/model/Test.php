<?php

namespace app\model;

use core\lib\Model;

class Test extends Model
{
    public function test()
    {
        // $article_count = $this->table('user')->field('article_count')->where(['username' => 'shen'])->select();
        // $article_count = $article_count['article_count'] + 1;
        // try {
        //     $pdo = $this->init();
        //     $pdo->beginTransaction();
        //     // $user1 = $this->table('user')->where(['user_id' => 3])->fixSql('update', ['username' => 'shen']);
        //     $user1 = "update user set username = ? where user_id = ?";
        //     $user2 = "update user set username = ? where user_id = ?";
        //     $username1 = 'shen';
        //     $user_id1 = 1;
        //     $username2 = 'shen22';
        //     $user_id2 = 20;
        //     $stmt = $pdo->prepare($user1);
        //     $stmt->bindValue(1, $username1);
        //     $stmt->bindValue(2, $user_id1);
        //     $s1 = $stmt->execute();
        //     $stmt = $pdo->prepare($user2);
        //     $stmt->bindValue(1, $username2);
        //     $stmt->bindValue(2, $user_id2);
        //     $s2 = $stmt->execute();
        //     $pdo->commit();
        //     return $s1 && $s2;
        // } catch (\PDOException $e) {
        //     $pdo->rollBack();
        //     return $e->getMessage();
        // }
        // // $pdo = $this->init();
        // // // $pdo->beginTransaction();
        // // $user1 = $this->table('user')->where(['user_id' => 3])->fixSql('update', ['username' => 'shen']);
        // // // $user2 = $this->table('user')->where(['user_id' => 2])->fixSql('update', ['username' => 'shen22']);
        // // // $user3 = $this->table('user')->where(['user_id' => 3])->fixSql('update', ['article_count' => "{$article_count}"]);
        // // // $values = $this->fixPrepareValue(['username' => 'shen']);
        // // // $wheres = $this->fixPrepareWhere(['user_id' => 10]);
        // // // $allParams = array_merge($values, $wheres);
        // // $stmt = $pdo->prepare($user1);
        // // $stmt->bindValue('shen',1);
        // // $s1 = $stmt->execute();
        // // return $s1;
        // // // return $allParams;
        // return $this->table('article')->field('article_id,title,content,created_at,collect_count,comment_count,status')->selectAll();
        return $this->table('article')->field('article_id,title,content,created_at,collect_count,comment_count')->pages(1, 5);
    }
}
