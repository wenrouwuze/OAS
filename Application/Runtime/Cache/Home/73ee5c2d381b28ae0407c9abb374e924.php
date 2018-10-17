<?php if (!defined('THINK_PATH')) exit();?><!--header start-->
<!--header start-->
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title><?php echo ($title); ?></title>
</head>
<link rel="stylesheet" href="/Public/css/main.css">
<link rel="stylesheet" href="/Public/resource/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="/Public/resource/toastr/toastr.min.css">
<link rel="shortcut icon" href="/faviconv.ico" />
<script src="/Public/resource/jQuery/jquery-1.11.0.min.js"></script>

<!--layui引入 start-->
<link rel="stylesheet" href="/Public/resource/layui/css/layui.css">
<script src="/Public/resource/layui/layui.js"></script>
<!--layui引入 end-->

<body>

<!--header end-->

<!--<div class="container-m">-->

<!--banner start-->
<script src="/Public/resource/toastr/toastr.min.js"></script>
<div class="banner">
    <div class="banner-left pull-left">
        <div class="logo">
            <img src="/Public/images/logo.png" class="logo-img">
            <img src="/Public/images/logo-char.png" class="logo-char">
        </div>

    </div>
    <div class="banner-right pull-left">
        <span class="title">人力资源管理系统</span>
        <div class="banner-r">
            <a href="javascript:;" onclick="alert('暂不支持')">
                <img src="/Public/images/message.png" class="img-msg">
                <img src="/Public/images/message-num.png" class="msg-num">
                <span class="notice">通知</span>
            </a>
            <img src="/Public/images/user.png"class="img-user">
            <span class="name dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="<?php echo ($uid); ?>"><?php echo ($username); ?></a>
                        <ul class="dropdown-menu pull-right">
                            <li class="option" data-toggle="modal" data-target="#modify">修改密码</li>
                            <li class="divider"></li>
                            <li class="option"><a href="<?php echo U('Home/Login/login_out');?>">退出登录</a></li>
                        </ul>
                    </span>
            <img src="/Public/images/1.png" class="img-1">
        </div>
    </div>
