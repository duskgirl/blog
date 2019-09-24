// 点击回复，弹出回复框

$(function() {
  $('.reply-switch').on({
      'click': function() {
        if ($(this).html() == '<span class="fa fa-comment-o"></span> 回复') {
          $('.reply-switch').html('<span class="fa fa-comment-o"></span> 回复');
          $('.reply-switch').css('color', '#adadad');
          $('.reply_form').hide();
          $(this).html('<span class="fa fa-comment-o"></span> 收起');
          $(this).css('color', '#17a2b8');
          // console.log($(this).parent().find('.reply_form'));
          $(this).parent().find('.reply_form').show();
        } else {
          $(this).html('<span class="fa fa-comment-o"></span> 回复');
          $(this).parent().find('.reply_form').hide();
        }
      }
    })
    // 点击查看全部评论的时候，显示全部评论
  $('.reply-more').on('click', function() {
      // 当前更多评论
      $more = $(this).parent().find('.comment-more-detail');
      if ($more.css('display') == 'none') {
        $(this).hide();
        $more.show();
      } else {
        $more.hide();
      }
    })
    //   // 点击按钮，发送ajax请求,获取主评论
    // $('.parent_more').on('click', function() {
    //   event.preventDefault();
    //   $.post('/blog/article/comment_parent.php', {
    //       id: "<?php echo $id?>",
    //       page: "<?php echo $page?>"
    //     },
    //     function(data, status) {
    //       console.log(data);
    //     })
    // })
    // $('.parent_more').on('click', function() {
    //   event.preventDefault();
    //   console.log(<?php echo $id?>);
    // })

})