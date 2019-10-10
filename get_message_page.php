<?php
  require_once './config.php';
  require_once './functions.php';
  // 获取分页数据
  // 内容总条数
  $total_sql = "select 
  count('id') as total 
  from message as m 
  inner join user as u on m.send_id = u.id
  where {$where}";
  // 获取到了总条数
  $total = blog_select_one($total_sql)['total'];
  // 获取到页码
  $page = empty($_GET['page']) ? 1: (int)$_GET['page'];
  if($page<1){
    header('Location:/blog/person_message.php?page=1');
  }
  // 每页显示的条数
  $every = 3;
  // 每一页跨过多少行查阅数据；
  $skip = $every * ($page - 1);
  // 总页码
  $total_page = (int)ceil($total/$every);
  // var_dump($total);
  if($page>$total_page && $total_page>0){
    header("Location:/blog/person_message.php?page={$total_page}");
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
  