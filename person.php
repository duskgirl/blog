<?php
require_once './config.php';
require_once './functions.php';
$user = blog_get_current_user();
if($_SERVER['REQUEST_METHOD'] === 'GET'){
  // 必须先注册登陆才能进去
  if($user !== null){
    $user_id = $user['id'];
  } else {
    $_SESSION['url'] = '/blog/person.php';
    header('Location: /blog/user/login.php');
  }
}
?>

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
  <link rel="stylesheet" href="./css/public.css">
</head>

<body>
  <?php include 'topbar.php'?>
  <main class="blog_main container">
    <section class="mainbar">
      <?php include 'person_nav.php'?>
      <div class="person_detail" id="person">        
        <!-- 我的评论页面 -->
        <div class="person_comment">
          <h4 class="hidden-xs">我的评论</h4>
        </div>
      </div>
 
    </section>
  </main>
  <?php include 'footer.php'?>
  <script src="./lib/jquery/jquery.min.js"></script>
  <script src="./lib/bootstrap/js/bootstrap.min.js"></script>
  <script src="/blog/lib/artDialog-master/dialog.js"></script>
  <script src="/blog/lib/art-template/template-web.js"></script>
  <script type="text/x-art-template" id="default_comment">
  {{if(total_num>0)}}
    {{each data item index}}
    <div class="comment_block">
      {{if(item['parent_id'] == null)}}
      <p class="comment_content">发表评论：<span><{{item['comment_content']}}</span></p>
      <p class="comment_link">
        <a href="{{item['article_path']}}?id={{item['id']}}"><span class="fa fa-link"></span>{{item['header']}}</a>
      </p>
      {{else}}
      <p class="comment_content">
        回复 <span>{{item['parent_name']}}</span>：
        <span class="content">{{item['comment_content']}}</span>
      </p>
      <div class="comment_link">
        <p><span>{{item['parent_name']}}：</span>{{item['parent_content']}}</p>
        <a href="{{item['article_path']}}?id={{item['id']}}"><span class="fa fa-link"></span>{{item['header']}}</a>
      </div>
      {{/if}}
      <p class="comment_interaction">
        <span class="fa fa-thumbs-o-up"></span><span>{{item['love']}}</span>
        <span class="fa fa-commenting-o"></span><span>{{item['children_love']}}</span>
        <span class="comment_time">{{item['comment_time']}}</span>
      </p>
    </div>
    
    {{/each}}
    {{if(total_num>2)}}
    <a href="javascript:;" class="more_comment">查看更多评论</a>
    {{/if}}
    {{else}}
      <p class="no_comment">您当前还未发表过评论！</p>
    {{/if}}
  </script>
  <script type="text/x-art-template" id="look_comment">
  {{if(length>0)}}
    {{each data item index}}
    <div class="comment_block">
      {{if(item['parent_id'] == null)}}
      <p class="comment_content">发表评论：<span><{{item['comment_content']}}</span></p>
      <p class="comment_link">
        <a href="{{item['article_path']}}?id={{item['id']}}"><span class="fa fa-link"></span>{{item['header']}}</a>
      </p>
      {{else}}
      <p class="comment_content">
        回复 <span>{{item['parent_name']}}</span>：
        <span class="content">{{item['comment_content']}}</span>
      </p>
      <div class="comment_link">
        <p><span>{{item['parent_name']}}：</span>{{item['parent_content']}}</p>
        <a href="{{item['article_path']}}?id={{item['id']}}"><span class="fa fa-link"></span>{{item['header']}}</a>
      </div>
      {{/if}}
      <p class="comment_interaction">
        <span class="fa fa-thumbs-o-up"></span><span>{{item['love']}}</span>
        <span class="fa fa-commenting-o"></span><span>{{item['children_love']}}</span>
        <span class="comment_time">{{item['comment_time']}}</span>
      </p>
    </div>
    
    {{/each}}
    {{if(length == 10)}}
    <a href="javascript:;" class="more_comment">查看更多评论</a>
    {{else}}
    <p class="no_comment">没有更多评论了！</p>
    {{/if}}
    {{else}}
      <p class="no_comment">没有更多评论了！</p>
    {{/if}}
  </script>
  <script>
    $(function(){
      var user_id = <?php echo $user_id?>;
      var page = 1;
      $.ajax({
        url: '/blog/person_comment.php',
        data: {
          page: page,
          user_id: user_id,
        },
        dataType: 'json',
        type: 'POST',
        success: function(data){
          if(data.success != true){
            dialog('警告',data.message);
          } else {
            var html = template('default_comment',{
              data: data.message.finish,
              total_num: data.message.person_total
            });
            $('.person_comment').append(html);
          }
          
        }
      })
      $('.person_detail').on('click','.more_comment',function(){
        $(this).hide();
        page++;
        event.preventDefault();
        $.ajax({
          url: '/blog/person_comment.php',
          data: {
            page: page,
            user_id: user_id,
          },
          dataType: 'json',
          type: 'POST',
          success: function(data){
            if(data.success != true){
              dialog('警告',data.message);
            } else {
              var html = template('look_comment',{
                data: data.message.finish,
                length: data.message.finish.length
              });
              $('.person_comment').append(html);
            }
            
          }
        })
      })
      function warn(title,content){
        var d = dialog({
    	    title: title,
          content: content,
          cancel: false,
	        ok: function () {},
          quickClose: true
        });
        d.show(document.getElementById('option-quickClose'));
        setTimeout(function () {
        	d.close().remove();
        }, 5000);
      }
    })
  </script>
</body>

</html>