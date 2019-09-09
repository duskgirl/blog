<?php
require_once './config.php';
if($_SERVER['REQUEST_METHOD'] === 'GET') {
  getcount();
}
// 当这个函数被调用一次，被查看的次数+1；保存增加的次数
function getArticle(){
// 连接数据库
$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if(!$connect) {
  exit('数据库连接失败');
}
$sql = 'select id,header,count from test where id=1';
$query = mysqli_query($connect,$sql);
if(!$query) {
  exit('查询数据失败');
}
$GLOBALS['row'] = mysqli_fetch_array($query);
}
function getcount(){
// 获取最初被查看的次数
  $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  if(!$connect) {
    exit('数据库连接失败');
  }
  $sql = 'select count from test where id=1';
  $query = mysqli_query($connect,$sql);
  if(!$query) {
    exit('查询数据失败');
  }
  $count = mysqli_fetch_array($query)['count'];
  var_dump($count);
  getArticle();
  $count += 1;
  $sql_add = "update test set count = {$count}";
  $query = mysqli_query($connect,$sql_add);
  if(!$query) {
    exit('更新数据失败');
  }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <?php if(isset($row)): ?>
  <h1><?php echo $row['header']?></h1>
  <p>被查看次数<span><?php echo $row['count']?></span>次</p>
  <?php endif ?>
</body>
</html>