<?php
namespace app\model;

use core\lib\Model;

class Test extends Model{
    public $id;
    public $user;
    public $sex;
    public function query(){
        return $this->table('test')->where(['id'=>1])->select();

    }
    public function execute(){
        // update,insert,delete
        return $this->table('test')->where(['id'=>2])->update(['sex'=>0]);
    }
}