</div>
<div class="modal fade" id="modify" tabindex="-1" role="dialog" aria-labelledby="modifyLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <div class="modal-title" id="modifyLabel">
                    修改密码
                </div>
            </div>
            <!--修改密码-->

                <div class="body" style="height: 300px">
                <div class="list-1">
                    <input type="password" placeholder="当前密码" name="passwordnow">
                    <span>当前密码</span>
                    <div class="iserror" style="display: none" id="iserror_now">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6">
                            <small class="text-danger" id="passwordnowerror">原密码不正确，请重新输入！</small>
                        </div>
                    </div>
                </div>
                <div class="list-1">
                    <input type="password" placeholder="请输入6-16位密码，由字母和数字组合" name="passwordnew">
                    <span>新密码</span>
                    <div class="iserror" style="display: none" id="iserror_new">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8">
                            <small class="text-danger" id="passwordnewerror">与新密码不一致，请再次确认新密码！</small>
                        </div>
                    </div>
                </div>
                <div class="list-1">
                    <input type="password" placeholder="确认密码" name="passwordagin">
                    <span>确认密码</span>
                    <div class="iserror" style="display: none" id="iserror_newagin">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8">
                            <small class="text-danger" id="passwordaginerror">与新密码不一致，请再次确认新密码！</small>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="float: left">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
                    &nbsp;&nbsp;
                    <button type="button" class="btn btn-blue" style="float: right" id="modify-passwd">&nbsp;&nbsp;确定&nbsp;&nbsp;</button>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    /*修改密码*/
    toastr.options.positionClass = 'toast-top-center';
    $("#modify-passwd").click(function () {
        var passwordnow = $("input[name='passwordnow']").val();     //当前密码
        var passwordnew = $("input[name='passwordnew']").val();     //新密码
        var passwordagin = $("input[name='passwordagin']").val();   //新密码对比
        var userid = $('.banner-r .dropdown a').attr('id');        //用户id

        if(passwordnow.length > 0){ //当前密码已输入
            $('#iserror_now').css('display','none');
          if(passwordnew.length > 0){   //新密码已输入
              $('#iserror_new').css('display','none');
              var regx = /^(?![^a-zA-Z]+$)(?!\D+$).{2,10}/;
              if(regx.test(passwordnew)){   //新密码验证
                  $('#iserror_new').css('display','none');
                  if(passwordagin.length > 0){    //再次一遍已输入
                      $('#iserror_newagin').css('display','none');
                      if(passwordnew == passwordagin){    // 新密码对比无错误
                          $('#iserror_newagin').css('display','none');
                          var url = "<?php echo U('Home/Login/updatePassword');?>";
                          $.post(url,{"userid":userid,"passwordnow":passwordnow,'passwordnew':passwordnew},function(status){
                              if(status.info == '3'){
                                  $('#passwordnowerror').html('原密码不正确，请重新输入');
                                  $('#iserror_now').css('display','block');
                                  return false;
                              }else if(status.info == '2'){
                                  toastr.error('修改失败！请联系管理员');
                                  return false;
                              }else{
                                  toastr.success('修改成功！');
                                  /*上下之间间隔2秒*/
                                   var url = "<?php echo U('Home/Login/login');?>";
                                   window.location.href = url;
                              }
                          });
                      }else{
                          $('#passwordaginerror').html('密码不匹配，请重新输入');
                          $('#iserror_newagin').css('display','block');
                          return false;
                      }
                  }else{
                      $('#passwordaginerror').html('请再一次输入新密码');
                      $('#iserror_newagin').css('display','block');
                      return false;
                  }
              }else{
                  $('#passwordnewerror').html('新密码不符合规则，请重新输入');
                  $('#iserror_new').css('display','block');
                  return false;
              }
          }else{

              $('#passwordnewerror').html('请输入新密码');
              $('#iserror_new').css('display','block');
              return false;
          }
        }else{

            $('#passwordnowerror').html('请输入当前密码');
            $('#iserror_now').css('display','block');
            return false;
        }
    });
</script>
<!--banner end-->

<!--leftMenu start-->
<style>
    /*左侧部门树形结构，超出高度后自动出现滚动条*/
    .left-panel{
        overflow: auto;
    }
</style>
<div class="list-con">

    <div class="portal">

        <div class="blue-bar"></div>
        <a href="<?php echo U('Home/Main/Index');?>">
            <img src="/Public/images/work-station.png">
            <span class="on">工作台</span>
        </a>
    </div>
    <div class="line"></div>
    <div>
        <div class="list">
            <img src="/Public/images/organization-icon.png" class="icon">
            <img src="/Public/images/1.png" class="icon-1">
            <span class="off">组织管理</span>

                <div class="list-1">
                    <a href="<?php echo U('Home/OrganizeManage/structure');?>">
                        <span class="off">组织架构</span>
                    </a>
                </div>

        </div>
        <div class="list">
            <img src="/Public/images/employee-icon.png" class="icon">
            <img src="/Public/images/1.png" class="icon-1">
            <span class="off">员工管理</span>
            <div class="list-1">
                <a href="<?php echo U('Home/Employee/employee_roster_show');?>"><span class="off">花名册</span></a>
            </div>
        </div>
        <div class="list">
            <img src="/Public/images/attendance-icon.png" class="icon">
            <img src="/Public/images/1.png" class="icon-1">
            <span class="off">考勤管理</span>
            <div class="list-1">
                <a href="<?php echo U('Home/Attendance/attendanceShow');?>"><span class="off">考勤记录</span></a>
            </div>
        </div>
        <div class="list">
            <img src="/Public/images/performance-icon.png" class="icon">
            <img src="/Public/images/1.png" class="icon-1">
            <span class="off">绩效管理</span>
            <div class="list-1">
                <a href="<?php echo U('Home/Achievements/achievementsShow');?>"><span class="off">绩效考核</span></a>
            </div>
        </div>
        <div class="list">
            <img src="/Public/images/social-insurance-icon.png" class="icon">
            <img src="/Public/images/1.png" class="icon-1">
            <span class="off">社保管理</span>
            <div class="list-1">
                <a href="<?php echo U('Home/SocialSecurity/socialSecurityShow');?>"><span class="off">社保</span></a>
            </div>
        </div>
        <div class="list">
            <img src="/Public/images/salary-icon.png" class="icon">
            <img src="/Public/images/1.png" class="icon-1">
            <span class="off">薪酬管理</span>
            <div class="list-1">
                <a href="<?php echo U('Home/Pay/payroll');?>"><span class="off">工资条</span></a>
            </div>
        </div>
    </div>
