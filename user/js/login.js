// 初步检验表单内容
// 登录页面忘记密码
// 1.初步检测用户名是否存在
// 2.初步检测输入密码是否和当前用户匹配
$(function() {
  $('.login').bootstrapValidator({
    message: 'This value is not valid',
    feedbackIcons: {　　
      valid: 'glyphicon glyphicon-ok',
      　　invalid: 'glyphicon glyphicon-remove',
      　　validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
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
            // 检测当前用户是否注册
            url: '/user/checkUnique.php',
            // 提示消息
            message: '当前用户尚未注册',
            delay: 2000,
            type: 'POST',
            data: {
              // 这个数据是默认会传递的
              // username: function(){
              //   return $.trim($('.login').find('.form-username').val())
              // },
              unique: function() {
                return false
              }
            }
          }
        }
      },
      password: {
        verbose: false,
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
          },
          remote: {
            // 检测当前用户是否注册
            url: '/user/checkUnique.php',
            // 提示消息
            message: '输入密码与当前用户不匹配，请重新输入',
            delay: 2000,
            type: 'POST',
            data: {
              username: function() {
                return $.trim($('.login').find('.form-username').val())
              }
            }
          }
        }
      }
    }
  })
})