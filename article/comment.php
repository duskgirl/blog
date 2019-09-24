<?php
require_once '../config.php';
require_once '../functions.php';
// 获取所有评论数据
// if(empty($_GET['id'])||(empty($_GET['article_id'])||empty($_GET['page']))||(empty($_GET['comment_id'])||empty($_GET['page']))){
//   exit('缺少必要的参数!');
// }
if($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['id'])){
  $id = $_GET['id'];
} 

?>
<div class="comment">
  <h3><span class="fa fa-pencil-square-o"> </span> 发表评论</h3>
  <!-- 未登录时显示的界面 -->
  <!-- 登陆时应该显示用户头像在某个位置 -->
  <!-- texta如何限定字符数,限制100个字符 -->
  <!-- 两种情况，这种是未登陆的 -->
  <!-- <p class="warning"><span class="fa fa-exclamation-triangle"></span> 注册用户登录后才能发表评论，请先<a href="#">登录</a>或<a href="#">注册</a></p> -->
  <!-- 登陆以后的话什么都不显示 -->
  <form action="">
    <textarea  name="comment" class="form-control form-comment">来说几句吧....</textarea>
    <input type="submit" value="评论" class="btn" />
  </form>
  <!-- 无评论的时候显示 -->
  <!-- <p class="no_comment">还没有评论，快来抢沙发吧！</p> -->
  <!-- 有评论的时候显示 -->
  <ul class="media-list comment-detail">
    <h3><span class="fa fa-commenting-o"></span> 最新评论</h3>
    <!-- <?php //if(isset($parent_comment)):?>
    <?php //$parent_num = 0?>
    <?php //foreach($parent_comment as $key => $parent):?>
    <?php //$parent_num++?>
   不是引用评论，都排最前面,我应该知道这条评论的id,然后根据这条评论的id来找到回复此条评论的内容 -->
    <!-- 上面应该是循环所有parent_id 为null的 -->
    <!-- <?php //if($parent_num>=1&&$parent_num<=2):?>
    <li class="media comment-row">
      <div class="media-left">
        <img class="media-object avatar" src="<?php// echo $parent['avatar']?>" alt="头像">
      </div>
      <div class="media-body comment-column-right">
        <h4 class="media-heading username"><?php //echo $parent['name']?></h4>
        <p class="time"><span class="fa fa-clock-o"> </span> <?php //echo $parent['comment_time']?></p>
        <div class="comment-content">
          <p class="comment-call">
          //<?php //echo $parent['content']?>
          </p> -->
          <!-- <div class="reply"> -->
            <!-- 回复者名称 -->
            <?php //if(isset($children_comment)):?>
            <?php //$children_num=0;?>
            <?php //foreach($children_comment as $key => $children):?>
            <!-- 这里设置是否有回复评论 -->
            <?php //if($children['parent_id']==$parent['id']):?>
            <?php //$children_num++?>
            <?php //if($children_num>=1&&$children_num<=2):?>
            <!-- 如何保证这里只显示两条信息 -->
            <!-- <div class="reply-block">
              <p class="reply-content">
              <a href="#" class="reply-user"><?php //echo $children['name']?></a>:<?php //echo $children['content']?>
              </p> -->
              <!-- 首条回复者的赞数量不管是多少，都加上一个火的标识，并且颜色不一样 -->
              <!-- <div class="interaction">
                <a href="javascript:;">
                  <span class="glyphicon glyphicon-fire fire">
                  </span> 赞
                  <?php //if($children['love']>=1):?>
                  <span>
                  <?php //echo $children['love']?>
                  </span>
                  <?php //endif?>
                </a>
                <a class="reply-switch" href="javascript:;"><span class="fa fa-comment-o"></span> 回复</a>
                <span class="reply-time"><?php //echo $children['comment_time']?></span>
                <form action="" class="reply_form">
                  <textarea name="reply" class="reply_box"></textarea>
                  <input type="submit" value="回复" class="btn reply_btn">
                </form>
              </div>
            </div> -->
            <?php //endif?>
            <?php //endif?>
            <?php //endforeach?>
            <?php //endif?>
            <?php //if($children_num>2):?> -->
            <!-- 评论被展开以后能不能做个按钮收起评论,一篇文章应该只有一个收起评论能找到对应的 -->
            <!-- 做一个评论人被点开以后的界面,几乎和个人页面我的评论一样先把个人页面做好，在做这个页面吧 -->
            <!-- 赞要有用户id,用户点赞时间,文章id,文章评论id(也就是被点赞的评论id),被点赞用户id,点赞次数 -->
            <!-- 当一个人被点赞那么就找个这个用户给他发送消息谁给你点了赞即可 -->
            <!-- <a href="javascript:;"  class="reply-more">
              查看全部<?php //echo $children_num?>条回复<span class="fa fa-chevron-right"></span>
            </a> 
            <?php //endif?> -->

            <!-- 当用户点击了查看全部回复的时候才显示 -->
            <!-- <div class="comment-more-detail">
              <p class="more-reply">更多回复</p>
              <div class="reply-block">
              <p class="reply-content">
                <a href="#" class="reply-user">哄哄</a> 
                <span class="answer">回复</span> 
                <a href="#" class="reply-user">团长</a>:靠自己呗！
              </p> -->
              <!-- 首条回复者的赞数量不管是多少，都加上一个火的标识，并且颜色不一样 -->
              <!-- <div class="interaction">
                <a href=""><span class="glyphicon glyphicon-fire fire"></span> 赞<span>1</span></a>
                <a class="reply-switch" href="javascript:;"><span class="fa fa-comment-o"></span> 回复</a>
                <span class="reply-time">2小时前</span>
                <form action="" class="reply_form">
                  <textarea name="reply" class="reply_box"></textarea>
                  <input type="submit" value="回复" class="btn reply_btn">
                </form>
              </div>
            </div> -->
            <!-- 还有多余的评论时显示 -->
            <!-- <a href="#" class="reply-more-more">查看更多回复</a>  -->
          <!-- </div>
        </div> -->
        <!-- <div class="interaction">
           有赞的时候才显示赞的数字，没有赞的时候不显示赞的数 -->
          <!-- <a href="javascript:;" class="support">
            <span class="fa fa-thumbs-o-up"></span>
             赞
             <?php //if($parent['love']>=1):?>
            <span><?php //echo $parent['love']?></span>
            <?php //endif?>
          </a>  -->
          <!-- <a href="javascript:;" class="reply-switch"><span class="fa fa-comment-o"></span> 回复</a>
           回复表单 -->
          <!-- 回复评论默认显示两条 不足两条的直接显示，超过两条的，先显示查看全部多少条回复，然后用户点击以后再显示默认显示6条，
        用户点击查看更多回复再显示6条，直到显示完毕，每条评论也显示赞和回复，同时最好赞的数量越多排在越前面 -->
          <!-- <form action="" class="reply_form">
            <textarea name="reply" class="reply_box"></textarea>
            <input type="submit" value="回复" class="btn reply_btn">
          </form>
        </div>
      </div> -->
    <!-- </li>
    <?php //endif?>
    <?php //endforeach?>
    <?php //if($parent_num>2):?>
    <p class="comment_more">
      <a href="javascript:;" class="parent_more">查看更多评论</a>
    </p>
    <?php //endif?>
    <?php //else:?>
    <p class="no_comment">还没有评论，快来抢沙发吧！</p>
    <?php //endif?> --> --> -->
   
         
          
    <!-- <li class="media comment-row">
      <div class="media-left">
        <img class="media-object avatar" src="images/avatar.jpg" alt="头像">
      </div>
      <div class="media-body comment-column-right">
        <h4 class="media-heading username">大思考</h4>
        <p class="time"><span class="fa fa-clock-o"> </span> 2019-9-10 12:21:21</p>
        <div class="comment-content">
          <p class="comment-call">
          今天天气真好啊！在中餐厅正式营业之前，大家还是比较紧张的 为还有一些事情没有决定
          下来，其中比较严重的一个就是节目的表演问题了。因为这一个问题的存在，杨紫杜海涛 以及沈梦辰开始聚在师严重的一个
          就是节目的表演
          </p>
          <div class="reply"> -->
            <!-- 回复者名称 -->
            <!-- <div class="reply-block">
              <p class="reply-content">
                <a href="#" class="reply-user">居安思危</a>:这20天真的是翻天覆地的变化.从吃不饱到随便吃.水果肉随便买.
              这在20年前真的是无法想象的.在抖音上看到非洲很多国家都有中国农业技术援助中心.教当地人种蔬菜.现在非洲也有
              很多蔬菜品种了.这在以前都是没有的.很多非洲国家都感谢中国
              </p> -->
              <!-- 首条回复者的赞数量不管是多少，都加上一个火的标识，并且颜色不一样 -->
              <!-- <div class="interaction">
                <a href="javascript:;"><span class="glyphicon glyphicon-fire fire"></span> 赞<span>1</span></a>
                <a class="reply-switch" href="javascript:;"><span class="fa fa-comment-o"></span> 回复</a><span class="reply-time">2小时前</span>
                <form action="" class="reply_form">
                  <textarea name="reply" class="reply_box"></textarea>
                  <input type="submit" value="回复" class="btn reply_btn">
                </form>
              </div>
            </div> -->

            <!-- <div class="reply-block">
              <p class="reply-content">
              <a href="#" class="reply-user">哄哄</a>:靠自己呗！
              </p> -->
              <!-- 首条回复者的赞数量不管是多少，都加上一个火的标识，并且颜色不一样 -->
              <!-- <div class="interaction">
                <a href="javascript:;"><span class="glyphicon glyphicon-fire fire"></span> 赞<span>1</span></a>
                <a class="reply-switch" href="javascript:;"><span class="fa fa-comment-o"></span> 回复</a>
                <span class="reply-time">2小时前</span>
                <form action="" class="reply_form">
                  <textarea name="reply" class="reply_box"></textarea>
                  <input type="submit" value="回复" class="btn reply_btn">
                </form>
              </div>
            </div> -->
            <!-- 评论被展开以后能不能做个按钮收起评论,一篇文章应该只有一个收起评论能找到对应的 -->
            <!-- 做一个评论人被点开以后的界面,几乎和个人页面我的评论一样先把个人页面做好，在做这个页面吧 -->
            <!-- <a href="javascript:;"  class="reply-more">查看全部10条回复<span class="fa fa-chevron-right"></span></a>  -->

            <!-- 当用户点击了查看全部回复的时候才显示 -->
            <!-- <div class="comment-more-detail">
              <p class="more-reply">更多回复</p>
              <div class="reply-block">
              <p class="reply-content">
                <a href="#" class="reply-user">哄哄</a> 
                <span class="answer">回复</span> 
                <a href="#" class="reply-user">团长</a>:靠自己呗！
              </p> -->
              <!-- 首条回复者的赞数量不管是多少，都加上一个火的标识，并且颜色不一样 -->
              <!-- <div class="interaction">
                <a href=""><span class="glyphicon glyphicon-fire fire"></span> 赞<span>1</span></a>
                <a class="reply-switch" href="javascript:;"><span class="fa fa-comment-o"></span> 回复</a>
                <span class="reply-time">2小时前</span>
                <form action="" class="reply_form">
                  <textarea name="reply" class="reply_box"></textarea>
                  <input type="submit" value="回复" class="btn reply_btn">
                </form>
              </div>
            </div> -->
            <!-- 还有多余的评论时显示 -->
            <!-- <a href="#" class="reply-more-more">查看更多回复</a> 
          </div>
        </div> -->
        <!-- <div class="interaction"> -->
          <!-- 有赞的时候才显示赞的数字，没有赞的时候不显示赞的数 -->
          <!-- <a href="javascript:;" class="support"><span class="fa fa-thumbs-o-up"></span> 赞<span>1</span></a>
          <a href="javascript:;" class="reply-switch"><span class="fa fa-comment-o"></span> 回复</a> -->
          <!-- 回复表单 -->
          <!-- 回复评论默认显示两条 不足两条的直接显示，超过两条的，先显示查看全部多少条回复，然后用户点击以后再显示默认显示6条，
        用户点击查看更多回复再显示6条，直到显示完毕，每条评论也显示赞和回复，同时最好赞的数量越多排在越前面 -->
          <!-- <form action="" class="reply_form">
            <textarea name="reply" class="reply_box"></textarea>
            <input type="submit" value="回复" class="btn reply_btn">
          </form>
        </div>
      </div>
    </li> -->
    <!-- <li class="media comment-row">
      <div class="media-left">
        <img class="media-object avatar" src="images/avatar.jpg" alt="头像">
      </div>
      <div class="media-body comment-column-right">
        <h4 class="media-heading username">大思考</h4>
        <p class="time"><span class="fa fa-clock-o"> </span> 2019-9-10 12:21:21</p>
        <div class="comment-content">
          <p class="comment-call">
          今天天气真好啊！在中餐厅正式营业之前，大家还是比较紧张的 为还有一些事情没有决定
          下来，其中比较严重的一个就是节目的表演问题了。因为这一个问题的存在，杨紫杜海涛 以及沈梦辰开始聚在师严重的一个
          就是节目的表演
          </p>
          <div class="reply"> -->
            <!-- 回复者名称 -->
            <!-- <div class="reply-block">
              <p class="reply-content">
                <a href="#" class="reply-user">居安思危</a>:这20天真的是翻天覆地的变化.从吃不饱到随便吃.水果肉随便买.
              这在20年前真的是无法想象的.在抖音上看到非洲很多国家都有中国农业技术援助中心.教当地人种蔬菜.现在非洲也有
              很多蔬菜品种了.这在以前都是没有的.很多非洲国家都感谢中国
              </p> -->
              <!-- 首条回复者的赞数量不管是多少，都加上一个火的标识，并且颜色不一样 -->
              <!-- <div class="interaction">
                <a href=""><span class="glyphicon glyphicon-fire fire"></span> 赞<span>1</span></a>
                <a class="reply-switch" href="javascript:;"><span class="fa fa-comment-o"></span> 回复</a><span class="reply-time">2小时前</span>
                <form action="" class="reply_form">
                  <textarea name="reply" class="reply_box"></textarea>
                  <input type="submit" value="回复" class="btn reply_btn">
                </form>
              </div>
            </div> -->

            <!-- <div class="reply-block">
              <p class="reply-content">
              <a href="#" class="reply-user">哄哄</a>:靠自己呗！
              </p> -->
              <!-- 首条回复者的赞数量不管是多少，都加上一个火的标识，并且颜色不一样 -->
              <!-- <div class="interaction">
                <a href="javascript:;"><span class="glyphicon glyphicon-fire fire"></span> 赞<span>1</span></a>
                <a class="reply-switch" href="javascript:;"><span class="fa fa-comment-o"></span> 回复</a>
                <span class="reply-time">2小时前</span>
                <form action="" class="reply_form">
                  <textarea name="reply" class="reply_box"></textarea>
                  <input type="submit" value="回复" class="btn reply_btn">
                </form>
              </div>
            </div> -->
            <!-- 评论被展开以后能不能做个按钮收起评论,一篇文章应该只有一个收起评论能找到对应的 -->
            <!-- 做一个评论人被点开以后的界面,几乎和个人页面我的评论一样先把个人页面做好，在做这个页面吧 -->
            <!-- <a href="javascript:;"  class="reply-more">查看全部10条回复<span class="fa fa-chevron-right"></span></a>  -->
            <!-- 当用户点击了查看全部回复的时候才显示 -->
            <!-- <div class="comment-more-detail">
              <p class="more-reply">更多回复</p>
              <div class="reply-block">
              <p class="reply-content">
                <a href="#" class="reply-user">哄哄</a> 
                <span class="answer">回复</span> 
                <a href="#" class="reply-user">团长</a>:靠自己呗！
              </p> -->
              <!-- 首条回复者的赞数量不管是多少，都加上一个火的标识，并且颜色不一样 -->
              <!-- <div class="interaction">
                <a href="javascript:;"><span class="glyphicon glyphicon-fire fire"></span> 赞<span>1</span></a>
                <a class="reply-switch" href="javascript:;"><span class="fa fa-comment-o"></span> 回复</a>
                <span class="reply-time">2小时前</span>
                <form action="" class="reply_form">
                  <textarea name="reply" class="reply_box"></textarea>
                  <input type="submit" value="回复" class="btn reply_btn">
                </form>
              </div>
            </div> -->
            <!-- 还有多余的评论时显示 -->
            <!-- <a href="javascript:;" class="reply-more-more">查看更多回复</a> 
            
          </div>
        </div>
        <div class="interaction"> -->
          <!-- 有赞的时候才显示赞的数字，没有赞的时候不显示赞的数 -->
          <!-- <a href="javascript:;" class="support"><span class="fa fa-thumbs-o-up"></span> 赞<span>1</span></a>
          <a href="javascript:;" class="reply-switch"><span class="fa fa-comment-o"></span> 回复</a> -->
          <!-- 回复表单 -->
          <!-- 回复评论默认显示两条 不足两条的直接显示，超过两条的，先显示查看全部多少条回复，然后用户点击以后再显示默认显示6条，
        用户点击查看更多回复再显示6条，直到显示完毕，每条评论也显示赞和回复，同时最好赞的数量越多排在越前面 -->
          <!-- <form action="" class="reply_form">
            <textarea name="reply" class="reply_box"></textarea>
            <input type="submit" value="回复" class="btn reply_btn">
          </form>
        </div>
      </div>
    </li>

    <li class="media comment-row">
      <div class="media-left">
        <img class="media-object avatar" src="images/avatar.jpg" alt="头像">
      </div>
      <div class="media-body comment-column-right">
        <h4 class="media-heading username">大思考</h4>
        <p class="time"><span class="fa fa-clock-o"> </span> 2019-9-10 12:21:21</p>
        <p class="comment-content">今天天气真好啊！在中餐厅正式营业之前，大家还是比较紧张的 为还有一些事情没有决定
          下来，其中比较严重的一个就是节目的表演问题了。因为这一个问题的存在，杨紫杜海涛 以及沈梦辰开始聚在师严重的一个
          就是节目的表演
        </p>
        <div class="interaction"> -->
          <!-- 有赞的时候才显示赞的数字，没有赞的时候不显示赞的数 -->
          <!-- <a href="javascript:;" class="support"><span class="fa fa-thumbs-o-up"></span> 赞<span>1</span></a>
          <a href="javascript:;" class="reply-switch"><span class="fa fa-comment-o"></span> 回复</a> -->
          <!-- 回复表单 -->
          <!-- <form action="" class="reply_form">
            <textarea name="reply" class="reply_box"></textarea>
            <input type="submit" value="回复" class="btn reply_btn">
          </form>
        </div>
      </div>
    </li> -->
    
  </ul>
 
