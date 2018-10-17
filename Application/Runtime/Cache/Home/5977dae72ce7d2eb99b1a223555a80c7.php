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
<!--header end-->
<!--员工新增 start-->


<style>
    .list-con {
        height: 1375px;
    }

    .disabled {
        background-color: #e2e2e2;
    }

    .educationalinfo, .wageinfo {
        display: none;
    }
</style>
<div class="main-con" style="height: 1374px">
    <div class="top-panel">
        <span class="tit">员工管理</span>
    </div>
    <div class="bottom-panel" style="background-color: #ffffff; height: 1266px">
        <div class="tit-1">
            <a href="<?php echo U('Home/Employee/employee_roster_show');?>">
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
        <form action="<?php echo U('Home/Employee/employee_roster_addpro');?>" method="post" enctype="multipart/form-data"
              onsubmit="return checkforms()">
            <!--基本信息 start-->
            <div class="baseinfo">
                <div class="list-tit">个人资料</div>
                <div class="list-detail" style="height: 460px">
                    <div class="info" style="height: 450px">
                        <span>姓名：&nbsp;<input type="text" name="em_username"></span>
                        <span>出生年月：&nbsp;<input type="text" name="em_birthday" id="em_birthday" class="disabled"
                                                id="em_birthday" placeholder="无需填写，系统会自动生成" readonly></span>
                        <span>民族：&nbsp;
                                <select name="em_nation">
                                   <?php if(is_array($nation)): $i = 0; $__LIST__ = $nation;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val); ?>"><?php echo ($val); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </span>
                        <span>手机号码：&nbsp;<input type="text" name="em_mobile"></span>
                        <span>邮箱：&nbsp;<input type="text" name="em_email"></span>
                        <span>籍贯：&nbsp;<input type="text" name="em_province"></span>
                        <span>户口所在地：&nbsp;<input type="text" name="em_register_place"></span>
                        <span>婚姻状况：&nbsp;
                                <select name="em_marital_status">
                                    <option value='1' selected="selected">未婚</option>
                                    <option value='2'>已婚</option>
                                    <option value='3'>离异</option>
                                    <option value='4'>丧偶</option>
                                </select>
                            </span>
                        <span>孩子出生年月：&nbsp;<input type="text" name="em_baby_birthday" id="em_babybirthday" autocomplete="off"></span>
                    </div>
                    <div class="info" style="height: 450px">
                            <span>性别：&nbsp;<input type="text" class="disabled" placeholder="无需填写，系统会自动生成" name="em_sex" readonly="readonly">
                                <!--  <select name="em_sex">
                                      <option value='1' selected='selected'>男</option>
                                      <option value='2'>女</option>
                                  </select>-->
                            </span>
                        <span>年龄：&nbsp;<input type="text" name="em_age" min="1" class="disabled"
                                              placeholder="无需填写，系统会自动生成" readonly="readonly"></span>
                        <span>政治面貌：&nbsp;
                                <select name="em_political_face">
                                  <?php if(is_array($political)): $i = 0; $__LIST__ = $political;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val); ?>"><?php echo ($val); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </span>
                        <span>身份证号：&nbsp;<input type="text" name="em_idcard" id="em_idcard"></span>
                        <span>微信号：&nbsp;<input type="text" name="em_wxnumber"></span>
                        <span>户口类型：&nbsp;
                                <select name="em_registerplace_type">
                                    <option value='1' selected>城镇</option>
                                    <option value='2'>农村</option>
                                </select>
                            </span>
                        <span>现住址：&nbsp;<input type="text" name="em_addressnow"></span>
                        <span>生育状况：&nbsp;
                                <select name="em_reproductive_status">
                                    <option value='1'>已育</option>
                                    <option value='2' selected="selected">未育</option>
                                </select>
                            </span>
                    </div>
                </div>
                <div class="list-tit">基本情况</div>
                <div class="list-detail" style="height: 400px">
                    <div class="info" style="height: 350px">
                        <span>工号：&nbsp;<input type="text" name="em_worknumber" readonly="readonly" placeholder="无需填写，系统会自动生成"
                                              class="disabled"></span>
                        <span>工作地区：&nbsp;<input type="text" name="em_workplace"></span>
                        <span>职务：&nbsp;<input type="text" name="em_duties"></span>
                        <span>直属领导：&nbsp;<input type="text" name="em_firstleader"></span>
                        <span>入职时间：&nbsp;<input type="text" name="em_createtime" id="em_createtime" autocomplete="off"></span>
                        <span>转正时间：&nbsp;<input type="text" name="em_formaltime" id="em_formaltime"
                                                placeholder="无需填写，系统会自动生成" readonly="readonly"></span>
                        <span>续签次数：&nbsp;<input type="number" name="em_renew" value="0" min="0"></span>
                    </div>
                    <div class="info" style="height: 350px">
                            <span>状态：&nbsp;
                                <select name="em_workstatus">
                                    <option value='1' selected="selected">试用期</option>
                                    <option value='2'>实习</option>
                                    <option value='3'>正式</option>
                                    <option value='4'>离职</option>

                                </select>
                            </span>
                        <span>所属公司：&nbsp;
                                <select name="em_company">
                                   <?php if(is_array($company)): $i = 0; $__LIST__ = $company;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val); ?>"><?php echo ($val); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </span>
                        <span>一级部门：&nbsp;
                                <select name="em_department_first" id="em_department_first">
                                    <option value="null">请选择</option>

                                </select>
                            </span>
                        <span>二级部门：&nbsp;
                                <select name="em_department_second" id="em_department_second">
                                    <option value="null">请选择</option>
                                </select>
                            </span>
                        <span>三级部门：&nbsp; <select name="em_department_third" id="em_department_third">
                                    <option value="null">请选择</option>
                                </select>
                            </span>
                        <span>合同到期时间：&nbsp;<input type="text" name="em_endtime" id="em_endtime" autocomplete="off"></span>
                        <span>司龄：&nbsp;<input type="text" name="em_workage" readonly min="0" class="disabled"
                                              placeholder="无需填写，系统会自动生成" ></span>
                    </div>
                </div>


            </div>
            <!--基本信息 end-->

            <!--教育信息 start-->
            <div class="educationalinfo">
                <div class="list-tit">教育背景</div>
                <div class="list-detail" style="height: 200px">
                    <div class="info" style="height: 190px">
                        <span>毕业学校：&nbsp;<input type="text" name="em_graduateschool"></span>
                        <span>专业：&nbsp;<input type="text" name="em_major"></span>
                        <span>职称：&nbsp;<input type="text" name="em_professional_title"></span>
                    </div>
                    <div class="info" style="height: 190px">
                        <span>毕业时间：&nbsp;<input type="text" name="em_graduatetime" id="em_graduatetime"></span>
                        <span>文化程度：&nbsp;
                                <select name="em_degreeofeducation">
                                    <option value="博士">博士</option>
                                    <option value="硕士">硕士</option>
                                    <option value="本科">本科</option>
                                    <option value="大专">大专</option>
                                    <option value="中专">中专</option>
                                </select>
                            </span>
                        <span>资质证书：&nbsp;<input type="text" name="em_qualificationCertificate"></span>
                    </div>
                </div>
            </div>
            <!--工资信息 end-->
            <div class="wageinfo">
                <div class="list-tit">工资信息</div>
                <div class="list-detail" style="height: 360px">
                    <div class="info" style="height: 350px">
                        <span>工资卡号：&nbsp;<input type="text" name="em_banknumber"></span>
                        <span>金蝶核算口径（薪资）：&nbsp;
                                <select name="em_kingdee">
                                    <?php if(is_array($kingdee)): $i = 0; $__LIST__ = $kingdee;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val); ?>-<?php echo ($key); ?>"><?php echo ($val); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </span>
                        <span>岗位费用金蝶归属部门：&nbsp;
                                <select name="em_kingdeedepartment">
                                    <?php if(is_array($kingdeedepartment)): $i = 0; $__LIST__ = $kingdeedepartment;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val); ?>-<?php echo ($key); ?>"><?php echo ($val); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </span>
                        <span>电脑补助：&nbsp;<input type="text" name="em_computersubsidy"></span>
                        <span>技术补助：&nbsp;<input type="text" name="em_skillsubsidy"></span>
                        <span>基本工资：&nbsp;<input type="text" name="em_basewage"></span>
                        <span>标准绩效工资：&nbsp;<input type="text" name="em_standard_performance_wage"></span>
                    </div>
                    <div class="info" style="height: 350px">
                            <span>银行：&nbsp;
                                <select name="em_bankname">
                                    <?php if(is_array($bank)): $i = 0; $__LIST__ = $bank;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val); ?>"><?php echo ($val); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </span>
                        <span>薪资归属：&nbsp;
                                <select name="em_wageascription">
                                    <?php if(is_array($wageAscription)): $i = 0; $__LIST__ = $wageAscription;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val); ?>"><?php echo ($val); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </span>
                        <span>通讯补助：&nbsp;<input type="text" name="em_telsubsidy"></span>
                        <span>交通补助：&nbsp;<input type="text" name="em_tracfficsidy"></span>
                        <span>工资：&nbsp;<input type="text" name="em_wage"></span>
                        <span>职位工资：&nbsp;<input type="text" name="em_positionwage"></span>
                    </div>
                </div>
            </div>
            <!--教育信息 end-->
            <div class="button">
                <button type="reset" class="btn btn-default" style="width: 80px">取消</button>
                <button type="submit" class="btn btn-blue pull-right" style="width: 80px">保存</button>
            </div>
        </form>
    </div>
