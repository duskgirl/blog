$(function() {
  $('.forget_password').bootstrapValidator({
    message: 'This value is not valid',
    feedbackIcons: {　　
      valid: 'glyphicon glyphicon-ok',
      　　invalid: 'glyphicon glyphicon-remove',
      　　validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
      email: {
        // verbose:false,每一个input顺序验证，一个验证不通过，那么下一个验证就不走，所以只显示一条错误信息
        verbose: false,
        // threshold: 2,表示在输入几个字符以后再进行下一步验证，注意位置和validators是同级位置关系，不要写到validators里面去了
        threshold: 2,
        validators: {
          notEmpty: {
            message: '邮箱地址不能为空'
          },
          emailAddress: {
            message: '邮箱地址格式有误'
          },
          remote: {
            // ajax验证数据的唯一性,服务端返回值,true代表不重复，false代表重复 
            // server result:{"valid",true or false}
            // url:验证地址
            url: '/user/checkUnique.php',
            // 提示消息
            message: '该邮箱尚未注册',
            type: 'POST',
            // 自定义提交数据，默认值提交当前input value
            data: {
              email: function() {
                return $.trim($('.register').find('.form-email').val())
              },
              unique: function() {
                return false
              }
            }
          }
        }
      }
    }
  })
})