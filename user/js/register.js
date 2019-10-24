$(function() {
  $('.register').bootstrapValidator({
    message: 'This value is not valid',
    feedbackIcons: {　　
      valid: 'glyphicon glyphicon-ok',
      invalid: 'glyphicon glyphicon-remove',
      validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
      email: {
        // verbose:false,每一个input顺序验证，一个验证不通过，
        // 那么下一个验证就不走，所以只显示一条错误信息
        verbose: false,
        // threshold: 2,表示在输入几个字符以后再进行下一步验证，
        // 注意位置和validators是同级位置关系，不要写到validators里面去了
        threshold: 2,
        validators: {
          notEmpty: {
            message: '邮箱地址不能为空'
          },
          emailAddress: {
            message: '邮箱地址格式有误'
          },
          remote: {
            // ajax后端验证,服务端返回值
            // server result:{"valid",true or false}
            // url:验证地址
            url: '/user/checkUnique.php',
            // 提示消息
            message: '当前邮箱已存在，请直接去<a href="/user/login.php">登录</a>吧',
            // 每输入一个字符，就发ajax请求，服务器压力太大，所以时间设置长点
            delay: 2000,
            type: 'POST',
            // 自定义提交数据，默认值提交当前input value
            data: function() {
              return {
                email: $.trim($('.register').find('.form-email').val())
              }
            }
          }
        }
      },
      username: {
        verbose: false,
        threshold: 2,
        message: '用户名验证失败',
        validators: {
          notEmpty: {
            message: '用户名不能为空'
          },
          stringLength: {
            min: 2,
            max: 10,
            message: '用户名长度必须在2到10位之间'
          },
          regxp: {
            regexp: /^[a-zA-Z0-9_]+$/,
            message: '用户名只能包含大写，小写，数字和下划线'
          },
          remote: {
            url: '/user/checkUnique.php',
            // 提示消息
            message: '当前用户名已被注册，请换个用户名试试吧',
            delay: 2000,
            type: 'POST',
            data: function() {
              return {
                username: $.trim($('.register').find('.form-username').val())
              }
            }
          }
        }
      },
      password: {
        message: '密码验证失败',
        threshold: 2,
        validators: {
          notEmpty: {
            message: '密码不能为空',
          },
          stringLength: {
            min: 6,
            max: 10,
            message: '密码长度必须在6到10位之间'
          },
          regxp: {
            regexp: /^[a-zA-Z0-9_]+$/,
            message: '密码只能包含大写，小写，数字和下划线'
          }
        }
      },
      repassword: {
        validators: {
          notEmpty: {
            message: '确认密码不能为空',
          },
          identical: {
            field: 'password',
            message: '两次输入的密码不一致'
          }
        }
      }
    }
  })
})