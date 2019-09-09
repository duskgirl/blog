<?php
// function a(){
//   echo b(13,14);
// }
// function b($x,$y) {
//   return $x+$y;
// }
// $res = a();
// var_dump($res);
require_once './config.php';

$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if(!$connect){
  exit('数据库连接失败!');
}
mysqli_set_charset($connect,'utf8');
$reset_password_sql = "select modified_time from adminuser where id=3 limit 1";
$reset_password_query = mysqli_query($connect,$reset_password_sql);

// 如何将年月日时分秒的时间字符串转换为时间戳的int
$time1 = mysqli_fetch_array($reset_password_query)['modified_time'];

$time1 = strtotime($time1);
var_dump($time1);

$time2 = time();
// time()获取到的是一个时分秒的数字
var_dump(($time2 - $time1)/60/60);

date_default_timezone_set('PRC');
$lasttime = date('Y-m-d H:i:s');

var_dump($lasttime);

$a = unix_timestamp();
var_dump($a);
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
  <a href="https://www.baidu.com/"></a>
</body>
</html>