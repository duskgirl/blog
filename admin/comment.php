<?php
require_once 'config.php';
require_once 'functions.php';
blog_get_admin_user();
if($_SERVER['REQUEST_METHOD'] === 'GET') {
  if(!empty($_GET['id'])){
    if(!empty($_GET['approved'])){
      approved_comment();
    } elseif(!empty($_GET['rejected'])){
      rejected_comment();
    } else {
      exit('缺少必要的参数');
    }
  } 
  $search = '';
  $search_value = '';
  // $search => &search='';
  if(!empty($_GET['search'])){
    $search .= '&search='.$_GET['search'];
    $search_value = $_GET['search'];
    $search_value = trim($search_value);
    $search_value_num = mb_strlen($search_value);
    $search_result = '';
    for($i=0;$i<$search_value_num;$i++){
      $search_result .= mb_substr($search_value,$i,1) . '%';
    }
    $search_value = $search_result;
  }
  require_once 'getcommentpage.php';
  getComment();
}
// 分类页面和管理员管理页面都不做分页
function getComment(){
   // 审核通过评论操作
// 审核通过以后，那么审核的批准标注应该没有了
  global $per_list,$skip,$search_value;
  $sql = "select 
  c.id,
  u.name,
  a.id as a_id,
  a.header,
  a.content as path,
  c.content as content,
  c.comment_time,
  c.audit_status 
  from comment as c 
  inner join user as u on c.user_id = u.id 
  inner join article as a on c.article_id = a.id 
  where c.content like '%{$search_value}%'
  order by c.id desc
  limit {$skip},{$per_list}";
  $result = blog_select_all($sql);
  if(!$result) {
    $GLOBALS['err_message'] = '查询数据失败';
  }
  foreach($result as $key => $value){
    if(empty($value['totalRow'])) {
      $GLOBALS['array_result'][] = $value;
    }
  }
  // var_dump($GLOBALS['array_result']);
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
    // 审核时间先观察下会不会自动改变
    // 并且查询他的parent_id如果parent_id为null则不用改变任何
    // 否则则将他的parent_id的数量增加
    $sql = "update comment set audit_status=1 where id = {$id}";
    $result = blog_update($sql);
    if(!$result){
      $GLOBALS['err_message'] = '审核批准失败，请稍后重试';
      return;
    }
    // 审核的通过第一步成功
    // 审核的通过第二步则需查找parent_id
    $parent_id_sql = "select parent_id from comment where id={$id}";
    // var_dump($parent_id_sql);
    $parent_id_row = blog_select_one($parent_id_sql);
    // var_dump($parent_id_row);
    // parent_id不为null;
    if(!empty($parent_id_row)) {
      if(!empty($parent_id_row['parent_id'])){
        $parent_id = $parent_id_row['parent_id'];
        $parent_sql = "update comment set children_num=children_num+1 where id={$parent_id}";
        $parent = blog_update($parent_sql);
        // var_dump($parent);
        if(!$parent){
          $GLOBALS['err_message'] = '审核批准失败，请稍后重试';
          return;
        }
      }
    }
  }
}

// 审核拒绝,直接删除该条信息
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
    // 直接删除该条评论
    $sql = "delete from comment where id = {$id}";
    $result = blog_update($sql);
    if(!$result){
      $GLOBALS['err_message'] = '审核失败，请稍后重试';
      return;
    }
  }
}

?>

<!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="UTF-8">
  <title>后台管理系统-评论管理</title>
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
    <?php $current_nav='comment';?>
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
            <?php if($total>0):?>
            <?php if(isset($array_result)):?>
            <?php foreach($array_result as $key => $item):?>
            <tr>
              <td class="ellipsis">
                <a href="<?php echo $item['path']?>?id=<?php echo $item['a_id']?>"><?php echo $item['header'] ?></a>
              </td>
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
              <?php endif?>
            </tr>
            <?php endforeach?>
            <?php endif?>
            <?php elseif($total === 0):?>
            <tr class="nofound">
              <td colspan="5">抱歉！没有找到相关评论!</td>
            </tr>
            <?php endif?>
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