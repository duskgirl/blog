$(function() {
    // 在这之前最好也验证下用户填写的内容是否可行：邮箱/用户名/密码的正则表达式,关闭html5的自动校验因为很丑
    checkInput($(".form-email"), /^[0-9a-zA-Z_.-]+[@][0-9a-zA-Z_.-]+([.][a-zA-Z]+){1,2}$/);
    checkInput($(".form-username"), /^[\\u4e00-\\u9fa5a-zA-Z0-9_.+@]{2,10}$/);
    checkInput($(".form-password"), /^[0-9a-zA-Z_.+]+[@][0-9a-zA-Z_.-]+([.][a-zA-Z]+){1,2}$/)
      // 每一个表单选项填写时就验证用户填写的内容是否可行,然后在选项旁边设置相应的样式（绿色勾勾/红色叉叉）
  })
  // 初步验证表单内容
function checkInput(input, reg) {
  // 文本框失去焦点时验证
  input.onblur = function() {
    if (reg.test($(this).value)) {
      $(this).next().show();
    }
  }
}