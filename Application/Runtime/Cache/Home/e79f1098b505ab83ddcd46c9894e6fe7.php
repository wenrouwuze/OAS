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
<link rel="stylesheet" href="/Public/resource/treeview/src/css/bootstrap-treeview.css">
<script src="/Public/resource/treeview/src/js/bootstrap-treeview.js"></script>
<!--header end-->
<!--内嵌样式表-->
<style>
    .table-responsive tr:hover{
        background-color: rgba(240,249,255,1);
    }
    .tab{
        overflow: auto;
    }
    #remove_username .form-control,#remove_company .form-control{
        background-color: #e2e2e2;
    }
    .main-con .bottom-panel  .tab .table td.name a{
        color:rgba(0,163,255,1);
        text-decoration: none;
    }
    a:hover{
        text-decoration: none !important;
    }
</style>
<!--花名册 start-->
<div class="main-con">
    <div class="top-panel">
        <span class="tit">员工管理</span>
    </div>
    <div class="bottom-panel">
        <div class="left-panel">
            <div class="title"><span>花名册</span></div>
            <div class="search-input">
                <input type="text" name="" id="" value="" class="inp-srh" placeholder="请输入关键字/部门/姓名"/>
            </div>
            <!--左侧 部门树形结构 start-->
            <!--<div class="list">
                <div class="menu" data-toggle="collapse" data-target="#menu1">
                    <span class="menu1">
                        <span class="glyphicon glyphicon-chevron-right" style="font-size: small;color: #D8D8D8" aria-hidden="true"></span>
                        总裁办公室&nbsp;(4人)
                    </span>
                </div>
                <div class="menu" data-toggle="collapse" data-target="#menu2">
                    <span class="menu1">
                        <span class="glyphicon glyphicon-chevron-right" style="font-size: small;color: #D8D8D8" aria-hidden="true"></span>
                        南方公司&nbsp;(207人)
                    </span>
                </div>
                <div id="menu2" class="collapse in">
                    <div class="menu" data-toggle="collapse" data-target="#menu21">
                        <span class="menu2">
                            <span class="glyphicon glyphicon-chevron-right" style="font-size: small;color: #D8D8D8" aria-hidden="true"></span>
                            广州事业部&nbsp;(53人)
                        </span>
                    </div>
                    <div id="menu21" class="collapse in">
                        <div class="menu">
                            <span class="menu3">售前支出部&nbsp;(2人)</span>
                        </div>
                        <div class="menu">
                            <span class="menu3">销售部&nbsp;(6人)</span>
                        </div>
                        <div class="menu">
                            <span class="menu3">实施服务部&nbsp;(44人)</span>
                        </div>
                    </div>
                    <div class="menu" data-toggle="collapse" data-target="#menu22">
                        <span class="menu2">
                            <span class="glyphicon glyphicon-chevron-right" style="font-size: small;color: #D8D8D8" aria-hidden="true"></span>
                            综合管理部&nbsp;(7人)
                        </span>
                    </div>
                    <div class="menu" data-toggle="collapse" data-target="#menu23">
                        <span class="menu2">
                            <span class="glyphicon glyphicon-chevron-right" style="font-size: small;color: #D8D8D8" aria-hidden="true"></span>
                            云产品事业部&nbsp;(23人)
                        </span>
                    </div>
                </div>
                <div class="menu" data-toggle="collapse" data-target="#menu3">
                    <span class="menu1"><span class="glyphicon glyphicon-chevron-right" style="font-size: small;color: #D8D8D8" aria-hidden="true"></span>
                        北方公司&nbsp;(123人)
                    </span>
                </div>
                <div class="menu" data-toggle="collapse" data-target="#menu4">
                    <span class="menu1"><span class="glyphicon glyphicon-chevron-right" style="font-size: small;color: #D8D8D8" aria-hidden="true"></span>
                        研发中心&nbsp;(84人)
                    </span>
                </div>
            </div>-->
            <!--左侧 部门树形结构 end-->
            <div id="boxtree" class="list"></div>
        </div>
        <div class="right-panel">
            <div class="title">
                <div class="tit1">
                    <a href="<?php echo U('Home/Employee/employee_roster_add');?>"><button type="button"class="btn btn-blue">新增</button></a>&nbsp;&nbsp;
                    <button type="button"class="btn btn-default" onclick="employee_update('1')">信息修改</button>&nbsp;&nbsp;
                    <button type="button"class="btn btn-default" onclick="employee_remove('1')"  id="employee_remove"  >离职操作</button>&nbsp;&nbsp;
                    <input type="radio" id="on" name="workstatus"  value="1" <?php if($employee_status != 4): ?>checked<?php endif; ?>>
                    <label for="on">在职</label>&nbsp;&nbsp;
                    <input type="radio" id="off" name="workstatus" value="4" <?php if($employee_status == 4): ?>checked<?php endif; ?>>
                    <label for="off">离职</label>
                </div>
                <div class="button">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#operate-log">操作日志</button>&nbsp;&nbsp;
                    <!--导入功能存在问题,暂不提供导入功能-->
                    <!-- <button type="button" class="btn btn-default" id="file_upload">导入</button>&nbsp;&nbsp;-->
                    <button type="button" class="btn btn-blue" onclick="window.open('<?php echo U('Home/Employee/employee_roster_export');?>')">导出</button>
                </div>
            </div>
            <div class="tab">
                <table class="table table-responsive" style="border: 1px solid #EEEEEE; min-width: 714px; ">
                    <thead>
                    <tr style="background:rgba(246,246,246,1);">
                        <th><input type="checkbox" class="pull-left">序号</th>
                        <th>姓名</th>
                        <th>性别</th>
                        <th>职位名称</th>
                        <th>手机号码</th>
                        <th>入职时间</th>
                        <th>工号</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <!--<tr class="select" >-->
                    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr>
                            <td><input type="checkbox" class="pull-left" name="em_checkbox"  ><?php echo ($val["em_id"]); ?></td>

                            <td class="name"> <a href="javascript:;" onclick="employee_update('2','<?php echo ($val["em_id"]); ?>')" ><?php echo ($val["em_username"]); ?></a></td>
                            <td>
                                <?php if($val["em_sex"] == 1): ?>男 <?php else: ?> 女<?php endif; ?>
                            </td>
                            <td><?php echo ($val["em_duties"]); ?></td>
                            <td><?php echo ($val["em_mobile"]); ?></td>
                            <td><?php echo (date('Y-m-d',$val["em_createtime"])); ?></td>
                            <td><?php echo ($val["em_worknumber"]); ?></td>
                            <td>
                                <?php if($val["em_workstatus"] != 4): ?><a href="javascript:;" onclick="employee_update('2','<?php echo ($val["em_id"]); ?>')">
                                        <img src="/Public/images/modify.png">
                                    </a>&nbsp;

                                    <img src="/Public/images/remove.png" data-toggle="modal" data-target="#remove" onclick="employee_remove('2','<?php echo ($val["em_id"]); ?>','<?php echo ($val["em_username"]); ?>','<?php echo ($val["em_company"]); ?>')"><?php endif; ?>
                            </td>
                            <td style="display: none;"><?php echo ($val["em_company"]); ?></td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>


                    </tbody>
                </table>
            </div>
            <div class="page" id="page">

            </div>
        </div>
    </div>

