<?php

namespace app\model;

use core\lib\Model;

class Test extends Model
{
    public function test()
    {
        try {
            // $this->pdo不是返回的对象，而是方法
            $pdo = $this->init();
            $pdo->beginTransaction();
            $pdo->setAttribute(\PDO::ATTR_AUTOCOMMIT, false);
            $a1 = $this->table('user')->insert(['username' => 'shen9']);
            $a2 = $this->table('user')->insert(['username1' => 'shen10']);
            $stmt1 = $pdo->prepare($a1);
            $stmt1->execute();
            $stmt2 = $pdo->prepare($a2);
            $stmt2->execute();
            $pdo->commit();
            return true;
        } catch (\PDOException $e) {
            $pdo->rollBack();
            // return $e->getMessage();
            return false;
        }
        // return $this->table('user')->insert(['username'=> 'shen21','password'=>"vfvsvsvvsv"]);
        return $this->table('user')->where(['username'=>'shen'])->update(['follow_count'=>1]);
    }
}
