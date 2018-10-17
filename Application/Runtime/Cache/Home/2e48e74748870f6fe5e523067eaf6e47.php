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
<!--style start-->
<style>
    .btn-blue{
        background-color: #15A1EF;
        color: #ffffff;
    }
    .main-con .bottom-panel .tit .tit1{
        width: auto;
        height: auto;
        margin-top: 16px;
        margin-left: 3%;
        float: left;
    }
    .main-con .bottom-panel .tit{
        width: 100%;
        height: 62px;
        /*height: 8%;*/
        border-bottom: 1px solid rgba(238,238,238,1);
    }
    .tab table tr:hover {
        background-color: rgba(240, 249, 255, 1);
    }

    .tab table tr td a {
        color: rgba(0, 163, 255, 1);
        text-decoration: none;
    }
    .tab table tr td span:hover{
        cursor:pointer
    }
</style>
<!--style end-->
<!--工资条-->
<div class="main-con">
    <div class="top-panel">
        <span class="tit">工资条</span>
    </div>
    <div class="bottom-panel" style="background-color: #ffffff;">
        <div class="tit">
            <div class="tit1">
                <span>工资月份</span>&nbsp;&nbsp;

                <input type="text" id="wage_months" class="inp-srh" value="2018-08">
                <button type="button"class="btn btn-blue" id="wage_create">生成工资表</button>&nbsp;&nbsp;
            </div>
        </div>
        <div class="tab" style="margin-top: 20px">
            <table class="table table-responsive" style="border: 1px solid #EEEEEE; min-width: 714px; ">
                <thead>
                <tr style="background:rgba(246,246,246,1);">
                    <th style="width:200px; "><input type="checkbox" class="pull-left" style="margin-right: 10px"><span class="pull-left">序号</span></th>
                    <th>月度</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr>
                        <td><input type="checkbox" class="pull-left" style="margin-right: 10px"><span class="pull-left">1</span></td>
                        <td><?php echo ($val["s_month"]); ?></td>
                        <td class="name">
                            <span onclick="window.open('<?php echo U('/Home/Pay/pay_rocard_download');?>?timestamp=<?php echo ($val["s_month"]); ?>')">导出</span>
                            <span class="test" lay-data="{url:'<?php echo U('/Home/Pay/pay_rocard_upload');?>?timestamp=<?php echo ($val["s_month"]); ?>'}">导入</span>
                            <span id="email_send" onclick="email_send('<?php echo ($val["s_month"]); ?>');">一键发送工资条</span>
                        </td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                </tbody>
            </table>
        </div>
        <div class="page" id="page">

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
<!--上传文件-->
<script type="text/javascript">
    layui.use('upload', function(){
        var upload = layui.upload;

        //执行实例
        var uploadInst = upload.render({
            elem: '.test' //绑定元素
            ,accept:"file"
            ,done: function(res){

                layer.msg(res.describe);
            }
            ,error: function(){
                //请求异常回调
            }
        });
    });
</script>
<!--分页-->
<script type="text/javascript">
    layui.use('laypage', function () {
        var laypage = layui.laypage;

        //执行一个laypage实例
        laypage.render({
            elem: 'page' //注意，这里的 test1 是 ID，不用加 # 号
            , count: '<?php echo ($count); ?>' //数据总数，从服务端得到
            , layout: ['count', 'limit', 'prev', 'page', 'next']
            , limits: [5, 10] //number/页
            , curr: '<?php echo ($curr); ?>'
            , limit: '<?php echo ($limits); ?>'
            , groups: '3'
            , jump: function (obj, first) {
                if (!first) {
                    var Request = new Object();
                    //获取排序参数
                    Request = GetRequest();
                    if (Request.employee_status) {
                        var url = "<?php echo U('Home/Pay/payroll');?>?p=" + obj.curr + '&limit=' + obj.limit + '&employee_status=' + Request.employee_status;
                    } else {
                        var url = "<?php echo U('Home/Pay/payroll');?>?p=" + obj.curr + '&limit=' + obj.limit;
                    }

                    window.location.href = url;
                }
            }
        });
    });
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
</script>
<!--发送邮件操作-->
<script type="text/javascript">
    function email_send(timestamp){
        /*检测是否拿到对应日期*/
        if(!timestamp){
            message('未拿到对应日期,请联系开发人员');
            return false;
        }else{
            /*发送邮件地址*/
            var send_url = "<?php echo U('/Home/Pay/pay_recard_email_send');?>";
            $.ajax({
                type: "POST",
                url: send_url,
                data: {'timestamp':timestamp},
                async:true,
                beforeSend:function(){
                   message('邮件发送中');
                },
                success: function(msg){
                    //console.log('邮件已发送');
                }
                ,error:function(){
                    //console.log('邮件发送失败');
                }
            });
        }
    }
</script>
<!--时间插件-->
<script type="text/javascript">
    layui.use('laydate', function(){
        var laydate = layui.laydate;
        /*工资月份*/
        laydate.render({
            elem: '#wage_months'
            ,type:'month'

        });
    });
</script>
<!--生成工资表-->
<script type="text/javascript">
    $("#wage_create").on('click',function(){
        var timestamp = $('#wage_months').val();
        if(!timestamp){
            message('请选择日期');
            return false;
        }
        var create_url = "<?php echo U('/Home/Pay/pay_recard_wage_create');?>";
        $.ajax({
            type: "POST",
            url: create_url,
            data: {'timestamp':timestamp},
            async:true,
            beforeSend:function(){
                message('工资表生成中,请稍等',['200px','50px']);
            },
            success: function(msg){

                message('工资表已生成');
                window.location.reload();
            }
            ,error:function(){
                message('工资表生成失败,请联系管理员');
            }
        });

    });
</script>