</div>
<div class="date-hidden">
    <input type="hidden"  value="<?php echo ($employee_status); ?>" id="em_workstatus_number">
</div>
<!--花名册 end-->

<!--</div>-->

<!--离职操作遮罩层 start-->
<div class="modal fade" id="remove" tabindex="-1" role="dialog" aria-labelledby="removeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <div class="modal-title" id="removeLabel">
                    离职操作
                </div>
            </div>
            <form action="<?php echo U('Home/Employee/employee_roster_remove');?>" method="post" enctype="multipart/form-data">
                <div class="body">
                    <div class="list">
                        <div class="left-1" ><span>姓名</span></div>
                        <div class="right-1" id="remove_username"><input type="text" class="form-control" readonly name="remove_username"></div>
                    </div>
                    <div class="list">
                        <div class="left-1"><span>部门</span></div>
                        <div class="right-1" id="remove_company"><input type="text" class="form-control" readonly name="remove_company"></div>
                    </div>
                    <div class="list">
                        <div class="left-1"><span>最后工作日</span><span style="color: RGBA(255, 0, 0, 1)">*</span></div>
                        <div class="right-1">
                            <input type="text" class="form-control" value="2018-05-11" placeholder="请选择最后工作日" id="worktime_last" name="remove_worktime_last">
                            <span class="input-group-addon" style="height: 40px; margin: 0; border-left: none;background-color: transparent; border-color: rgba(221,221,221,1)">
                                <span class="glyphicon glyphicon-calendar" style="color:RGBA(204, 204, 204, 1); margin-top:5px"></span>
                            </span>
                        </div>
                    </div>
                    <div class="list">
                        <div class="left-1"><span>社保最后缴纳日</span><span style="color: RGBA(255, 0, 0, 1)">*</span></div>
                        <div class="right-1">
                            <input type="text" class="form-control" value="2018-05-11" placeholder="请选择社保最后缴纳日" id="social_insurance_payment_last" name="remove_social_insurance_payment_last">
                            <span class="input-group-addon" style="height: 40px; margin: 0; border-left: none;background-color: transparent; border-color: rgba(221,221,221,1)">
                                <span class="glyphicon glyphicon-calendar" style="color:RGBA(204, 204, 204, 1); margin-top:5px"></span>
                            </span>
                        </div>
                    </div>
                    <div class="list">
                        <div class="left-1"><span>公积金最后缴纳日</span><span style="color: RGBA(255, 0, 0, 1)">*</span></div>
                        <div class="right-1">
                            <input type="text" class="form-control" value="2018-05-11" placeholder="请选择公积金最后缴纳日" id="accumulation_fund_payment_last" name="remove_accumulation_fund_payment_last">
                            <span class="input-group-addon" style="height: 40px; margin: 0; border-left: none;background-color: transparent; border-color: rgba(221,221,221,1)">
                                <span class="glyphicon glyphicon-calendar" style="color:RGBA(204, 204, 204, 1); margin-top:5px"></span>
                            </span>
                        </div>
                    </div>
                    <div class="footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" style="float: left">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
                        &nbsp;&nbsp;
                        <button type="submit" class="btn btn-blue" style="float: right">&nbsp;&nbsp;确定&nbsp;&nbsp;</button>
                    </div>
                </div>
                <input type="hidden" name="remove_id">
            </form>
        </div>
    </div>
