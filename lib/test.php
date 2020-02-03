<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/lib/Db.php';

$db = new Db();
//$res = $db->table('article')->where(array('id'=>17,'title'=>'abcd'))->item();
//$res = $db->table('article')->field('title,id')->order('id desc')->where('id>1')->limit(5)->lists();

/*$data = ['uid'=>2,'cid'=>3,'title'=>'数据库添加22','pv'=>0];
$id = $db->table('article')->insert($data);
echo '<pre>';
var_dump($id);
*/

//$res = $db->table('article')->where(array('id'=>22))->delete();
/*$data = ['title'=>'数据库更新','pv'=>34];
$res = $db->table('article')->where(array('id'=>21))->update($data);
var_dump($res);
"delete from article where id=24";
"insert into article(uid,cid,title,pv)values(2,3,'数据库添加',8)";
"update article set title='数据库更新' where id=21";
*/
// 查询：select
// 添加：insert
// 修改：update
// 删除：delete
// 

// 分页查询
//$cid = $_GET['cid'];	// 分类id
$page = $_GET['page'];	// 第几页
$pageSize = 2;			// 每页加载多少条数据

$res = $db->table('article')->field('id,title')->where('id>2')->pages($page,$pageSize,'/test.php');


function input($param){
	if(!isset($_POST[$param])){
		return false;
	}
	$value = $_POST[$param];
	// 做安全处理
	$value = htmlspecialchars($value);
	return $value;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>分页</title>
	<link rel="stylesheet" type="text/css" href="/static/plugins/bootstrap/css/bootstrap.min.css">
</head>
<body>

	<div class="container" style="margin-top: 50px;">
		<p>共查询出<?php echo $res['total']?>条数据</p>
		<table class="table table-bordered">
		 	<thead>
		 		<tr>
		 			<th>ID</th>
		 			<th>标题</th>
		 		</tr>
		 	</thead>
		 	<tbody>
		 		<?php foreach($res['data'] as $article){?>
		 		<tr>
		 			<td><?php echo $article['id']?></td>
		 			<td><?php echo $article['title']?></td>
		 		</tr>
		 		<?php }?>
		 	</tbody>
		</table>
		
		<!--分页-->

		<div>
			<?php echo $res['pages']?>
		</div>
	</div>
</body>
</html>