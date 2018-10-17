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
<style>
    a:link{
        text-decoration:none;
    }
    a:visited{
        text-decoration:none;
    }
    a:hover{
        text-decoration:none;
    }
    a:active{
        text-decoration:none;
    }
</style>
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
            <a href="javascript:;" onclick="message('暂不支持')">
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
        <a href="<?php echo U('Home/Main/main_workplace_show');?>">
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
                    <a href="<?php echo U('Home/Organize/organize_recard_show');?>">
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
                <a href="<?php echo U('Home/Attendance/attendance_record_show');?>"><span class="off">考勤记录</span></a>
            </div>
        </div>
        <div class="list">
            <img src="/Public/images/performance-icon.png" class="icon">
            <img src="/Public/images/1.png" class="icon-1">
            <span class="off">绩效管理</span>
            <div class="list-1">
                <a href="<?php echo U('Home/Achievements/achievements_record_show');?>"><span class="off">绩效考核</span></a>
            </div>
        </div>
        <div class="list">
            <img src="/Public/images/social-insurance-icon.png" class="icon">
            <img src="/Public/images/1.png" class="icon-1">
            <span class="off">社保管理</span>
            <div class="list-1">
                <a href="<?php echo U('Home/SocialSecurity/socialsecurity_record_show');?>"><span class="off">社保</span></a>
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
<!--考勤记录-->
<div class="main-con">
    <div class="top-panel">
        <span class="tit">绩效考核</span>
        <div class="operate">
            <button class="btn btn-default" data-toggle="modal" data-target="#input-fail">&nbsp;&nbsp;导入&nbsp;&nbsp;</button>&nbsp;&nbsp;
            <button class="btn btn-blue">&nbsp;&nbsp;导出&nbsp;&nbsp;</button>
        </div>
    </div>
    <div class="bottom-panel" style="background-color: #ffffff;padding-top: 20px">
        <div class="tab">
            <table class="table table-responsive" style="border: 1px solid #EEEEEE; min-width: 714px; min-height: 571px">
                <thead>
                <tr style="background:rgba(246,246,246,1);">
                    <th style="width:200px; "><input type="checkbox" class="pull-left" style="margin-right: 10px"><span class="pull-left">序号</span></th>
                    <th>月度</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><input type="checkbox" class="pull-left" style="margin-right: 10px"><span class="pull-left">1</span></td>
                    <td>2018-05</td>
                    <td class="name">导出</td>
                </tr>
                <tr class="select">
                    <td><input type="checkbox" class="pull-left" style="margin-right: 10px" checked><span class="pull-left">2</span></td>
                    <td>2018-05</td>
                    <td class="name">导出</td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="pull-left" style="margin-right: 10px"><span class="pull-left">3</span></td>
                    <td>2018-05</td>
                    <td class="name">导出</td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="pull-left" style="margin-right: 10px"><span class="pull-left">4</span></td>
                    <td>2018-05</td>
                    <td class="name">导出</td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="pull-left" style="margin-right: 10px"><span class="pull-left">5</span></td>
                    <td>2018-05</td>
                    <td class="name">导出</td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="pull-left" style="margin-right: 10px"><span class="pull-left">6</span></td>
                    <td>2018-05</td>
                    <td class="name">导出</td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="pull-left" style="margin-right: 10px"><span class="pull-left">7</span></td>
                    <td>2018-05</td>
                    <td class="name">导出</td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="pull-left" style="margin-right: 10px"><span class="pull-left">8</span></td>
                    <td>2018-05</td>
                    <td class="name">导出</td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="pull-left" style="margin-right: 10px"><span class="pull-left">9</span></td>
                    <td>2018-05</td>
                    <td class="name">导出</td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="pull-left" style="margin-right: 10px"><span class="pull-left">10</span></td>
                    <td>2018-05</td>
                    <td class="name">导出</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="page">
            <div class="left">共44条记录，每页显示&nbsp;
                <select>
                    <option>5</option>
                    <option selected>10</option>
                    <option>20</option>
                </select>&nbsp;条
            </div>
            <div class="right">
                <button class="btn btn-default">上一页</button>&nbsp;
                <button class="btn btn-default">1</button>&nbsp;
                <button class="btn btn-default">2</button>&nbsp;
                <button class="btn current-page">3</button>&nbsp;
                <button class="btn btn-default">4</button>&nbsp;...&nbsp;
                <button class="btn btn-default">98</button>&nbsp;
                <button class="btn">下一页</button>
            </div>
        </div>

    </div>
</div>
<!--</div>-->
<!--导入考勤记录-->
<div class="modal fade" id="input-fail" tabindex="-1" role="dialog" aria-labelledby="failLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <div class="modal-title" id="failLabel">
                    导入考勤记录
                </div>
            </div>
            <div class="body" style="height: 350px">
                <br>
                <div class="list">
                    <div class="left-1" style="width: 25%"><span>月份</span><span style="color: RGBA(255, 0, 0, 1)">*</span></div>
                    <div class="right-1">
                        <input type="text" class="form-control" value="2018-05" placeholder="">
                        <span class="input-group-addon" style="height: 40px; margin: 0; border-left: none;background-color: transparent; border-color: rgba(221,221,221,1)">
                                <span class="glyphicon glyphicon-calendar" style="color:RGBA(204, 204, 204, 1); margin-top:5px"></span>
                            </span>
                    </div>
                </div>
                <div class="select-file">
                    <div class="file-name">
                        <span class="glyphicon glyphicon-exclamation-sign" style="color: #ED5665"></span><span style="margin-left: 5px">开普云2108-05考勤记录.excel</span>
                    </div>
                    <div class="process-detail">
                        <span class="size">大小：255KB </span>
                        <div class="fail-state">
                            <span>导入失败</span>
                        </div>&nbsp;
                        <span class="glyphicon glyphicon-repeat"></span>&nbsp;
                        <span>重新上传</span>
                    </div>
                </div>
                <div class="footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="float: left">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
                    &nbsp;&nbsp;
                    <button type="button" class="btn btn-blue" style="float: right">&nbsp;&nbsp;确定&nbsp;&nbsp;</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--footer start-->
<script src="/Public/resource/echarts.common.min.js"></script>
<script src="/Public/resource/bootstrap/js/bootstrap.min.js"></script>

<script src="/Public/js/common.js"></script>

</body>
</html>
<!--footer end-->