</div>
<!--离职操作遮罩层 end-->

<!--操作日志遮罩层 start-->
<div class="modal fade" id="operate-log" tabindex="-1" role="dialog" aria-labelledby="operateLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <div class="modal-title" id="operateLabel">
                    操作日志
                </div>
            </div>
            <div class="body" style="height: 668px">
                <div class="left">
                    <div class="detail">
                        <span>2018-05-15</span>
                    </div>
                    <div class="detail"></div>
                    <div class="detail"></div>
                    <div class="detail"></div>
                    <div class="detail">
                        <span>2018-05-16</span>
                    </div>
                    <div class="detail"></div>
                </div>
                <div class="img">
                    <img src="/Public/images/timeline.png">
                </div>
                <div class="right">
                    <div class="detail">
                        <div class="time">
                            <span>14：32</span>
                        </div>
                        <div class="data">
                            <span>王五的“工资卡号”修改为“112221”</span>
                            <span>变更人：张三</span>
                        </div>
                    </div>
                    <div class="detail">
                        <div class="time">
                            <span>13：11</span>
                        </div>
                        <div class="data">
                            <span>王五“籍贯”修改为“河南郑州” </span>
                            <span>变更人：张三</span>
                        </div>
                    </div>
                    <div class="detail">
                        <div class="time">
                            <span>13：11</span>
                        </div>
                        <div class="data">
                            <span>王五“籍贯”修改为“河南郑州” </span>
                            <span>变更人：张三</span>
                        </div>
                    </div>
                    <div class="detail">
                        <div class="time">
                            <span>13：02</span>
                        </div>
                        <div class="data">
                            <span>王五的“工资卡号”修改为“112221” </span>
                            <span>变更人：张三</span>
                        </div>
                    </div>
                    <div class="detail">
                        <div class="time">
                            <span>11：30</span>
                        </div>
                        <div class="data">
                            <span>王五“籍贯”修改为“河南郑州” </span>
                            <span>变更人：张三</span>
                        </div>
                    </div>
                    <div class="detail">
                        <div class="time">
                            <span>11：11</span>
                        </div>
                        <div class="data">
                            <span>王五的“工资卡号”修改为“112221” </span>
                            <span>变更人：张三</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--操作日志遮罩层 end-->

<!--footer start-->
<script src="/Public/resource/echarts.common.min.js"></script>
<script src="/Public/resource/bootstrap/js/bootstrap.min.js"></script>

<script src="/Public/js/common.js"></script>

