<?php
require_once './config.php';
require_once './functions.php';
blog_get_current_user();
// 执行添加分类操作
if($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['name'])) {
  addCategory();
}
function addCategory(){
  if(empty($_GET['name'])){
    exit('请传入必要的参数');
  }
  $name = $_GET['name'];
  // 连接数据库
  $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  if(!$connect) {
    exit('数据库连接失败');
  }
  mysqli_set_charset($connect,'utf8');
  $sql = "insert into category (name) values ('{$name}')";
  $query = mysqli_query($connect,$sql);
  if(!$query){
    exit('添加分类失败');
  }
  if(mysqli_affected_rows($connect)<=0){
    $GLOBALS['err_message'] = '添加分类失败';
  };
  $GLOBALS['success_message'] = '添加分类成功';
  header('Location: ' . $_SERVER['HTTP_REFERER']);
}
// 执行文章删除分类操作
if($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['id'])){
  deleteCategory();
}
function deleteCategory(){
  if(empty($_GET['id'])){
    exit('请传入必要的参数');
  }
  $id = $_GET['id'];
  // 连接数据库
  $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  if(!$connect) {
    exit('数据库连接失败');
  }
  mysqli_set_charset($connect,'utf8');
  mysqli_query($connect,"SET foreign_key_checks = 0");
  $sql = "delete from category where id = {$id}";
  $query = mysqli_query($connect,$sql);
  if(!$query){
    exit('删除分类失败');
  }
  if(mysqli_affected_rows($connect)<=0){
    $GLOBALS['delete_err_message'] = '删除分类失败';
  };
  $GLOBALS['delete_success_message'] = '删除分类成功';
  mysqli_query($connect,"SET foreign_key_checks = 1");
  header('Location: ' . $_SERVER['HTTP_REFERER']);
}

// 执行文章页面渲染操作
// 完成这样一个逻辑：在当前页面删除的信息，删除后也该回到当前页面，而不是首页；
// $search应该包含：页码以及id?
// $search => ? $id = ? & $page = ?;
if($_SERVER['REQUEST_METHOD'] === 'GET') {
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
  require_once './getcategorypage.php';
  getCategory();
}
function getCategory(){
  global $skip,$per_list,$search_value;  
  // 连接数据库
  $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  if(!$connect) {
    exit('数据库连接失败');
  }
  mysqli_set_charset($connect,'utf8');
  $sql = "select id,name from category where name like '%{$search_value}%' order by id desc limit {$skip},{$per_list}";
  $query = mysqli_query($connect,$sql);
  if(!$query){
    exit('查询分类失败');
  }
  while($row=mysqli_fetch_array($query)){
    $GLOBALS['getCategory'][] = $row;
  }
}
?>

<!DOCTYPE html>
<html>

<head lang="en">
  <meta charset="UTF-8">
  <title>后台管理系统-首页</title>
  <link rel="stylesheet" href="./lib/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="./lib/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="./css/topbar.css">
  <link rel="stylesheet" href="./css/sidebar.css">
  <link rel="stylesheet" href="./css/category.css">
  <link rel="stylesheet" href="./css/pagination.css">
</head>

<body>
  <!-- 顶部通栏 bolg的logo+后台管理系统左侧 右侧搜索框倒三角符号显示登陆者账户名以及退出 -->
  <div class="container-fluid">
    <?php include './topbar.php'?>
    <div class="blog_admin_main">
      <!-- 以下是左边侧栏 -->
      <?php include './sidebar.php'?>
        <section class="blog_admin_center">
          <form action="<?php echo $_SERVER['PHP_SELF']?>" method="get" class="add_category">
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
            <h3>添加文章分类</h3>
            <div class="input-group">
              <span class="input-group-addon">分类名称</span>
              <input type="text" class="form-control" name="name" placeholder="请输入文章分类名称">
              <span class="input-group-btn">
                <input class="btn btn-default" type="submit" value="添加分类">
              </span>
            </div>
          </form>
          <?php if(isset($delete_err_message)): ?>
            <div class="alert alert-danger prompt_message  alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>错误!</strong><?php echo $delete_err_message?>
            </div>
            <?php endif ?>
            <?php if(isset($delete_success_message)): ?>
            <div class="alert alert-success prompt_message  alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>成功!</strong><?php echo $delete_success_message?>
            </div>
          <?php endif ?>
          <h3>分类详情</h3>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th>分类名称</th>
                <th>操作</th>
              </tr>
              <tbody>
                <?php if($total === 0): ?>
                  <tr class="nofound">
                    <td colspan="2">抱歉！没有找到相关分类!</td>
                  </tr>
                <?php endif ?>
                <?php if(isset($getCategory)):?>
                <?php foreach($getCategory as $key => $item):?>
                <tr>
                  <td><?php echo $item['name']?></td>
                  <td><a href="?id=<?php echo $item['id']?>" class="btn">删除</a>
                 </td>
                </tr>
                <?php endforeach?>
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