</div>

<!--leftMenu end-->
<!--header end-->
<!--内嵌样式表 start-->
<style>
    .list-con {
        height: 1375px;
    }

    .button {
        display: none;
    }

    /*输入框边框消失*/
    .main-con .bottom-panel .list-detail .info span input, select {
        border: none;
        cursor: default;
    }

    /*css3属性，可能存在浏览器兼容问题*/
    select {
        -webkit-appearance: none;
        -webkit-tap-highlight-color: #fff;
        outline: 0;
    }

    /**/
    .educationalinfo, .wageinfo {
        display: none;
    }

</style>
<!--内嵌样式表 end-->

<!--员工修改 start-->
<div class="main-con" style="height: 1374px">
    <div class="top-panel">
        <span class="tit">员工管理</span>
    </div>
    <div class="bottom-panel" style="background-color: #ffffff; height: 1266px">
        <div class="tit-1">
            <a href="<?php echo U('Home/Employee/EmployeeShow');?>">
                <button class="btn btn-default">返回</button>
            </a>
        </div>
        <div class="nav-box" style="border-bottom: 1px solid #E6E6E6">
            <ul style="padding: 0px" class="ulbox">
                <li class="on-1"><span class="li_baseinfo">基本信息</span></li>
                <li class="off-1"><span class="li_educationalinfo">教育信息</span></li>
                <li class="off-1"><span class="li_wageinfo">工资信息</span></li>
            </ul>
        </div>
        <form action="<?php echo U('Home/Employee/employee_roster_edit_pro');?>" method="post" enctype="multipart/form-data">
            <!--循环填充数据 start-->
            <?php if(is_array($employee)): $i = 0; $__LIST__ = $employee;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><!--基本信息 start-->
                <div class="baseinfo">
                    <div class="list-tit">
                        <span>个人资料</span>
                        <div class="edit">
                            <img src="/Public/images/edit.png" style="margin-right: 4px; float: left">
                            <span onclick="employee_edit_status(1)">编辑</span>
                        </div>
                    </div>
                    <div class="list-detail" style="height: 460px">
                        <div class="info" style="height: 450px">
                            <div class="list_main">
                                <div class="left"><span>姓名：</span></div>
                                <div class="right"><span><input type="text" name="em_username"
                                                                value="<?php echo ($val["em_username"]); ?>" readonly></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>出生年月：</span></div>
                                <div class="right"><span><input type="text" name="em_birthday"
                                                                value="<?php echo (date('Y-m-d',$val["em_birthday"])); ?>"
                                                                readonly></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>民族：</span></div>
                                <div class="right"><span><input type="text" name="em_nation" value="<?php echo ($val["em_nation"]); ?>"
                                                                readonly></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>手机号码：</span></div>
                                <div class="right"><span><input type="text" name="em_mobile" value="<?php echo ($val["em_mobile"]); ?>"
                                                                readonly></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>邮箱：</span></div>
                                <div class="right"><span><input type="text" name="em_email" value="<?php echo ($val["em_email"]); ?>"
                                                                readonly></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>籍贯：</span></div>
                                <div class="right"><span><input type="text" name="em_province"
                                                                value="<?php echo ($val["em_province"]); ?>" readonly></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>户口所在地：</span></div>
                                <div class="right"><span><input type="text" name="em_register_place"
                                                                value="<?php echo ($val["em_register_place"]); ?>" readonly></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>婚姻状况：</span></div>
                                <div class="right">
                                        <span>
                                            <select name="em_marital_status" disabled>
                                                <option value='1' <?php if($val["em_marital_status"] == 1): ?>selected<?php endif; ?> >未婚</option>
                                                <option value='2' <?php if($val["em_marital_status"] == 2): ?>selected<?php endif; ?> >已婚</option>
                                                <option value='3' <?php if($val["em_marital_status"] == 3): ?>selected<?php endif; ?> >离异</option>
                                                <option value='4' <?php if($val["em_marital_status"] == 4): ?>selected<?php endif; ?>>丧偶</option>
                                            </select>
                                        </span>
                                </div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>孩子出生年月：</span></div>
                                <div class="right"><span><input type="text" name="em_baby_birthday"
                                                                value="<?php echo (date('Y-m-d',$val["em_baby_birthday"])); ?>"
                                                                readonly></span></div>
                            </div>
                        </div>
                        <div class="info" style="height: 450px">
                            <div class="list_main">
                                <div class="left"><span>性别：</span></div>
                                <div class="right">
                                        <span>
                                            <select name="em_sex" disabled>
                                                <option value="1" <?php if($val["em_sex"] == 1): ?>selected<?php endif; ?>>男</option>
                                                <option value="2" <?php if($val["em_sex"] == 2): ?>selected<?php endif; ?>>女</option>
                                            </select>
                                        </span>
                                </div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>年龄：</span></div>
                                <div class="right"><span><input type="text" name="em_age" value="<?php echo ($val["em_age"]); ?>"
                                                                readonly></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>政治面貌：</span></div>
                                <div class="right">
                                        <span>
                                            <select name="em_political_face" disabled>
                                                <?php if(is_array($political)): $i = 0; $__LIST__ = $political;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v); ?>" <?php if($val["em_political_face"] == $v): ?>selected<?php endif; ?> ><?php echo ($v); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                             </select>
                                        </span>
                                </div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>身份证号：</span></div>
                                <div class="right"><span><input type="text" name="em_idcard" value="<?php echo ($val["em_idcard"]); ?>"
                                                                readonly></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>微信号：</span></div>
                                <div class="right"><span><input type="text" name="em_wxnumber"
                                                                value="<?php echo ($val["em_wxnumber"]); ?>" readonly></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>户口类型：</span></div>
                                <div class="right">
                                        <span>
                                            <select name="em_registerplace_type" disabled>
                                                <option value='1' <?php if($val["em_registerplace_type"] == 1): ?>selected<?php endif; ?>>城镇</option>
                                                <option value='2' <?php if($val["em_registerplace_type"] == 2): ?>selected<?php endif; ?>>农村</option>
                                            </select>
                                        </span>
                                </div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>现住址：</span></div>
                                <div class="right"><span><input type="text" name="em_addressnow"
                                                                value="<?php echo ($val["em_addressnow"]); ?>" readonly></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>生育状况：</span></div>
                                <div class="right">
                                        <span>
                                             <select name="em_reproductive_status" disabled>
                                                <option value='1'<?php if($val["em_reproductive_status"] == 1): ?>selected<?php endif; ?> >已育</option>
                                                 <option value='2'  <?php if($val["em_reproductive_status"] == 1): ?>selected<?php endif; ?> >未育</option>
                                            </select>
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list-tit">基本情况</div>
                    <div class="list-detail" style="height: 400px">
                        <div class="info" style="height: 350px">
                            <div class="list_main">
                                <div class="left"><span>工号：</span></div>
                                <div class="right"><span><?php echo ($val["em_worknumber"]); ?></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>工作地区：</span></div>
                                <div class="right"><span><input type="text" name="em_workplace"
                                                                value="<?php echo ($val["em_workplace"]); ?>" readonly></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>职务：</span></div>
                                <div class="right"><span><input type="text" name="em_duties" value="<?php echo ($val["em_duties"]); ?>"
                                                                readonly></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>直属领导：</span></div>
                                <div class="right"><span><input type="text" name="em_firstleader"
                                                                value="<?php echo ($val["em_firstleader"]); ?>" readonly></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>入职时间：</span></div>
                                <div class="right"><span><input type="text" name="em_createtime"
                                                                value="<?php echo (date('Y-m-d',$val["em_createtime"])); ?>" readonly
                                                                id="em_createtime"></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>转正时间：</span></div>
                                <div class="right"><span><input type="text" name="em_formaltime"
                                                                value="<?php echo (date('Y-m-d',$val["em_formaltime"])); ?>" readonly
                                                                id="em_formaltime"></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>续签次数：</span></div>
                                <div class="right"><span><input type="text" name="em_renew" value="<?php echo ($val["em_renew"]); ?>"
                                                                readonly></span></div>
                            </div>
                        </div>
                        <div class="info" style="height: 350px">
                            <div class="list_main">
                                <div class="left"><span>状态：</span></div>
                                <div class="right">
                                        <span>
                                             <select name="em_workstatus" disabled>
                                                 <option value='1' <?php if($val["em_workstatus"] == 1): ?>selected<?php endif; ?>>试用期</option>
                                                 <option value='2' <?php if($val["em_workstatus"] == 2): ?>selected<?php endif; ?>>实习</option>
                                                 <option value='3' <?php if($val["em_workstatus"] == 3): ?>selected<?php endif; ?>>正式</option>
                                                 <option value='4' <?php if($val["em_workstatus"] == 4): ?>selected<?php endif; ?>>离职</option>
                                </select>
                                        </span>
                                </div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>所属公司：</span></div>
                                <div class="right"><span><input type="text" name="em_company" value="<?php echo ($val["em_company"]); ?>"
                                                                readonly></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>一级部门：</span></div>
                                <div class="right"><span><?php echo ($val["em_department_firstname"]); ?></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>二级部门：</span></div>
                                <div class="right"><span><?php echo ($val["em_department_secondname"]); ?></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>三级部门：</span></div>
                                <div class="right"><span><?php echo ($val["em_department_thirdname"]); ?></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>合同到期时间：</span></div>
                                <div class="right"><span><input type="text" name="em_endtime"
                                                                value="<?php echo (date('Y-m-d',$val["em_endtime"])); ?>" readonly
                                                                id="em_endtime"></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>司龄：</span></div>
                                <div class="right"><span><input type="text" name="em_workage" value="<?php echo ($val["em_workage"]); ?>"
                                                                readonly></span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--基本信息 end-->

                <!--教育信息 start-->
                <div class="educationalinfo">
                    <div class="list-tit">
                        <span>教育信息</span>
                        <div class="edit">
                            <img src="/Public/images/edit.png" style="margin-right: 4px; float: left">
                            <span onclick="employee_edit_status(1)">编辑</span>
                        </div>
                    </div>
                    <div class="list-detail" style="height: 200px">
                        <div class="info" style="height: 190px">
                            <div class="list_main">
                                <div class="left"><span>毕业学校：</span></div>
                                <div class="right"><span><input type="text" name="em_graduateschool"
                                                                value="<?php echo ($val["em_graduateschool"]); ?>" readonly></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>专业：</span></div>
                                <div class="right"><span><input type="text" name="em_major" value="<?php echo ($val["em_major"]); ?>"
                                                                readonly></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>职称：</span></div>
                                <div class="right"><span><input type="text" name="em_professional_title"
                                                                value="<?php echo ($val["em_professional_title"]); ?>" readonly></span>
                                </div>
                            </div>
                        </div>
                        <div class="info" style="height: 190px">
                            <div class="list_main">
                                <div class="left"><span>毕业时间：</span></div>
                                <div class="right">
                                        <span>
                                            <input type="text" name="em_graduatetime" value="<?php echo ($val["em_graduatetime"]); ?>"
                                                   readonly id="em_graduatetime">
                                        </span>
                                </div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>文化程度：</span></div>
                                <div class="right">
                                        <span>
                                             <select name="em_degreeofeducation">
                                                <option value="博士" <?php if($val["em_degreeofeducation"] == '博士'): ?>selected<?php endif; ?>>博士</option>
                                                 <option value="硕士" <?php if($val["em_degreeofeducation"] == '硕士'): ?>selected<?php endif; ?>>硕士</option>
                                                 <option value="本科" <?php if($val["em_degreeofeducation"] == '本科'): ?>selected<?php endif; ?>>本科</option>
                                                 <option value="大专" <?php if($val["em_degreeofeducation"] == '大专'): ?>selected<?php endif; ?>>大专</option>
                                                 <option value="中专" <?php if($val["em_degreeofeducation"] == '中专'): ?>selected<?php endif; ?>>中专</option>
                                            </select>
                                        </span>
                                </div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>资质证书：</span></div>
                                <div class="right"><span><input type="text" name="em_qualificationCertificate"
                                                                value="<?php echo ($val["em_qualificationcertificate"]); ?>"
                                                                readonly></span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--教育信息 end-->

                <!--工资信息 start-->
                <div class="wageinfo">
                    <div class="list-tit">
                        <span>工资信息</span>
                        <div class="edit">
                            <img src="/Public/images/edit.png" style="margin-right: 4px; float: left">
                            <span onclick="employee_edit_status(1)">编辑</span>
                        </div>
                    </div>
                    <div class="list-detail" style="height: 360px">
                        <div class="info" style="height: 350px">
                            <div class="list_main">
                                <div class="left"><span>工资卡号：</span></div>
                                <div class="right"><span><input type="text" name="em_banknumber"
                                                                value="<?php echo ($val["em_banknumber"]); ?>" readonly></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>金蝶核算口径（薪金）：</span></div>
                                <div class="right">
                                        <span>
                                             <select name="em_kingdee" disabled>
                                                <?php if(is_array($kingdee)): $i = 0; $__LIST__ = $kingdee;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v); ?>-<?php echo ($key); ?>" <?php if($v-$key == $val.em_kingdee): ?>selected<?php endif; ?>><?php echo ($v); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </select>
                                        </span>
                                </div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>岗位费用金蝶归属部门：</span></div>
                                <div class="right">
                                        <span>
                                            <select name="em_kingdeedepartment">
                                                <?php if(is_array($kingdeedepartment)): $i = 0; $__LIST__ = $kingdeedepartment;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v); ?>-<?php echo ($key); ?>" <?php if($v-$key == $val.em_kingdee): ?>selected<?php endif; ?>><?php echo ($v); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </select>
                                        </span>
                                </div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>电脑补助：</span></div>
                                <div class="right"><span><input type="text" name="em_computersubsidy"
                                                                value="<?php echo ($val["em_computersubsidy"]); ?>" readonly></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>技术补助：</span></div>
                                <div class="right"><span><input type="text" name="em_skillsubsidy"
                                                                value="<?php echo ($val["em_skillsubsidy"]); ?>" readonly></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>基本工资：</span></div>
                                <div class="right"><span><input type="text" name="em_basewage"
                                                                value="<?php echo ($val["em_basewage"]); ?>" readonly></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>标准绩效工资：</span></div>
                                <div class="right"><span><input type="text" name="em_standard_performance_wage"
                                                                value="<?php echo ($val["em_standard_performance_wage"]); ?>"
                                                                readonly></span></div>
                            </div>
                        </div>
                        <div class="info" style="height: 350px">
                            <div class="list_main">
                                <div class="left"><span>银行：</span></div>
                                <div class="right">
                                        <span>
                                            <select name="em_bankname" disabled>
                                                <?php if(is_array($bank)): $i = 0; $__LIST__ = $bank;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v); ?>" <?php if($val["em_bankname"] == $v): ?>selected<?php endif; ?>><?php echo ($v); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </select>
                                        </span>
                                </div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>薪金归属：</span></div>
                                <div class="right">
                                        <span>
                                            <select name="em_wageascription">
                                                <?php if(is_array($wageAscription)): $i = 0; $__LIST__ = $wageAscription;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v); ?>" <?php if($val["em_wageascription"] == $v): ?>selected<?php endif; ?>><?php echo ($v); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </select>
                                        </span>
                                </div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>通讯补助：</span></div>
                                <div class="right"><span><input type="text" name="em_telsubsidy"
                                                                value="<?php echo ($val["em_telsubsidy"]); ?>" readonly></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>交通补助：</span></div>
                                <div class="right"><span><input type="text" name="em_tracfficsidy"
                                                                value="<?php echo ($val["em_tracfficsidy"]); ?>" readonly></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>工资：</span></div>
                                <div class="right"><span><input type="text" name="em_wage" value="<?php echo ($val["em_wage"]); ?>"
                                                                readonly></span></div>
                            </div>
                            <div class="list_main">
                                <div class="left"><span>职位工资：</span></div>
                                <div class="right"><span><input type="text" name="em_positionwage"
                                                                value="<?php echo ($val["em_positionwage"]); ?>" readonly></span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--工资信息 end-->

                <!--表单提交按钮-->
                <div class="button">
                    <button type="reset" class="btn btn-default" style="width: 80px">取消</button>
                    <button type="submit" class="btn btn-blue pull-right" style="width: 80px">保存</button>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
            <!--循环填充数据 end-->
            <input type="hidden" value="<?php echo ($em_id); ?>" name="em_id">
        </form>
    </div>
