<?php
require_once 'config.php';
require_once 'functions.php';
blog_get_current_user();
// 查询管理员
if($_SERVER['REQUEST_METHOD'] === 'GET'){
  // 审核通过评论操作
  // 审核通过以后，那么审核的批准标注应该没有了
  if(!empty($_GET['id'])){
    if(!empty($_GET['approved'])){
      approved_comment();
    } elseif(!empty($_GET['rejected'])){
      rejected_comment();
    } else {
      exit('缺少必要的参数');
    }
  } 
  // 审核拒绝评论操作
  // if(!empty($_GET['id'])){
  //   delete_comment();
  // }
  // 查询管理员
  $sql = 'select 
  c.id,
  u.name,
  a.id as a_id,
  a.header,
  a.content as path,
  c.content as content,
  c.comment_time,
  c.audit_status from comments as c 
  inner join user as u on c.user_id = u.id 
  inner join article as a on c.article_id = a.id 
  order by c.id desc';
  $result = blog_select_all($sql);
  if(!$result) {
    $GLOBALS['err_message'] = '查询数据失败1';
  }
}
// 审核通过
function approved_comment(){
  if(is_admin()){
    $GLOBALS['err_message']=null;
    if(empty($_GET['id'])){
      exit('缺少必要的参数');
    }
    if($_GET['approved'] != 'yes'){
      exit('参数错误');
    }
    $id = $_GET['id'];
    // 修改评论表里面的audit_status为审核通过为数字1
    $sql = "update comments set audit_status=1 where id = {$id}";
    $result = blog_update($sql);
    if(!$result){
      $GLOBALS['err_message'] = '审核批准失败，请稍后重试';
      return;
    }
  }
}
// 审核拒绝
// 假设拒绝失败，我在操作另外一个的时候，如何能够消除那个错误消息提示
function rejected_comment(){
  if(is_admin()){
    $GLOBALS['err_message']=null;
    if(empty($_GET['id'])){
      exit('缺少必要的参数');
    }
    if($_GET['rejected'] != 'yes'){
      exit('参数错误');
    }
    $id = $_GET['id'];
    // 修改评论表里面的audit_status为审核通过为数字2
    $sql = "update comments set audit_status=2 where id = {$id}";
    $result = blog_update($sql);
    if(!$result){
      $GLOBALS['err_message'] = '审核拒绝失败，请稍后重试';
      return;
    }
  }
}
// function delete_comment(){
//   // 删除管理员
//   // 先要获取是否是管理员权限
//   if(is_admin()){
//     if(empty($_GET['id'])){
//       exit('请传入必要的参数');
//     }
//     $id = $_GET['id'];
//     $sql = "delete from user where id={$id}";
//     $result = blog_update($sql);
//     if($result){
//       $GLOBALS['success_message'] = '删除用户成功';
//       header('Location:'.$_SERVER['HTTP_REFERER']);
//     } else {
//       $GLOBALS['err_message'] = '删除用户失败，请稍后重试';
//    }
//   }
// }

?>

<!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="UTF-8">
  <title>后台管理系统-文章管理</title>
  <link rel="stylesheet" href="./lib/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="./lib/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="./css/topbar.css">
  <link rel="stylesheet" href="./css/sidebar.css">
  <link rel="stylesheet" href="./css/pagination.css">
  <link rel="stylesheet" href="./css/comment.css">
  
</head>

<body>
  <!-- 顶部通栏 bolg的logo+后台管理系统左侧 右侧搜索框倒三角符号显示登陆者账户名以及退出 -->
  <div class="container-fluid">
    <?php include './topbar.php'?>
    <div class="blog_admin_main">
      <?php include './sidebar.php'?>
    <section class="blog_admin_center">
      <ol class="breadcrumb">
        <li><a href="/blog/admin/index.php">首页</a></li>
        <li class="active"><a href="/blog/admin/comment.php">评论管理</a></li>
      </ol>
      <?php if(isset($err_message)): ?>
      <div class="alert alert-danger prompt_message  alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>错误!</strong><?php echo $err_message?>
      </div>
      <?php endif ?>
      <?php if(isset($success_message)): ?>
    <div class="alert alert-success prompt_message  alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>成功!</strong><?php echo $success_message?>
    </div>
    <?php endif ?>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th>文章名称</th>
            <th>评论者</th>
            <th>评论内容</th>
            <th>评论时间</th>
            <th>审核</th>
          </tr>
          <!-- 目前就设置两种权限，一种是全权限，另一种是只有进入浏览的权限 -->
          <tbody>
            <?php if(isset($array)):?>
            <?php foreach($array as $key => $item):?>
            <tr>
              <td class="ellipsis"><a href="<?php echo $item['path']?>?id=<?php echo $item['a_id']?>"><?php echo $item['header'] ?></a></td>
              <td><?php echo $item['name']?></td>
              <td><?php echo $item['content']?></td>
              <td><?php echo $item['comment_time']?></td>
              <?php if($item['audit_status'] == 0):?>
              <td>
                <a href="?id=<?php echo $item['id']?>&approved=yes" class="btn">批准</a>
                <a href="?id=<?php echo $item['id']?>&rejected=yes" class="btn">拒绝</a>
              </td>
              <?php elseif($item['audit_status'] == 1):?>
              <td class="<?php echo 'approved'?>">审核通过</td>
              <?php elseif($item['audit_status'] == 2):?>
              <td class="<?php echo 'rejected'?>">审核拒绝</td>
              <?php endif?>
            </tr>
            <?php endforeach?>
            <?php endif?>


            
            
            
            <tr class="nofound">
              <td colspan="5">抱歉！没有找到相关评论!</td>
            </tr>
          </tbody>
        </thead>
      </table>
      <?php include './pagination.php'?>
    </section>
    </div>
  </div>

  <script src="./lib/jquery/jquery.min.js"></script>
  <script src="./lib/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>