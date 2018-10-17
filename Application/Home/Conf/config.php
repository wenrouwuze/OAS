<?php
return array(
    //'配置项'=>'配置值'
    //路由模式-pathinfo

    //数据库配置信息
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => 'localhost', // 服务器地址
    'DB_NAME'   => 'osa', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => 'root', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => 'osa_', // 数据库表前缀
    'DB_CHARSET'=> 'utf8', // 字符集
    'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增


    /*是否启用测试功能*/
    'C_test'    => '1', //忘记功能中！！！

    /*系统变量*/
    'OSA_title'  => '云分析',

    /*访问控制*/
    'DEFAULT_MODULE' => 'Home', // 默认模块
    'DEFAULT_CONTROLLER' => 'Login', // 默认控制器名称
    'DEFAULT_ACTION' => 'loginShow', // 默认操作名称

    /*邮箱内容配置*/
    'MAIL_HOST' =>'mail.ucap.com.cn',//smtp服务器的名称，这里用的是新浪邮箱，qq: smtp.qq.com , 163:smtp.163.com
    'MAIL_SMTPAUTH' =>TRUE, //启用smtp认证
    'MAIL_USERNAME' =>'chengwl@ucap.com.cn',//发件人邮箱名，注意换成你注册的新浪邮箱地址
    'MAIL_FROM' =>'chengwl@ucap.com.cn',//发件人邮箱地址，注意换成你注册的新浪邮箱地址
    'MAIL_FROMNAME'=>'chengwl@ucap.com.cn',//发件人姓名
    'MAIL_PASSWORD' =>'cwl*&^0806',//密码，请填上发件人邮箱密码
    'MAIL_CHARSET' =>'utf-8',//设置邮件编码
    'MAIL_ISHTML' =>TRUE,// 是否HTML格式邮件
)
?>
