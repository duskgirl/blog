<?php
require_once 'config.php';
require_once 'functions.php';
blog_get_current_user();
// 查询管理员
if($_SERVER['REQUEST_METHOD'] === 'GET'){
  // 删除操作
  if(!empty($_GET['id'])){
    delete_user();
  }
  // 查询管理员
  $sql = 'select id,name,email,avatar,userstats from user order by id desc';
  $result = blog_select_all($sql);
  if(!$result) {
    $GLOBALS['err_message'] = '查询数据失败';
    return;
  }
}
function delete_user(){
  // 删除管理员
  // 先要获取是否是管理员权限
  if(is_admin()){
    if(empty($_GET['id'])){
      exit('请传入必要的参数');
    }
    $id = $_GET['id'];
    $sql = "delete from user where id={$id}";
    $result = blog_update($sql);
    if($result){
      $GLOBALS['success_message'] = '删除用户成功';
      header('Location:'.$_SERVER['HTTP_REFERER']);
    } else {
      $GLOBALS['err_message'] = '删除用户失败，请稍后重试';
    }
  }
}

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
  <link rel="stylesheet" href="./css/user.css">
  
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
        <li class="active"><a href="/blog/admin/user.php">用户管理</a></li>
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
            <th>用户名</th>
            <th>邮箱</th>
            <th>头像</th>
            <th>状态</th>
            <th>操作</th>
          </tr>
          <!-- 目前就设置两种权限，一种是全权限，另一种是只有进入浏览的权限 -->
          <tbody>
            <?php if(isset($array)):?>
            <?php foreach($array as $key => $item):?>
            <tr>
              <td><?php echo $item['name']?></td>
              <td><?php echo $item['email']?></td>
              <td><img src="<?php echo $item['avatar']?>"></td>
              <td>
              <?php if($item['userstats'] !=1):?>
              <?php echo '未激活'?>
              <?php else:?>
              <?php echo '已激活'?>
              <?php endif?>
              </td>
              <td>
                <a href="?id=<?php echo $item['id']?>" class="btn">删除</a>
              </td>
            </tr>
            <?php endforeach?>
            <?php endif?>
      
            
            <tr class="nofound">
              <td colspan="5">抱歉！没有找到该用户!</td>
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