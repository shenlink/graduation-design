<?php

require_once 'Db.php';
$sql = new Db();
// $res = $db->table('article')->where(array('id'=>17,'title'=>'abcd'))->select();
$res = $db->table('article')->where(array('ad'=>1,'title'=>'php'))->select();
var_dump($res);

