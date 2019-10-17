$(function() {
  // 发送ajax请求
  // receive_id
  // send_id
  // comment_content
  // message
  // read_status
  // 根据获取对应的哪条评论通过审核/谁赞、回复了你

  $('.table_message').on('click', '.read_message', function() {
    event.preventDefault();
    // 修改类
    var read = $(this).parents('tr');
    var id = read.attr('id');
    $.ajax({
      url: '/api/message_detail.php',
      type: 'POST',
      dataType: 'json',
      data: {
        id: id
      },
      success: function(data) {
        // console.log(data);
        // 获取消息正常且获取到消息
        var title = '';
        var content = '';
        if (data.success) {
          // 那么这里我应该修改阅读的类
          // 通过审核
          if (read.attr('class') == undefined) {
            read.addClass('read');
          }
          var result = data.message;
          if (result.type == 1) {
            title = '恭喜';
            content = "您的评论: " + result.comment_content + ' 已通过管理员审核';
          }
          // 未通过审核
          if (result.type == 2) {
            title = '抱歉';
            content = "您的评论: " + result.comment_content + ' 未通过管理员审核';
          }
          // 不要点赞
          // if (result.type == 3) {
          //   title = '通知';
          //   content = result.name + ' 赞了您的评论: ' + result.comment_content;
          // }
          // 回复
          if (result.type == 3) {
            title = '通知';
            content = result.name + ' 回复了您的评论: ' + result.comment_content;
          }
        } else {
          title = '抱歉';
          content = data.message;
        }
        warn(title, content);
      }
    })
  })

  function warn(title, content) {
    var d = dialog({
      title: title,
      content: content,
      cancel: false,
      ok: function() {},
      quickClose: true
    });
    d.show(document.getElementById('option-quickClose'));
    setTimeout(function() {
      d.close().remove();
    }, 30000);
  };
  // 复选框删除操作
  // 选中的删除
  // 总复选框被点击
  // 获取要删除元素的id
  var id_array = [];
  var check_item = $('.check_item');
  var check_total = $('.check_total');
  var delete_message = $('.delete_message');
  var search = '';
  check_total.on('change', function() {
    var is_checked_total = $(this).prop('checked');
    check_item.prop('checked', is_checked_total);
    if (is_checked_total) {
      check_item.each(function() {
        // 这里也要先看数组里面有的值在进行添加
        var checked_id = $(this).parents('tr').attr('id');
        var index = id_array.indexOf(checked_id);
        // 应该看下是否要添加的id是否存在，如果已经存在，则不需要添加
        // 原来的没有这个元素
        if (index == -1) {
          id_array.push(checked_id);
        }
      });
      delete_message.attr('disabled', false);
    } else {
      id_array = [];
      delete_message.attr('disabled', true);
    }
    search = '?id=' + id_array;
    delete_message.prop('search', search);
  });

  // 单复选框被点击,只有全被选中总复选框才选中
  // 只要有一个被选中，那么删除按钮就该可用
  check_item.on('change', function() {
    var is_checked_item = $(this).prop('checked');
    var checked_id = $(this).parents('tr').attr('id');
    var index = id_array.indexOf(checked_id);
    var check_item_length = $('.check_item:checked').length;
    var item_length = $('.check_item').length;
    if (is_checked_item) {
      // 应该看下是否要添加的id是否存在，如果已经存在，则不需要添加
      // 原来的没有这个元素
      if (index == -1) {
        id_array.push(checked_id);
      }
    } else {
      id_array.splice(index, 1);
    }
    if (check_item_length == item_length) {
      check_total.prop('checked', true);
    } else {
      check_total.prop('checked', false);
    }
    if (check_item_length > 0) {
      delete_message.attr('disabled', false);
    } else {
      delete_message.attr('disabled', true);
    }
    search = '?id=' + id_array;
    delete_message.prop('search', search);
  });
  // 执行删除消息操作
  // 获取选中
  // 删除键应该一直保持都是disabled状态，要有一个被选中才让他可用
  // 这里不发送ajax请求如何将数组的值传给a标签呢？


})