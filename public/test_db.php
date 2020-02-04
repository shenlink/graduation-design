<<<<<<< HEAD
<?php

require_once 'Db.php';
$sql = new Db();
// $res = $db->table('article')->where(array('id'=>17,'title'=>'abcd'))->select();
$res = $db->table('article')->where(array('ad'=>1,'title'=>'php'))->select();
var_dump($res);
=======
<php
require_once("Db.class.php");
$sql = new Db();
var_dump($db);
>>>>>>> cb2f954ba7a4ba5987403034e54668adad333006
