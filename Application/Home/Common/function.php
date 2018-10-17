<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/16 0016
 * Time: 10:53
 */
function sendMail($to,$body){

    Vendor('PHPMailer.PHPMailerAutoload');

    vendor('PHPMailer.class#PHPMailer');
    vendor('PHPMailer.class#SMTP');

    $mail = new PHPMailer(); //实例化
    $mail->IsSMTP(); // 启用SMTP
    $mail->Host=C('MAIL_HOST'); //smtp服务器的名称（这里以新浪邮箱为例）
    $mail->SMTPAuth = C('MAIL_SMTPAUTH'); //启用smtp认证
    $mail->Username = C('MAIL_USERNAME'); //发件人邮箱名，从config.php中获得
    $mail->Password = C('MAIL_PASSWORD') ; //发件人邮箱密码
    $mail->From = C('MAIL_FROM'); //发件人地址（也就是你的邮箱地址）
    $mail->FromName = C('MAIL_FROMNAME'); //发件人姓名
    $mail->AddAddress($to,"尊敬的客户");
    $mail->WordWrap = 50; //设置每行字符长度
    $mail->Port = 25;
    $mail->IsHTML(C('MAIL_ISHTML')); // 是否HTML格式邮件
    $mail->CharSet=C('MAIL_CHARSET'); //设置邮件编码
    $mail->Subject ='helloworld'; //邮件主题
    $mail->Body = $body; //邮件内容
    $mail->AltBody = "这是一个纯文本的身体在非营利的HTML电子邮件客户端"; //邮件正文不支持HTML的备用显示

    $result = $mail->Send();

    return $result;
}
function getdates($time){
    $data['start'] = date('Y-m-01', strtotime(date("Y-m-d")));
    $data['end']   = date('Y-m-d', strtotime("{$data['start']} +1 month -1 day"));
    return $data;
}

/*
    * | Author: Saron.Mo <momosweb@qq.com>
    * | @param char|int $start_date 一个有效的日期格式，例如：20091016，2009-10-16
    * | @param char|int $end_date 同上
    * | @param int $weekend_days 一周休息天数
    * | @return array
    * | array[total_days]  给定日期之间的总天数
    * | array[total_relax] 给定日期之间的周末天数
    */
function get_weekend_days($start_date, $end_date, $weekend_days = 2)
{

    $data = array();
    if (strtotime($start_date) > strtotime($end_date)) list($start_date, $end_date) = array($end_date, $start_date);

    $start_reduce = $end_add = 0;
    $start_N = date('N', strtotime($start_date));
    $start_reduce = ($start_N == 7) ? 1 : 0;

    $end_N = date('N', strtotime($end_date));

    // 进行单、双休判断，默认按单休计算
    $weekend_days = intval($weekend_days);
    switch ($weekend_days) {
        case 2:
            in_array($end_N, array(6, 7)) && $end_add = ($end_N == 7) ? 2 : 1;
            break;
        case 1:
        default:
            $end_add = ($end_N == 7) ? 1 : 0;
            break;
    }
    $days = round(abs(strtotime($end_date) - strtotime($start_date)) / 86400) + 1;
    $data['total_days'] = $days;
    $data['total_relax'] = floor(($days + $start_N - 1 - $end_N) / 7) * $weekend_days - $start_reduce + $end_add;

    return $data;
}

function htmlcode (){
    $string = <<<STR
   <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        table{
            text-align: center;
        }
    </style>
</head>
<body>
<table border="1" cellspacing="0">
    <tr>
        <td style="background-color: #00b050;min-width: 50px">月份</td>
        <td style="background-color: #00b050;min-width: 50px">姓名</td>
        <td style="background-color: #b7dee8;min-width: 100px">基本工资</td>
        <td style="background-color: #b7dee8;min-width: 100px">职位工资</td>
        <td style="background-color: #b7dee8;min-width: 100px">绩效工资</td>
        <td style="background-color: #b7dee8;min-width: 100px">提成/奖金</td>
        <td style="background-color: #b7dee8;min-width: 100px">电脑补助</td>
        <td style="background-color: #b7dee8;min-width: 100px">技术补助</td>
        <td style="background-color: #b7dee8;min-width: 100px">通讯补助</td>
        <td style="background-color: #b7dee8;min-width: 100px">交通补助</td>
        <td style="background-color: #b7dee8;min-width: 100px">事假天数</td>
        <td style="background-color: #b7dee8;min-width: 100px">病假天数</td>
        <td style="background-color: #b7dee8;min-width: 100px">调休天数</td>
        <td style="background-color: #00b050;min-width: 50px">计薪天数</td>
        <td style="background-color: #00b050;min-width: 50px">系统工时（只填写实施人员）</td>
        <td style="background-color: #00b050;min-width: 50px">带薪假期（不包括调休）</td>
        <td style="background-color: #b7dee8;min-width: 100px">实际出勤天数</td>
        <td style="background-color: #b7dee8;min-width: 100px">计薪工资</td>
        <td style="background-color: #b7dee8;min-width: 100px">餐补</td>
        <td style="background-color: #b7dee8;min-width: 100px">全勤奖</td>
        <td style="background-color: #b7dee8;min-width: 100px">其他补发项目</td>
        <td style="background-color: #b7dee8;min-width: 100px">周报扣款</td>
        <td style="background-color: #b7dee8;min-width: 100px">迟到未打卡扣款</td>
        <td style="background-color: #b7dee8;min-width: 100px">其他扣款</td>
        <td style="background-color: #b7dee8;min-width: 100px">个人扣款</td>
        <td style="background-color: #00b050;min-width: 80px">应发工资</td>
        <td style="background-color: #00b050;min-width: 80px">住房公积金</td>
        <td style="background-color: #00b050;min-width: 80px">养老保险</td>
        <td style="background-color: #00b050;min-width: 80px">失业保险</td>
        <td style="background-color: #00b050;min-width: 80px">门诊/医疗保险</td>
        <td style="background-color: #00b050;min-width: 80px">住院</td>
        <td style="background-color: #00b050;min-width: 80px">税前工资</td>
        <td style="background-color: #00b050;min-width: 80px">个税</td>
        <td style="background-color: #00b050;min-width: 80px">实发工资</td>
    </tr>
    <tr>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
    </tr>
</table>
</body>
</html>
STR;
    return $string;
}