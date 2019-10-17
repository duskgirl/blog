<?php
$root_path = $_SERVER['DOCUMENT_ROOT'];
require_once($root_path.'/functions.php');
if($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['id'])){
  $id = $_GET['id'];
  // 获取当前页面的url地址存cookie,保证用户登录时还能返回当前页面
  $url = $_SERVER['REQUEST_URI'];
  $_SESSION['url'] = $url;
  $user = blog_get_current_user();
  // 提交评论的时候还需在验证用户是否登陆
  if(empty($user)){
    $user_id = 0;
  } else {
    $user_id = $user['id'];
  }
} 

?>
<div class="comment">
  <h3><span class="fa fa-pencil-square-o"> </span> 发表评论</h3>
  <!-- 未登录时显示的界面 -->
  <!-- 登陆时应该显示用户头像在某个位置 -->
  <!-- texta如何限定字符数,限制100个字符 -->
  <!-- 两种情况，这种是未登陆的 -->
  <?php if(empty($user)):?>
  <!-- 将当前页面的url地址保存cookie,登陆时看cookie是否有这个url的cookie,
  有就跳转到cookie中的url地址,没有就跳转到首页 -->
  <p class="warning">
    <span class="fa fa-exclamation-triangle"></span>
     注册用户登录后才能发表评论，请先
     <a href="/user/login.php">登录</a>
     或
     <a href="/user/register.php">注册</a></p>
  <?php endif?>
  <!-- 登陆以后的话什么都不显示 -->
  <!-- 考虑还是发送ajax请求 -->
  <!-- 弄一个提示框提示用户出现的问题或者是提示成功等 -->
  <!-- 提示问题消息 -->
  <!-- 默认均看不见 -->
  <form>
    <textarea  name="comment" class="form-control form-comment">来说几句吧....</textarea>
    <?php if(empty($user)):?>
    <input type="submit" value="评论" class="btn parent_comment_submit" disabled="disabled" />
    <?php else:?>
    <input type="submit" value="评论" class="btn parent_comment_submit" />
    <?php endif?>
  </form>
  <ul class="media-list comment-detail">
    <h3><span class="fa fa-commenting-o"></span> 最新评论</h3>        
  </ul>
 
</div>
<script src="/lib/jquery/jquery.min.js"></script>
<script src="/lib/artDialog-master/dialog.js"></script>
<script src="/lib/art-template/template-web.js"></script>
<script src="/article/js/comment.js"></script>
<!-- 新建一个评论模板 -->
<!-- 默认$value拿到的是当前被遍历的那个元素 -->
<script type="text/x-art-template" id="comment">
{{if(num>=1)}}
{{each parent item index}}
<li class="media comment-row" id="{{item.id}}" page="1">
  <div class="media-left">
    <img class="media-object avatar" src="{{item.avatar}}" alt="头像">
  </div>
  <div class="media-body comment-column-right">
    <h4 class="media-heading username">{{item.name}}</h4>
    <p class="time"><span class="fa fa-clock-o"> </span> {{item.comment_time}}</p>
    <div class="comment-content">
      <p class="comment-call">{{item.content}}</p>
      <div class="reply">
        {{each children value index}}
        {{if(value.parent_id == item.id)}}
        <div class="reply-block" id="{{value.id}}">
          <p class="reply-content">
            <a href="#" class="reply-user">{{value.name}}</a>: {{value.content}}
          </p>
          <div class="interaction">
            <a href="javascript:;" class="love"><span class="glyphicon glyphicon-fire no_fire"></span> 赞
            {{if(value.love>0)}}
            <span class="love_num">{{value.love}}</span>
            {{else}}
            <span class="love_num"></span>
            {{/if}}
          </a>
           <span class="reply-time"><span class="fa fa-clock-o"><span>  {{value.comment_time}}</span>
          </div>
        </div>
        {{/if}}
        {{/each}}
        {{if(item.children_num>2)}}
        <a href="javascript:;"  class="reply-more">查看全部{{item.children_num}}条回复<span class="fa fa-chevron-right"></span></a>
        {{/if}}
        <div class="comment-more-detail">
          <p class="more-reply">更多回复</p>
        </div>
      </div>
    </div>
    <div class="interaction">
      <a href="javascript:;" class="love"><span class="fa fa-thumbs-o-up  no_fire"></span> 赞
        {{if(item.love>0)}}
          <span class="love_num">{{item.love}}</span>
          {{else}}
          <span class="love_num"></span>
        {{/if}}
      </a>
      <a href="javascript:;" class="reply-switch"><span class="fa fa-comment-o"></span> 回复</a>
      <form action="" class="reply_form">
        <textarea name="reply" class="reply_box form-comment"></textarea>
        <input type="submit" value="回复" class="btn reply_btn">
      </form>
    </div>
  </div>
