<?php
//   require_once './lib/PHPMailer-master/Exception.php';
//   require_once './lib/PHPMailer-master/PHPMailer.php';
//   require_once './lib/PHPMailer-master/SMTP.php';
// /**
//  * @param $address mixed 收件人 多个收件人/或需要设置收件人昵称时为数组 array($address1,$address1)/array(array('address'=>$address1,'nickname'=>$nickname1),array('address'=>$address2,'nickname'=>$nickname2))
//  * @param $subject string 邮件主题
//  * @param $body string 邮件内容
//  * @param $file string 附件
//  * @return bool|string 发送成功返回true 反之返回报错信息
//  * @throws Exception
//  */
// function send_mail_by_smtp($address, $subject, $body, $file = '')
// {
//   require('./lib/PHPMailer-master/Exception.php');
//   require('./lib/PHPMailer-master/PHPMailer.php');
//   require('./lib/PHPMailer-master/SMTP.php');
//  //date_default_timezone_set("Asia/Shanghai");//设定时区东八区
  
//  $mail = new PHPMailer();
  
//  //Server settings
//  $mail->SMTPDebug = 2;
// //  简单邮件传输协议 (Simple Mail Transfer Protocol, SMTP) 是在Internet传输email的事实标准
//  $mail->isSMTP();     // 使用SMTP方式发送
//  $mail->Host = 'smtp.126.com';    // SMTP邮箱域名
//  $mail->SMTPAuth = true;    // 启用SMTP验证功能
//  $mail->Username = "duskgirl@126.com";   // 邮箱用户名(完整email地址)
//  $mail->Password = "dusk1993";    // smtp授权码，非邮箱登录密码
//  $mail->Port = 25;
//  $mail->CharSet = "utf-8";    //设置字符集编码 "GB2312"
  
//  // 设置发件人信息，显示为 你看我那里像好人(xxxx@126.com)
//  $mail->setFrom($mail->Username, '大思考');
  
//  //设置收件人 参数1为收件人邮箱 参数2为该收件人设置的昵称 添加多个收件人 多次调用即可
//  //$mail->addAddress('********@163.com', '你看我那里像好人');
  
//  if (is_array($address)) {
//  foreach ($address as $item) {
//  if (is_array($item)) {
//  $mail->addAddress($item['address'], $item['nickname']);
//  } else {
//  $mail->addAddress($item);
//  }
//  }
//  } else {
//  $mail->addAddress($address, 'adsf');
//  }
  
  
//  //设置回复人 参数1为回复人邮箱 参数2为该回复人设置的昵称
//  //$mail->addReplyTo('*****@126.com', 'Information');
  
//  if ($file !== '') $mail->AddAttachment($file); // 添加附件
  
//  $mail->isHTML(true); //邮件正文是否为html编码 true或false
//  $mail->Subject = $subject; //邮件主题
//  $mail->Body = $body;  //邮件正文 若isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取的html文件
//  //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients'; //附加信息，可以省略
  
//  return $mail->Send() ? true : 'ErrorInfo:' . $mail->ErrorInfo;
// }
  
// $path = '';

// /**
//  * @param $address mixed 收件人 多个收件人/或需要设置收件人昵称时为数组 array($address1,$address1)/array(array('address'=>$address1,'nickname'=>$nickname1),array('address'=>$address2,'nickname'=>$nickname2))
//  * @param $subject string 邮件主题
//  * @param $body string 邮件内容
//  * @param $file string 附件
//  * @return bool|string 发送成功返回true 反之返回报错信息
//  * @throws Exception
//  */
// $ret = send_mail_by_smtp('1689853151@qq.com', 'PHPMailer邮件标题', '安静的借口借口',$path);





// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

  require_once './lib/PHPMailer-master/Exception.php';
  require_once './lib/PHPMailer-master/PHPMailer.php';
  require_once './lib/PHPMailer-master/SMTP.php';

// Load Composer's autoloader
// require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings:服务器配置
    $mail->CharSet = 'UTF-8';
    $mail->SMTPDebug = 2;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'smtp.126.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'duskgirl@126.com';                     // SMTP username
    $mail->Password   = 'dusk1993';                               // SMTP password
    $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 465;                                    // TCP port to connect to

    //Recipients
    // 发件人
    $mail->setFrom('duskgirl@126.com', '大思考');
    // 收件人
    $mail->addAddress('277045704@qq.com', '277045704@qq.com');     // Add a recipient
    // 可添加多个收件人
    // $mail->addAddress('ellen@example.com');               // Name is optional
    // 恢复的时候回复给哪个邮箱，最好和发件人一致
    $mail->addReplyTo('duskgirl@126.com', 'Information');
    // 抄送
    // $mail->addCC('cc@example.com');
    // 密送
    // $mail->addBCC('bcc@example.com');

    // Attachments
    // 发送附件
    // 添加附件
    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // 发送附件并且重命名
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    // 是否以HTML稳定格式发送 发送客户端可直接显示对应HTML内容
    $mail->isHTML(true);                                  // Set email format to HTML
    // 这里是邮件标题
    $mail->Subject = '老公 几点下班';
    // 这里是邮件内容
    $mail->Body    = '这是我用代码给你发的邮件，收到了吗？我就是洋盘下';
    // 如果邮件客户端不支持HTML则显示此内容
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    // 邮件发送成功
    echo 'Message has been sent';
} catch (Exception $e) {
  // 邮件发送失败
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}