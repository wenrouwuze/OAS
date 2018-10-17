<?php if (!defined('THINK_PATH')) exit();?>
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
<style>
    a:hover{
        text-decoration: none !important;
    }
</style>
<!--Main/Index start-->
<div class="main-con">
    <div class="main-top">
        <div class="fun">
            <a href="<?php echo U('Home/Organize/Organize_recard_show');?>">
                <div class="blue-circle">
                    <img src="/Public/images/structure.png">
                </div>
                <div class="char">组织架构</div>
                <div class="blue-l"></div>
                <div class="des">组织架构维护及架构图查看</div>
            </a>
        </div>
        <div class="fun">
            <a href="<?php echo U('Home/Attendance/attendance_record_show');?>">
                <div class="blue-circle">
                    <img src="/Public/images/attendance.png">
                </div>
                <div class="char">考勤管理</div>
                <div class="blue-l"></div>
                <div class="des">员工加班、请假、出差等管理</div>
            </a>
        </div>
        <div class="fun">
            <a href="<?php echo U('Home/Employee/employee_roster_show');?>">
                <div class="blue-circle">
                    <img src="/Public/images/roster.png">
                </div>
                <div class="char">花名册</div>
                <div class="blue-l"></div>
                <div class="des">员工花名册信息及入、转、调、离管理</div>
            </a>
        </div>
        <div class="fun">
            <a href="<?php echo U('Home/Pay/payroll');?>">
                <div class="blue-circle">
                    <img src="/Public/images/salary.png">
                </div>
                <div class="char">工资表</div>
                <div class="blue-l"></div>
                <div class="des">工资表整理与工资条发放</div>
            </a>
        </div>
    </div>
    <div class="main-bottom">
        <div class="chart-view">
            <div class="nav-box">
                <ul>
                    <li class="on" id="employee_change">人员变动</li>
                    <li class="off" id="number_of_department">部门人数</li>
                    <li class="off" id="number_of_incumbency">在职人数</li>
                </ul>
            </div>

            <!--柱形图-人员变动-->
            <div class="chart" id="showChart_employee_change"></div>
            <!--饼图-部门人数-->
            <div class="chart" id="showChart_number_of_department" ></div>
            <!--折线图-在职人数-->
            <div class="chart" id="showChart_number_of_incumbency" ></div>

        </div>
        <div class="detail-panel">
            <div class="detail">
                <a href="<?php echo U('Home/Main/main_employee_birthday');?>">
                    <div class="circle">
                        <img src="/Public/images/2.png">
                    </div>
                    <div class="det">
                        <span class="char-1">本月生日的员工</span>
                        <span class="num-1"><?php echo ($employee_birthday); ?></span>
                        <span class="form-1">人</span>
                    </div>
                </a>
            </div>
            <div class="detail">
                <a href="<?php echo U('Home/Main/main_employee_formal_half_a_month');?>">
                    <div class="circle">
                        <img src="/Public/images/3.png">
                    </div>
                    <div class="det">
                        <span class="char-1">半个月内转正的员工</span>
                        <span class="num-1"><?php echo ($employee_formal); ?></span>
                        <span class="form-1">人</span>
                    </div>
                </a>
            </div>
            <div class="detail">
                <a href="<?php echo U('Home/Main/main_employee_end');?>">
                    <div class="circle">
                        <img src="/Public/images/4.png">
                    </div>
                    <div class="det">
                        <span class="char-1">两个月内合同到期</span>
                        <span class="num-1"><?php echo ($employee_end); ?></span>
                        <span class="form-1">人</span>
                    </div>
                </a>
            </div>
            <div class="detail">
                <a href="<?php echo U('Home/Main/main_employee_check');?>">
                    <div class="circle">
                        <img src="/Public/images/5.png">
                    </div>
                    <div class="det">
                        <span class="char-1">员工信息等待审核</span>
                        <span class="num-1"><?php echo ($employee_waitcheck); ?></span>
                        <span class="form-1">人</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<!--Main/Index end-->

<!--</div>-->

<!--footer start-->
<script src="/Public/resource/echarts.common.min.js"></script>
<script src="/Public/resource/bootstrap/js/bootstrap.min.js"></script>

<script src="/Public/js/common.js"></script>

</body>
</html>
<!--footer end-->
<script src="/Public/js/01-1.js"></script>
<script src="/Public/js/01-2.js"></script>
<script src="/Public/js/01-3.js"></script>
<script>

    $(function () {
        $('.chart').not(':first').css('display','none'); //隐藏其他图表，只显示人员变动
        $('.chart-view .nav-box ul li').on('click',function () {
            $(this).attr('class','on').siblings().attr('class','off');
            var divbox_id = $(this).attr('id');
            if(divbox_id == 'employee_change'){
                $('#showChart_employee_change').css('display','block');
                $('#showChart_number_of_department').css('display','none');
                $('#showChart_number_of_incumbency').css('display','none');

            }else if(divbox_id == 'number_of_department'){
                $('#showChart_employee_change').css('display','none');
                $('#showChart_number_of_department').css('display','block');
                $('#showChart_number_of_incumbency').css('display','none');
            }else if(divbox_id == 'number_of_incumbency'){
                $('#showChart_employee_change').css('display','none');
                $('#showChart_number_of_department').css('display','none');
                $('#showChart_number_of_incumbency').css('display','block');
            }else{
                return false;
            }
        });
    });
</script>