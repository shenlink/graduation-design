<?php

require 'Db.php';
header("Content-type:text/html;charset=utf-8");

$username = $_POST['username'];
$password = $_POST['password'];
echo "$username" . "$password";
// select * from users where username = $username;
// $db = new Db();
// $res =  $db->table('users')->where(array('username'=>'{$username}'));
// if($res == 1){
//     echo "1";
// }else{
//     echo "0";
// }
