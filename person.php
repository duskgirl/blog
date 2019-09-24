
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>大思考个人中心</title>
  <link rel="stylesheet" href="./lib/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="./lib/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="./css/topbar.css">
  <link rel="stylesheet" href="./css/sidebar.css">
  <link rel="stylesheet" href="./css/footer.css">
  <link rel="stylesheet" href="./css/person_nav.css">
  <link rel="stylesheet" href="./css/person.css">
</head>

<body>
  <?php include 'topbar.php'?>
  <!-- 左侧导航包括 -->
    <!-- 我的消息 -->
    <!-- 个人设置（基本资料）  -->


   
    <!-- 网站主体内容 -->
  <!-- 左侧：博客标题、博客发表时间、作者、所属分类，文章主图 -->
  <main class="blog_main container">
    <section class="mainbar">
      <?php include 'person_nav.php'?>
      <div class="person_detail">        
        <!-- 我的评论页面 -->
        <div class="person_comment">
          <h4>我的评论</h4>
          <!-- span里面的内容就是发表的具体评论 -->
          <!-- 一个div为一个评论主体 -->
          <div class="comment_block">
            <p class="comment_content">发表评论：<span>今天天气真好呀!</span></p>
            <p class="comment_link">
              <a href=""><span class="fa fa-link"></span>择偶，是每个年龄段的单身人群都会考虑的问题，和谐的伴侣关系能</a>
            </p>
            <!-- 链接到文章地址 -->
            <!-- 评论如果有回复的话怎么显示 -->
            <!-- 不做分页，直接点击查看更多评论才显示更多信息 -->
            <!-- 我的评论页面，默认显示多少行字，超过了就显示省略号，
            加一个展开的标志，显示完毕后又在显示收起，这个不一定要做
          因为，我本身就进行了字数限制 -->
          <!-- 不做分页，默认显示几条以后就直接显示查看更多评论 -->
          <!-- 这里不做评论那种看的到整个文章的评论 -->
            <p class="comment_interaction">
              <span class="fa fa-thumbs-o-up"></span><span>1</span>
              <span class="fa fa-commenting-o"></span><span>1</span>
              <span class="comment_time">2019.9.16 18:20:32</span>
            </p>
          </div>

          <div class="comment_block">
            <!-- 这里有两种情况，一种是回复别人，另一种是直接对原文进行评论的 -->
            <p class="comment_content">
              回复 <span>江河</span>：<span class="content">江河友晚上好!谢谢美赞，过奖了!</span>
            </p>
            <div class="comment_link">
              <!-- 如果是回复别人，那么这里应该有发起者的原评论 -->
              <p><span>江河：</span>师傅对得精彩!!!赞赞赞!!!</p>
              <a href=""><span class="fa fa-link"></span>择偶，是每个年龄段的单身人群都会考虑的问题，和谐的伴侣关系能</a>
            </div>
            <!-- 链接到文章地址 -->
            <!-- 评论如果有回复的话怎么显示 -->
            <!-- 不做分页，直接点击查看更多评论才显示更多信息 -->
            <!-- 我的评论页面，默认显示多少行字，超过了就显示省略号，
            加一个展开的标志，显示完毕后又在显示收起，这个不一定要做
          因为，我本身就进行了字数限制 -->
          <!-- 不做分页，默认显示几条以后就直接显示查看更多评论 -->
          <!-- 这里不做评论那种看的到整个文章的评论 -->
            <p class="comment_interaction">
              <span class="fa fa-thumbs-o-up"></span><span>1</span>
              <span class="fa fa-commenting-o"></span><span>1</span>
              <span class="comment_time">2019.9.16 18:20:32</span>
            </p>
          </div>

          
          

          <!-- 要不就是没有更多评论，要不就是查看更多评论 -->
          <p class="no_comment">没有更多评论了！</p>
          <a href="javascript:;" class="more_comment">查看更多评论</a>

        </div>
        <!-- 我的消息 -->
        <!-- <div class="person_message"></div> -->
        <!-- 账户设置 -->
        <!-- <div class="person_set">
          <h4>账户设置</h4>
          <form action="">
            <div class="input-group">
              <p>注册邮箱:</p>
              <input type="email" class="form-control">
            </div>
            <div class="input-group">
              <p>用户名:</p>
              <input type="text" class="form-control">
            </div>
            <div class="input-group">
              <p>密码:</p>
              <input type="password" class="form-control">
            </div>
            <div class="input-group">
              <p>用户头像:</p>
              <input type="file">
            </div>
          </form>
        </div> -->
      </div>
 
    </section>
    <!-- 右侧：搜索框 最近发表  -->
    <?php include 'sidebar.php'?>
  </main>
  <?php include 'footer.php'?>
  <script src="./lib/jquery/jquery.min.js"></script>
  <script src="./lib/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>