</li>
{{/each}}
{{if(num>2)}}
<p class="comment_more">
  <a href="javascript:;" class="parent_more">查看更多评论</a>
</p>
{{/if}}
{{else}}
<p class="no_comment">还没有评论，快来抢沙发吧！</p>
{{/if}}

</script>
<script type="text/x-art-template" id="parent_more">
{{if(parent_length>=1)}}
{{each parent item index}}
<li class="media comment-row" id="{{item.id}}"  page="1">
  <div class="media-left">
    <img class="media-object avatar" src="{{item.avatar}}" alt="头像">
  </div>
  <div class="media-body comment-column-right">
    <h4 class="media-heading username">{{item.name}}</h4>
    <p class="time"><span class="fa fa-clock-o"> </span> {{item.comment_time}}</p>
    <div class="comment-content">
      <p class="comment-call">{{item.content}}</p>
      <div class="reply">
        {{each children value index}}
        {{if(value.parent_id == item.id)}}
        <div class="reply-block" id="{{value.id}}">
          <p class="reply-content">
            <a href="#" class="reply-user">{{value.name}}</a>: {{value.content}}
          </p>
          <div class="interaction">
            <a href="javascript:;" class="love"><span class="glyphicon glyphicon-fire no_fire"></span> 赞
              {{if(value.love>0)}}
                <span class="love_num">{{value.love}}</span>
                {{else}}
                <span class="love_num"></span>
              {{/if}}
            </a>
            <span class="reply-time"><span class="fa fa-clock-o"></span> {{value.comment_time}}</span>
          </div>
        </div>
        {{/if}}
        {{/each}}
        {{if(item.children_num>2)}}
        <a href="javascript:;"  class="reply-more">查看全部{{item.children_num}}条回复<span class="fa fa-chevron-right"></span></a>
        {{/if}}
        <div class="comment-more-detail">
          <p class="more-reply">更多回复</p>
        </div>
      </div>
    </div>
    <div class="interaction">
      <a href="javascript:;" class="love"><span class="fa fa-thumbs-o-up"></span> 赞
        {{if(item.love>0)}}
          <span class="love_num">{{item.love}}</span>
          {{else}}
          <span class="love_num"></span>
        {{/if}}
      </a>
      <a href="javascript:;" class="reply-switch"><span class="fa fa-comment-o"></span> 回复</a>
      <form action="" class="reply_form">
        <textarea name="reply" class="reply_box form-comment"></textarea>
        <input type="submit" value="回复" class="btn reply_btn">
      </form>
    </div>
  </div>
</li>
{{/each}}
{{if(parent_length<10)}}
  <p class="no_comment">没有更多评论了</p>
{{else}}
  <p class="comment_more">
    <a href="javascript:;" class="parent_more">查看更多评论</a>
  </p>
{{/if}}
{{else}}
  <p class="no_comment">
   没有更多评论了
  </p>
{{/if}}
</script>
<script type="text/x-art-template" id="children_more">
  {{if(children_length>=1)}}
  {{each children value index}}
  <div class="reply-block" id="{{value.id}}">
    <p class="reply-content">
      <a href="#" class="reply-user">{{value.name}}</a>:{{value.content}}
    </p>
    <div class="interaction">
      <a href="javascript:;" class="love"><span class="glyphicon glyphicon-fire no_fire"></span> 赞
        {{if(value.love>0)}}
        <span class="love_num">{{value.love}}</span>
        {{else}}
        <span class="love_num"></span>
        {{/if}}
      </a>
      <span class="reply-time"><span class="fa fa-clock-o"></span> {{value.comment_time}}</span>
    </div>
  </div>
  {{/each}}
  {{if(children_length<10)}}
    <div class="reply-block">
      <p class="no_comment">没有更多评论了</p> 
    </div>
  {{else}}
    <div class="reply-block">
      <a href="javascript:;" class="reply-more-more">查看更多回复</a> 
    </div>
  {{/if}}
  {{else}}
  <p class="comment_more">
  <p class="no_comment">没有更多评论了</p>
  </p>
  {{/if}}
  