</div>
<script src="/blog/lib/jquery/jquery.min.js"></script>
<script src="/blog/lib/art-template/template-web.js"></script>
<script src="/blog/article/js/comment.js"></script>
<!-- 新建一个评论模板 -->
<!-- 默认$value拿到的是当前被遍历的那个元素 -->
<script type="text/x-art-template" id="comment">
{{if(num>=1)}}
{{each parent item index}}
<li class="media comment-row" id="{{item.id}}">
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
        <div class="reply-block">
          <p class="reply-content">
            <a href="#" class="reply-user">{{value.name}}</a>: {{value.content}}
          </p>
          <div class="interaction">
            <a href="javascript:;"><span class="glyphicon glyphicon-fire fire"></span> 赞<span>{{value.love}}</span></a>
            <a class="reply-switch" href="javascript:;"><span class="fa fa-comment-o"></span> 回复</a><span class="reply-time">{{value.comment_time}}</span>
            <form action="" class="reply_form">
              <textarea name="reply" class="reply_box"></textarea>
              <input type="submit" value="回复" class="btn reply_btn">
            </form>
          </div>
        </div>
        {{/if}}
        {{/each}}
        {{if(item.children_num>2)}}
        <a href="javascript:;"  class="reply-more">查看全部{{item.children_num}}条回复<span class="fa fa-chevron-right"></span></a>
        {{/if}}
        <div class="comment-more-detail">
          <p class="more-reply">更多回复</p>
          <div class="reply-block">
          <p class="reply-content">
            <a href="#" class="reply-user">哄哄</a> 
            <span class="answer">回复</span> 
            <a href="#" class="reply-user">团长</a>:靠自己呗！
          </p>
          <div class="interaction">
            <a href=""><span class="glyphicon glyphicon-fire fire"></span> 赞<span>1</span></a>
            <a class="reply-switch" href="javascript:;"><span class="fa fa-comment-o"></span> 回复</a>
            <span class="reply-time">2小时前</span>
            <form action="" class="reply_form">
              <textarea name="reply" class="reply_box"></textarea>
              <input type="submit" value="回复" class="btn reply_btn">
            </form>
          </div>
        </div> -->
        <a href="#" class="reply-more-more">查看更多回复</a> 
      </div>
    </div>
    <div class="interaction">
      <a href="javascript:;" class="support"><span class="fa fa-thumbs-o-up"></span> 赞<span>1</span></a>
      <a href="javascript:;" class="reply-switch"><span class="fa fa-comment-o"></span> 回复</a>
      <form action="" class="reply_form">
        <textarea name="reply" class="reply_box"></textarea>
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
<li class="media comment-row" id="{{item.id}}">
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
        <div class="reply-block">
          <p class="reply-content">
            <a href="#" class="reply-user">{{value.name}}</a>: {{value.content}}
          </p>
          <div class="interaction">
            <a href="javascript:;"><span class="glyphicon glyphicon-fire fire"></span> 赞<span>{{value.love}}</span></a>
            <a class="reply-switch" href="javascript:;"><span class="fa fa-comment-o"></span> 回复</a><span class="reply-time">{{value.comment_time}}</span>
            <form action="" class="reply_form">
              <textarea name="reply" class="reply_box"></textarea>
              <input type="submit" value="回复" class="btn reply_btn">
            </form>
          </div>
        </div>
        {{/if}}
        {{/each}}
        {{if(item.children_num>2)}}
        <a href="javascript:;"  class="reply-more">查看全部{{item.children_num}}条回复<span class="fa fa-chevron-right"></span></a>
        {{/if}}
        <div class="comment-more-detail">
          <p class="more-reply">更多回复</p>
          <div class="reply-block">
          <p class="reply-content">
            <a href="#" class="reply-user">哄哄</a> 
            <span class="answer">回复</span> 
            <a href="#" class="reply-user">团长</a>:靠自己呗！
          </p>
          <div class="interaction">
            <a href=""><span class="glyphicon glyphicon-fire fire"></span> 赞<span>1</span></a>
            <a class="reply-switch" href="javascript:;"><span class="fa fa-comment-o"></span> 回复</a>
            <span class="reply-time">2小时前</span>
            <form action="" class="reply_form">
              <textarea name="reply" class="reply_box"></textarea>
              <input type="submit" value="回复" class="btn reply_btn">
            </form>
          </div>
        </div> -->
        <a href="#" class="reply-more-more">查看更多回复</a> 
      </div>
    </div>
    <div class="interaction">
      <a href="javascript:;" class="support"><span class="fa fa-thumbs-o-up"></span> 赞<span>1</span></a>
      <a href="javascript:;" class="reply-switch"><span class="fa fa-comment-o"></span> 回复</a>
      <form action="" class="reply_form">
        <textarea name="reply" class="reply_box"></textarea>
        <input type="submit" value="回复" class="btn reply_btn">
      </form>
    </div>
  </div>