</div>
<!--员工修改 end-->

<!--</div>-->
<!--footer start-->
<script src="/Public/resource/echarts.common.min.js"></script>
<script src="/Public/resource/bootstrap/js/bootstrap.min.js"></script>

<script src="/Public/js/common.js"></script>

</body>
</html>
<!--footer end-->
<script>
    $(function () {
        /*选项卡切换*/
        $('.ulbox li').on('click', function () {
            $(this).attr('class', 'on-1');
            $(this).siblings().attr('class', 'off-1');
            if ($(this).children().attr('class') == 'li_baseinfo') {
                $('.baseinfo').css('display', 'block');
                $('.educationalinfo').css('display', 'none');
                $('.wageinfo').css('display', 'none');
            } else if ($(this).children().attr('class') == 'li_educationalinfo') {
                $('.baseinfo').css('display', 'none');
                $('.educationalinfo').css('display', 'block');
                $('.wageinfo').css('display', 'none');
            } else if ($(this).children().attr('class') == 'li_wageinfo') {
                $('.baseinfo').css('display', 'none');
                $('.educationalinfo').css('display', 'none');
                $('.wageinfo').css('display', 'block');
            } else {
                return false;
            }
        });
    });

    function employee_edit_status(status) {
        if (status == 1) {
            $("form input").removeAttr('readonly');
            $("form input").css('border', '1px solid #DDDDDD');
            /* $(".baseinfo input").removeAttr('readonly');
             $(".baseinfo input").css('border','1px solid #DDDDDD');
             $(".baseinfo select").css('border','1px solid #DDDDDD');
             $(".baseinfo select").removeAttr('disabled');*/
            /*编辑按钮消失，保存按钮出现*/
            $('.button').css('display', 'block');
            $('.edit').css('display', 'none');
        } else {
            return false;
        }
    }
</script>