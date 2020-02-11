<?php

require 'Db.php';
header("Content-type:text/html;charset=utf-8");

$username = $_POST['usernameValue'];

$db = new Db();
$res =  $db->table('user')->where(array('username'=>'{$username}'))->select();
if(true){
    echo "0";
}else{
    echo "1";
}
