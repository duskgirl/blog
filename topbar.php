<!-- 顶部通栏 -->
<!-- 只预留一个位置登陆就行了，登陆页面直接可以跳转到注册页面 登陆后直接显示个人头像，点击个人头像可以到达个人中心 -->
<!-- 到时候个人中心页面直接未设置个人头像，就用默认头像，如果设置了个人头像就用用户设置的头像 -->
<!-- 左边网站logo 右边网站导航 （前端开发 前端开发 前端开发 前端开发 这属于分类） -->
<!-- 干脆所有导航做成一排，logo和登陆页面做在一行 -->
<?php 
require_once './functions.php';
$user = blog_get_current_user();
if(!empty($user['id'])){
  $user_id = $user['id'];
  $sql = "select count(id) as unread_num from message where receive_id = {$user_id} && read_status = 1";
  $unread_num_result = blog_select_one($sql);
  $unread_num = $unread_num_result['unread_num'];
}
?>
<div class="blog_topbar">
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <!-- 导航栏 -->
      <!-- 导航栏永远做一个侧边折叠效果 -->
      <div class="blog_nav">
        <a href="javascript:;" class="nav_toggle"><span class="fa fa-bars"></span></a>
        <ul class="blog_nav_content">
          <p class="back"><a href="javascript:;" class="blog_nav_close"><span class="fa fa-window-close"></span></a></p>
          <h3>大思考</h3>
          <li><a href="/blog/index.php"><span class="fa fa-home"></span>首页</a></li>
          <li><a href="#">前端开发</a></li>
          <li><a href="#">其它</a></li>
        </ul>
      </div>
      <div class="person_center">
        <!-- 没有登陆之前显示注册，登录 -->
        <?php if(empty($user)):?>
        <div class="no_login">
          <a href="/blog/user/register.php" class="btn btn-default navbar-btn">注册</a>
          <a href="/blog/user/login.php" class="btn btn-default navbar-btn">登录</a>
        </div>
        <?php else:?>
        <!-- 登录之后显示用户头像 -->
        <div class="is_login">
          <a href="javascript:;" class="menu_toggle<?php echo !empty($unread_num) &&  $unread_num > 0 ? ' red_point' : '' ?>"><img src="<?php echo $user['avatar']?>"></a>
          <ul class="person_menu">
            <!-- 如何在合适的时候产生红点呢？ -->
            <!-- 有新消息还是未读消息? -->
            <!-- 有消息未读的时候就有红点，没有未读的消息的时候就不产生红点 -->


            <!-- 当用户有消息的时候 个人中心后面加一个小红点 -->
            <?php if(!empty($unread_num) &&  $unread_num > 0):?>
            <li class="is_message"><a href="/blog/person_message.php">个人中心</a></li>
            <!-- 当用户没有消息的时候 个人中心后面不加小红点 -->
            <?php else:?>
            <li class="no_message"><a href="/blog/person_message.php">个人中心</a></li>
            <?php endif?>
            <li><a href="/blog/user/login.php?action=logout">退出登陆</a></li>
          </ul>
        </div>
        <?php endif?>
        
      </div>
    </div>
  </nav>
</div>



<script src="/blog/lib/jquery/jquery.min.js"></script>
<script src="/blog/js/topbar.js"></script>