</body>
</html>
<!--footer end-->
<script>
    /*时间插件*/
    layui.use('laydate', function(){
        var laydate = layui.laydate;

        /*最后工作时间*/
        laydate.render({
            elem: '#worktime_last'
        });
        /*社保最后缴纳时间*/
        laydate.render({
            elem: '#social_insurance_payment_last'
        });
        /*公积金最后缴纳时间*/
        laydate.render({
            elem: '#accumulation_fund_payment_last'
        });
    });



    /*分页*/
    layui.use('laypage', function(){
        var laypage = layui.laypage;

        //执行一个laypage实例
        laypage.render({
            elem: 'page' //注意，这里的 test1 是 ID，不用加 # 号
            ,count: '<?php echo ($count); ?>' //数据总数，从服务端得到
            ,layout: ['count',  'limit','prev', 'page', 'next']
            ,limits: [5,10] //number/页
            ,curr:'<?php echo ($curr); ?>'
            ,limit:'<?php echo ($limits); ?>'
            ,groups:'3'
            ,jump: function(obj,first){
                if(!first){
                    var Request = new Object();
                    //获取排序参数
                    Request = GetRequest();
                    if(Request.employee_status){
                        var url = "<?php echo U('Home/Employee'/employeeShow);?>?p="+obj.curr+'&limit='+obj.limit+'&employee_status='+Request.employee_status;
                    }else{
                        var url = "<?php echo U('Home/Employee'/employeeShow);?>?p="+obj.curr+'&limit='+obj.limit;
                    }

                    window.location.href = url;
                }
            }
        });
    });

    /*员工状态查询*/
    $("input[name='workstatus']").on('click',function(){
        var url = "<?php echo U('Home/Employee/employee_roster_show');?>?employee_status="+$(this).val();
        window.location.href = url;
    })

    //获取url参数1
    function GetRequest() {
        var url = location.search; //获取url中"?"符后的字串
        var theRequest = new Object();
        if (url.indexOf("?") != -1) {
            var str = url.substr(1);
            strs = str.split("&");
            for(var i = 0; i < strs.length; i ++) {
                theRequest[strs[i].split("=")[0]] = unescape(strs[i].split("=")[1]);
            }
        }
        return theRequest;
    }

    /*离职操作*/
    function employee_remove(position,id,username,company) {
        /*离职员工禁止做任何操作*/
        var workstatus = $("#em_workstatus_number").val();
        if(workstatus == '4'){
            message('该员工已离职');
            return false;
        }
        if(position =='1' || position == '2'){
            if(position == '1'){
                var number =  $(".tab table").find("input:checkbox[name='em_checkbox']:checked").length;
                if(number>1){
                    message('请不要多选');
                    return  false;
                }
                var id = $(".tab table").find("input:checkbox[name='em_checkbox']:checked").parent().text();
                if(!id){
                    message('请选择一个员工');
                    return  false;
                }
                var username = $(".tab table").find("input:checkbox[name='em_checkbox']:checked").parent().parent().children().eq(1).text();
                var company = $(".tab table").find("input:checkbox[name='em_checkbox']:checked").parent().parent().children().last().html();
            }
            $("#remove_username input").val(username);
            $("#remove_company input").val(company);
            $("input[name='remove_id']").val(id);
            $('#employee_remove').attr('data-target','#remove');
            $('#employee_remove').attr('data-toggle','modal');
        }else{
            return false;
        }
    }

    /*编辑操作*/
    function employee_update(position,id){
        var url = "<?php echo U('Home/Employee/employee_roster_edit');?>";
        if(position =='1' || position == '2'){
            if(position == '1'){
                var number =  $(".tab table").find("input:checkbox[name='em_checkbox']:checked").length;
                /*用户多选*/
                if(number>1){
                    message('请不要多选');
                    return  false;
                }
                /*用户未选择要修改的员工*/
                id = $(".tab table").find("input:checkbox[name='em_checkbox']:checked").parent().text();
                if(!id){
                    message('请选择一个员工');
                    return  false;
                }
            }
            /*离职员工禁止做任何操作*/
            var workstatus = $("#em_workstatus_number").val();
            if(workstatus == '4'){
                message('该员工已离职');
                return false;
            }

            window.location.href = url + '?em_id=' + id
        }else{
            return false;
        }

    }

    /*树形结构*/
    $(function(){

        var defaultData = <?php echo ($departmenttree); ?> ;
        $('#boxtree').treeview({
            expandIcon: 'glyphicon glyphicon-chevron-right',
            collapseIcon: 'glyphicon glyphicon-chevron-down',
            //nodeIcon: 'glyphicon glyphicon-bookmark',   //设置所有列表树节点上的默认图标。
            emptyIcon: "glyphicon glyphicon-chevron-right",
            levels:'1',
            data: defaultData
        });
    });

</script>
<script type="text/javascript">
    /*员工管理-花名册-上传文件*/
    layui.use('upload', function(){
        var upload = layui.upload;

        //执行实例
        var uploadInst = upload.render({
            elem: '#file_upload' //绑定元素
            ,url: "<?php echo U('Home/Employee/employee_upload');?>" //上传接口
            ,accept:'file'      //允许上传的类型
            ,done: function(res){
                if(res.status == 'success'){
                    layer.msg('上传成功');
                }
            }
            ,error:function (res) {
                layer.msg('上传失败,请联系管理员');
            }

        });
    });
</script>