<?php
  require_once './config.php';
  require_once './functions.php';
  blog_get_admin_user();
  $current_nav = isset($current_nav) ? $current_nav : '';
  var_dump($current_nav);
?>
<!-- 以下是左边侧栏 -->
  <aside class="blog_admin_sidebar">
    <ul>
      <li class="person">
        <img src="./images/default.png" alt="">
        <span><?php echo $_SESSION['admin_login_user']['name']?></span>
      </li>
      <!-- 如何保证点击谁让的class='active' -->
      <li <?php echo $current_nav == 'index' ? 'class="active"':''?>><a href="/blog/admin/index.php">首页</a></li>
      <li <?php echo $current_nav == 'category' ? 'class="active"':''?>><a href="/blog/admin/category.php">分类管理</a></li>
      <li <?php echo $current_nav == 'article' ? 'class="active"':''?>><a href="/blog/admin/article.mana.php">文章管理</a></li>
      <li <?php echo $current_nav == 'admin' ? 'class="active"':''?>><a href="/blog/admin/administrator.php">管理员管理</a></li>
      <li <?php echo $current_nav == 'user' ? 'class="active"':''?>><a href="/blog/admin/user.php">用户管理</a></li>
      <li <?php echo $current_nav == 'comment' ? 'class="active"':''?>><a href="/blog/admin/comment.php">评论管理</a></li>
    </ul>
  </aside>