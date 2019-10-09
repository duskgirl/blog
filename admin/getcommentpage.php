<?php
require_once './config.php';
require_once './functions.php';
$sql = "select count('total') as totalRow from comment where content like '%{$search_value}%'";
$total_row = blog_select_all($sql);
if(!empty($total_row)){
  // 数据总条数
  $total = (int)$total_row[0]['totalRow'];
  // 每页显示的条数
  $per_list = 4;
  // 总页数
  $total_page = (int)ceil($total/$per_list);
  
  // 当前默认为第一页
  $current_page = empty($_GET['page']) ? 1: (int)$_GET['page'];
  if($current_page>$total_page && $total_page>0){
    header("location:/blog/admin/comment.php?page={$total_page}");
  }
  if($current_page<1){
    header('location:/blog/admin/comment.php');
  }
  // 跳过多少行；
  $skip = ($current_page-1)*$per_list;
  // 默认显示第一页;
  // 点击下一页的时候怎么查询；
  // 点击上一页的时候怎么查询;
  // 还应该设置一个变量为显示的页码个数
  
  // 可见的页码个数
  $visible_page = 5;
  // 当前页码左右可见的页码；
  $visible_var =  ($visible_page-1)/2;
  // 开始页码
  $begin = $current_page - $visible_var;
  // 结束页码
  $end = $begin + $visible_page-1;
  
  // 可能出现$begin和$end不合理情况
  if($begin<1){
    $begin = 1;
    $end = $begin + $visible_page-1;
  }
  if($end > $total_page){
    $end = $total_page;
    $begin = $end - $visible_page+1;
    if($begin <1 ){
      $begin = 1;
    }
  }
}
  
  