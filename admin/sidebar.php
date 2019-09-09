<?php
  require_once './config.php';
  require_once './functions.php';
  blog_get_current_user();
  $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  if(!$connect) {
    exit('连接数据库失败');
  }
  mysqli_set_charset($connect,'utf8');
  $sql = 'select id,name from category';
  $query = mysqli_query($connect,$sql);
  if(!$query) {
    exit('查询分类数据失败');
  }
  while($row = mysqli_fetch_array($query)){
    $GLOBALS['category_array'][] = $row;
  }
?>
<!-- 以下是左边侧栏 -->
  <aside class="blog_admin_sidebar">
    <ul>
      <li class="person">
        <img src="./images/default.png" alt="">
        <span><?php echo $_SESSION['current_login_user']['name']?></span>
      </li>
      <li class="active"><a href="/blog/admin/index.php">首页</a></li>
      <li><a href="/blog/admin/category.php">分类管理</a></li>
      <li><a href="/blog/admin/article.mana.php">文章管理</a></li>
      <li><a href="#">管理员管理</a></li>
      <li><a href="#">用户管理</a></li>
      <li><a href="#">评论管理</a></li>
      <li><a href="#">标签管理</a></li>
      <li><a href="#">友情链接管理</a></li>
    </ul>
  </aside>