</li>
{{/each}}
{{if(parent_length<10)}}
  <p class="comment_more">
  <span class="parent_more">没有更多评论了</span>
  </p>
{{/if}}
{{if(parent_length<1)}}
  <p class="comment_more">
   没有更多评论了
  </p>
{{/if}}
{{else}}
<p class="no_comment">还没有评论，快来抢沙发吧！</p>
{{/if}}
</script>
<script type="text/x-art-template" id="children_more">

</script>

<script>
  // 查看更多评论为显示多余10条信息
  $(function(){
    var id = <?php echo $id?>;
    var page = 1;
    $.ajax(
      {
        url:'/blog/article/comment_page.php',
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
    $('.parent_more').click(function(){
      event.preventDefault();
      page++;
      $(this).parents('.comment_more').remove();
      // console.log($(this).parents());
      $.ajax(
      {
        url:'/blog/article/comment_page.php',
        type: 'POST',
        async: false,
        data:{
          id:id,
          page:page
        },
        dataType: 'json',
        success: function(res){
          console.log(res);
          var html = template('parent_more',{
            parent: res.parent,
            children: res.children,
            parent_length: res.parent.length,
            children_length: res.children_length
          });
          $('.comment-detail').append(html);
        }
      })
    })
    // 查看更多子评论
    $(".reply-more").click(function(){
      event.preventDefault();
      id = $(this).parents('.comment-row').attr('id');
      $(this).remove();
      $.ajax({
        url:'/blog/article/comment_page.php',
        type: 'POST',
        async: false,
        // 这里传出去的是评论的id
        data:{
          comment_id:id,
          page:page
        },
        dataType: 'json',
        success: function(res){
          console.log(res);
          var html = template('children_more',{
            children: res.children,
            children_length: res.children_length
          });
          // $('.comment-detail').append(html);
        }
      })
    })
  })
</script>

<div class="comment-more-detail">
              <p class="more-reply">更多回复</p>
              <div class="reply-block">
              <p class="reply-content">
                <a href="#" class="reply-user">哄哄</a> 
                <span class="answer">回复</span> 
                <a href="#" class="reply-user">团长</a>:靠自己呗！
              </p> -->
              <!-- 首条回复者的赞数量不管是多少，都加上一个火的标识，并且颜色不一样 -->
              <!-- <div class="interaction">
                <a href="javascript:;"><span class="glyphicon glyphicon-fire fire"></span> 赞<span>1</span></a>
                <a class="reply-switch" href="javascript:;"><span class="fa fa-comment-o"></span> 回复</a>
                <span class="reply-time">2小时前</span>
                <form action="" class="reply_form">
                  <textarea name="reply" class="reply_box"></textarea>
                  <i nput type="submit" value="回复" class="btn reply_btn">
                </form>
              </div><div class="comment-more-detail">
              <p class="more-reply">更多回复</p>
              <div class="reply-block">
              <p class="reply-content">
                <a href="#" class="reply-user">哄哄</a> 
                <span class="answer">回复</span> 
                <a href="#" class="reply-user">团长</a>:靠自己呗！
              </p> -->
              <!-- 首条回复者的赞数量不管是多少，都加上一个火的标识，并且颜色不一样 -->
              <!-- <div class="interaction">
                <a href="javascript:;"><span class="glyphicon glyphicon-fire fire"></span> 赞<span>1</span></a>
                <a class="reply-switch" href="javascript:;"><span class="fa fa-comment-o"></span> 回复</a>
                <span class="reply-time">2小时前</span>
                <form action="" class="reply_form">
                  <textarea name="reply" class="reply_box"></textarea>
                  <input type="submit" value="回复" class="btn reply_btn">
                </form>
              </div>