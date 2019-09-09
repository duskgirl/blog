<?php
require_once './config.php';
require_once './functions.php';
blog_get_current_user();
if($_SERVER['REQUEST_METHOD'] === 'GET') {
  total();
}

function total(){
  $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  if(!$connect) {
    exit('连接数据库失败');
  }
  mysqli_set_charset($connect,'utf8');
  $sql_article = "select count('total') as total from article";
  $query_article = mysqli_query($connect,$sql_article);
  if(!$query_article) {
    exit('查询文章数据失败');
  }
  $GLOBALS['total_article'] = mysqli_fetch_array($query_article);

  // 获取分类
  $sql_category = "select count('total') as total from category";
  $query_category = mysqli_query($connect,$sql_category);
  if(!$query_category) {
    exit('查询分类数据失败');
  }
  $GLOBALS['total_category'] = mysqli_fetch_array($query_category);
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
  <link rel="stylesheet" href="./css/index.css">
</head>

<body>
  <!-- 顶部通栏 bolg的logo+后台管理系统左侧 右侧搜索框倒三角符号显示登陆者账户名以及退出 -->
  <div class="container-fluid">
    <?php include './topbar.php'?>
    <div class="blog_admin_main">
      <!-- 以下是左边侧栏 -->
      <?php include './sidebar.php'?>
      <section class="blog_admin_center">
        <h3>站点内容统计</h3>
        <ul class="clearfix">
          <li class="pull-left"><a href="/blog/admin/article.mana.php">总共文章 <span><?php echo $total_article['total']?></span> 篇</a></li>
          <li class="pull-left"><a href="/blog/admin/category.php">总共 <span><?php echo $total_category['total']?></span> 个分类</a></li>
          <li class="pull-left"><a href="#">总共 <span>0</span> 个评论待审核</a></li>
        </ul>
      </section>
    </div>
  </div>
  <script src="./lib/jquery/jquery.min.js"></script>
  <script src="./lib/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>