</script>

<script>
  // 查看更多评论为显示多余10条信息
  $(function(){
    var id = <?php echo $id?>;
    var page = 1;
    var user_id = <?php echo $user_id?>;
    // 对话框的标题
    var title = "警告";
    $.ajax(
      {
        url:'/article/comment_page.php',
        type: 'POST',
        async: false,
        data:{
          id:id,
          page:page
        },
        dataType: 'json',
        success: function(res){
          var html = template('comment',{
            parent: res.parent,
            children: res.children,
            num: res.num
          });
          $('.comment-detail').append(html);
        }
    })
    // 查看更多父评论
    $(".comment-detail").on("click",".parent_more",function(){
      // 父评论是在原本的page++;
      // 子评论是page永远为1
      event.preventDefault();
      page++;
      $(this).parents('.comment_more').remove();
      // console.log($(this).parents());
      $.ajax(
      {
        url:'/article/comment_page.php',
        type: 'POST',
        async: false,
        data:{
          id:id,
          page:page
        },
        dataType: 'json',
        success: function(res){
          var html = template('parent_more',{
            parent: res.parent,
            children: res.children,
            parent_length: res.parent == null ? 0 : res.parent.length,
            children_length: res.children == null ? 0 : res.children.length 
          });
          $('.comment-detail').append(html);
        }
      })
    })
    // 查看更多子评论
    // 这里的页面一定不能和前面的页面产生冲突
    // 每个父评论的子page也不能产生冲突
    // 如何为动态追加的元素注册事件
    $(".comment-detail").on("click",".reply-more-more",function(){
      children_more($(this));
    })
    $(".comment-detail").on("click",".reply-more",function(){
      children_more($(this));
    })
    function children_more(element){
      $comment_row = element.parents('.comment-row');
      var children_page =  parseInt($comment_row.attr('page')) + 1;
      $comment_row.attr('page',children_page);
      id = $comment_row.attr('id');
      element.remove();
      $.ajax({
        url:'/article/comment_page.php',
        type: 'POST',
        async: false,
        // 这里传出去的是评论的id
        data:{
          comment_id:id,
          page:children_page
        },
        dataType: 'json',
        success: function(res){
          var html = template('children_more',{
            children: res.children,
            children_length: res.children == null ? 0 : res.children.length
          });
          $('#'+id).find('.comment-more-detail').append(html).show();  
        }
      })
    }
    // 如果成功了我就让用户知道评论发表成功,请等待管理员审核成功后即可展示
    // 无论是提交哪个评论，提交的是父评论的话，我得知道该文章的id是多少,然后将文章id传给后台，后台才能保存到数据库
    // 父评论提交需要知道的数据：文章id,用户id,parent_id:null（不用管），content,
    // 提交子评论的话，我得知道文章id也传过去，父评论的id是就是parent_id,user_id,content,提交成功的话然后审核成功
    // 这条评论对应的父评论的children_num才增加
    // 父评论
    // 提交评论的时候应该先验证下评论内容是否为空
    $('.parent_comment_submit').on('click', function() {
      comment_commit($(this),null);
    })
    // 回复评论提交
    $('.comment-detail').on('click', '.reply_btn', function() {
      parent_id = $(this).parents('.comment-row').attr('id');
      comment_commit($(this),parent_id);
    })
    // element:点击提交的元素
    function comment_commit(element,parent_id){
      event.preventDefault();
      // 获取评论内容，直接根据点击元素查找到父元素在找到文本框提交的内容
      // 这样看待会有没有机会父评论和子评论用同一个函数
      // 获取用户id
      // 对于未登陆用户如何阻止用户去评论呢？
      // 这里再次确认用户是否登陆
      // console.log(content == null);
      // 如果user_id为0,那么该用户未登陆，否则登陆
      // 如何知道parent_id 
      // parent_id可以传也可以不传，但是函数如何设置参数可传可不传呢？
      // 点击按钮以后应该同时将对应的文本域的value清空
      if(user_id == 0){
        warn(title,'您还未登陆,请先登录后再发表评论');
        return;
      }
      var content = element.parents('form').find('.form-comment').val();
      if(!content){
        warn(title,'评论内容不能为空');
        return;
      } 
      element.parents('form').find('.form-comment').val('');
      $.ajax({
        url: '/article/comment_commit.php',
        type: 'POST',
        // 传过去的文章id
        data: {
          id: id,
          user_id: user_id,
          content: content,
          parent_id: parent_id
        },
        dataType: 'json',
        success: function(res){
          // 根据返回的信息做处理
          if(res.danger==true){
            warn(title,res.message);
          } else if(res.success==true){
            title = '恭喜';
            warn(title,res.message);
          }
        }
      })
    }
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
    // 登陆用户才能点赞
    // 后台处理审核记得更新父评论的子评论数量
    // 1.更新comment的love
    // 2.更新praise的赞的详细数据
    // 点赞用户id:post_id
    // 评论id:comment_id
    // 被点赞用户的id:receive_id
    // 赞的数量如何增加计算
    $('.comment-detail').on('click','.love',function(){
      var praise = $(this);
      // 点赞用户的id
      if(user_id == 0){
        warn(title,'您还未登陆,请先登录后再点赞');
        return;
      }
      // console.log($(this).parents('.reply-block').attr('id'));
      // 如何区分它是位父评论点赞还是为子评论点赞
      // 如果没有查找到reply-block的父元素，那么就是父评论点赞
      // 否则就是子评论点赞
      // console.log($(this).parents('.reply-block'));
      // 长度为一就是子评论点赞
      // 子评论
      var child = praise.parents('.reply-block');
      // 父评论
      var parent = praise.parents('.comment-row');
      if(child.length == 1){
        var comment_id = child.attr('id');
      } else if(parent.length == 1) {
        var comment_id = parent.attr('id');
      } else {
        warn(title,'请正常点赞')
      }
      var love_num = praise.find('.love_num').text();
      // 赞的数量》0
      // 获取原来的点赞数量
      if(love_num){
        love_num = parseInt(love_num)
      } else {
        // 赞的数量=0
       love_num = 0
      }
      // 还需考虑重复点赞取消点赞等问题
      // 一个评论一个用户只能点赞一次
      // 默认最开始的时候一个点赞数量为0,一个用户只能点赞一次，点赞后数字再增加
      // 赞为0的时候数字都不显示，赞大于等于1的时候再显示赞的数字
      // 点赞取消赞
      $.ajax({
        url:'/article/comment_praise.php',
        type: 'POST',
        dataType: 'json',
        data: {
          user_id: user_id,
          comment_id: comment_id
        },
        success: function(res){
          if(res.success == false || res.cancel==false) {
            warn(title,res.message);
            // 设置颜色变化
            // 点赞成功我应该设置.love_num的数量增加,
            // 并且向评论数据表增加点赞数量,并保存
          } else if(res.success == true) {
            love_num = parseInt(love_num) + 1;
            praise.find('.love_num').text(love_num);
            praise.addClass('love_fire');
          } else if(res.cancel == true) {
            // 取消点赞成功
            // 如果减一过后的数量小于1不应该填写
            love_num = parseInt(love_num) - 1;
            if(love_num > 0){
              praise.find('.love_num').text(love_num);
            } else {
              praise.find('.love_num').text('');
            }
            praise.removeClass('love_fire');
          }
        }
      })

    })
  })
</script>