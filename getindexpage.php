<?php
  require_once './config.php';
  // 获取分页数据
  // 内容总条数
  $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  mysqli_set_charset($connect,'utf8');
  if(!$connect) {
    exit('连接数据库失败');
  }
  $total_sql = "select count('total') as total from article as a inner join category as c on a.category_id = c.id where {$where}";

  $total_query = mysqli_query($connect,$total_sql);
  if(!$total_query) {
    exit('分页查询失败');
  }
  // 获取到了总条数
  $total = mysqli_fetch_array($total_query)['total'];
  // 获取到页码
  $page = empty($_GET['page']) ? 1: (int)$_GET['page'];
  if($page<1){
    header('Location:/blog/index.php?page=1');
  }
  // 每页显示的条数
  $every = 3;
  // 每一页跨过多少行查阅数据；
  $skip = $every * ($page - 1);
  // 总页码
  $total_page = (int)ceil($total/$every);
  // var_dump($total);
  if($page>$total_page && $total_page>0){
    header("Location:/blog/index.php?page={$total_page}");
  }
  
  // 设置显示可见页码数量
  $visible = 3;
  // 设置页码变化区间
  $region = ($visible-1)/2;
  // 设置开始页码和结束页码的值
  $begin = $page - $region;
  $end = $begin + $visible - 1;

  // 设置页码特殊情况
  if($begin<1) {
    $begin = 1;
    $end = $begin + $visible - 1;
  }
  if($end>$total_page) {
    $end = $total_page;
    $begin = $end -$visible + 1;
    if($begin<1) {
      $begin = 1;
    }
  }
  