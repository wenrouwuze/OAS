<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html style="height:100%; overflow-y: hidden">
<head lang="en">
    <meta charset="UTF-8">
    <title>人力资源系统-登录</title>
</head>
<link rel="stylesheet" href="/Public/css/main.css">
<link rel="stylesheet" href="/Public/resource/bootstrap/css/bootstrap.min.css">
<body style="height: 100%;">
<div class="login-page">
    <div class="login-pic">
        <img src="/Public/images/login.png" class="login-img">
        <img src="/Public/images/login-logo.png" class="login-logo">
        <img src="/Public/images/login-char.png" class="login-char">
    </div>
    <form action="<?php echo U('Home/Login/loginPro');?>" method="post" enctype="multipart/form-data" style="height: 100%;">
        <div class="login-detail" >
            <div class="title">
                <img src="/Public/images/login-title.png" style="width: 95%;">
            </div>
            <div class="input-msg">
                <span>用户名</span>
                <input type="text" placeholder="请输入用户名" class="form-control" name="m_username" id="m_username" required>
            </div>
            <div class="input-msg">
                <span>密码</span>
                <input type="password" placeholder="请输入密码" class="form-control" name="m_password" id="m_password" required>
            </div>
            <!--<button class="btn" type="button">登录</button>-->
            <button class="btn" type="submit">登录</button>
            <input type="checkbox" name="ck_rmbUser" id="ck_rmbUser" >
            <span>记住我</span>
            <span style="float: right; margin-top: 2px" onclick="alert('暂不支持')">忘记密码？</span>
        </div>
    </form>
</div>
</body>
</html>
<script src="/Public/resource/echarts.common.min.js"></script>
<script src="/Public/resource/jQuery/jquery-1.11.0.min.js"></script>
<script src="/Public/resource/bootstrap/js/bootstrap.min.js"></script>
<script src="/Public/resource/jQuery/jquery.cookie.js"></script>
<script type="text/javascript" src="/Public/js/login/login.js"></script>