<?php
require_once './functions.php';
$user = blog_get_current_user();
?>
<div class="person_nav">
  <div class="header hidden-xs">
    <img src="<?php echo $user['avatar']?>" alt="" class="avatar">
    <h3 class="underline"><?php echo $user['name']?></h3>
  </div>
  <!-- 如何保证在大屏设备时是竖着的导航，小屏设备是横着的导航 -->
  <ul>
    <li class="person_nav_item active"><a href="/blog/person.php"><span class="fa fa-comment-o"></span> 我的评论</a></li>
    <li class="person_nav_item"><a href="/blog/person_message.php"><span class="fa fa-bell-o"></span> 我的消息</a></li>
    <li class="person_nav_item"><a href="/blog/person_set.php"><span class="fa fa-cog"></span> 账户设置</a></li>
  </ul>
</div>