</div>
<input type="hidden" value="<?php echo ($worknumber); ?>" id="hiddenworknumber">
<!--员工新增 end-->
<!--</div>-->

<!--footer start-->
<script src="/Public/resource/echarts.common.min.js"></script>
<script src="/Public/resource/bootstrap/js/bootstrap.min.js"></script>

<script src="/Public/js/common.js"></script>

</body>
</html>
<!--footer end-->

<script type="text/javascript">
    var worknumber = $('#hiddenworknumber').val();
    /*时间插件*/
    layui.use('laydate', function () {
        var laydate = layui.laydate;
        /*入职时间*/
        laydate.render({
            elem: '#em_createtime' //
            , done: function (value, date, endDate) {
                /*工号*/
                $("input[name='em_worknumber']").val(date.year + '' + (date.month >= 10 ? date.month : '0' + date.month) + worknumber);
                /*转正时间*/
                var formaltime = date.month + 3 >= 10 ? date.month + 3 : 0 + '' + (date.month + 3);

                $("input[name='em_formaltime']").val(date.year + '-' + formaltime + '-' + date.date);
                /*司龄*/
                var mydate = new Date();
                var workage = mydate.getMonth() + 1 - date.month;
                $("input[name='em_workage']").val(workage);

            }
        });
        /*转正时间*/
        laydate.render({
            elem: '#em_formaltime',
        });
        /*合同到期年月*/
        laydate.render({
            elem: '#em_endtime',
        });
        /*孩子出生年月*/
        laydate.render({
            elem: '#em_babybirthday',
        });
        /*毕业时间*/
        laydate.render({
            elem: '#em_graduatetime',
        });
    });

    /*其他计算*/
    $(function () {
        /*身份证相关计算*/
        $('#em_idcard').bind('input propertychange', function () {
            if (this.value.length >= 18) {
                /*获取出生年月*/
                var birthday = this.value.substring(6, 10) + "-" + this.value.substring(10, 12) + "-" + this.value.substring(12, 14);
                /*获取性别*/
                var sex = parseInt(this.value.substr(16, 1)) % 2 == 1 ? '男' : '女';
                /*获取年龄*/
                var myDate = new Date();
                var month = myDate.getMonth() + 1;
                var day = myDate.getDate();
                var age = myDate.getFullYear() - this.value.substring(6, 10) - 1;
                if (this.value.substring(10, 12) < month || this.value.substring(10, 12) == month && this.value.substring(12, 14) <= day) {
                    age++;
                }
                $("input[name='em_sex']").val(sex);
                $("input[name='em_birthday']").val(birthday);
                $("input[name='em_age']").val(age);

            } else {
                return false;
            }

        });
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
        /*部门三级联动*/
        $('#em_department_first').on('change', function () {
            var lastId = $(this).val();
            var url = "<?php echo U('Home/Employee/departmentdata');?>";
            $.post(url, {'parents': lastId}, function (data) {
                if (data) {
                    $("#em_department_second").append(data);
                }
            });
        });
        $('#em_department_second').on('change', function () {
            var lastId = $(this).val();
            var url = "<?php echo U('Home/Employee/departmentdata');?>";
            $.post(url, {'parents': lastId}, function (data) {
                if (data) {
                    $("#em_department_third").append(data);
                }
            });
        });
    });


    /*部门三级联动*/
    var department = <?php echo ($departmentdata); ?>;
    var str = "";
    $.each(department, function (k, p) {
        str += "<option value='"+k+"-"+p.department_id+"'>"+p.text+"</option>"
    });

    /*追加一级部门*/
    $("#em_department_first").append(str);
    str = '';
    /*追加二级部门*/
    $('#em_department_first').on('change', function () {
        var index_first = $("#em_department_first option:selected").val().split('-')[0];
        $.each(department[index_first].nodes, function (k, p) {
            str += "<option value='"+k+"-"+p.department_id+"'>"+p.text+"</option>"
        });
        $("#em_department_second").html("<option value='null'>请选择</option>");
        $("#em_department_second").append(str);
        str = '';
    });
    /*追加三级部门*/
    $('#em_department_second').on('change', function () {
        var index_first = $("#em_department_first option:selected").val().split('-')[0];
        var index_second = $("#em_department_second option:selected").val().split('-')[0];

        $.each(department[index_first].nodes[index_second].nodes, function (k, p) {
            str += "<option value='"+k+"-"+p.department_id+"'>"+p.text+"</option>"
        });
        $("#em_department_third").append(str);
    });


    function checkforms() {
        if ($("input[name='em_username']").val() == '') {
            message('请填写姓名');
            return false;
        }
    }

</script>