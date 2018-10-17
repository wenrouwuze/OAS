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
<style>
    .tab table tr:hover {
        background-color: rgba(240, 249, 255, 1);
    }

    .tab table tr td a {
        color: rgba(0, 163, 255, 1);
        text-decoration: none;
    }
</style>
<!--考勤记录-->
<div class="main-con">
    <div class="top-panel">
        <span class="tit">社保记录</span>
        <div class="operate">
            <button class="btn btn-default import_button" data-toggle="modal" data-target="#input-fail">&nbsp;&nbsp;导入&nbsp;&nbsp;</button>&nbsp;&nbsp;
            <button class="btn btn-blue"
                    onclick="window.open('<?php echo U('Home/SocialSecurity/socialsecurity_record_export');?>?times=all')">&nbsp;&nbsp;导出&nbsp;&nbsp;
            </button>
        </div>
    </div>
    <div class="bottom-panel" style="background-color: #ffffff;padding-top: 20px">
        <div class="tab">
            <table class="table table-responsive" style="border: 1px solid #EEEEEE; min-width: 714px; ">
                <thead>
                <tr style="background:rgba(246,246,246,1);">
                    <th style="width:200px; "><input type="checkbox" class="pull-left" style="margin-right: 10px"><span
                            class="pull-left">序号</span></th>
                    <th>月度</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>

                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr>
                        <td><input type="checkbox" class="pull-left" style="margin-right: 10px"><span class="pull-left">1</span>
                        </td>
                        <td><?php echo ($val["s_month"]); ?></td>
                        <td class="name"><a href="javascript:;"
                                            onclick="window.open('<?php echo U('Home/SocialSecurity/socialsecurity_record_export');?>?times=<?php echo ($val["s_month"]); ?>')">导出</a>
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
<!--</div>-->
<!--导入考勤记录-->
<div class="modal fade" id="input-fail" tabindex="-1" role="dialog" aria-labelledby="failLabel" aria-hidden="true">
    <div class="shade">
        <div class="modal-dialog mymodal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <div class="modal-title" id="inputLabel">
                        导入考勤记录
                    </div>
                </div>
                <div class="body" style="height: 350px">
                    <br>
                    <div class="list">
                        <div class="left-1" style="width: 25%"><span>月份</span><span
                                style="color: RGBA(255, 0, 0, 1)">*</span></div>
                        <div class="right-1">
                            <input type="text" class="form-control" id="importdate" value="201808" name="times">

                            <span class="input-group-addon"
                                  style="height: 40px; margin: 0; border-left: none;background-color: transparent; border-color: rgba(221,221,221,1)"
                                  id="calendar">
                            <span class="glyphicon glyphicon-calendar"
                                  style="color:RGBA(204, 204, 204, 1); margin-top:5px"></span>
                        </span>
                        </div>
                    </div>
                    <div class="select-file">
                        <div class="select">
                            <butbton type="button" class="btn btn-blue" id="button_import">选择文件</butbton>
                        </div>
                        <div class="layui-progress" lay-showpercent="true" lay-filter="progressBar">
                            <div class="layui-progress-bar layui-bg-red" lay-percent="0%"></div>
                        </div>
                    </div>
                    <div class="footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" style="float: left">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
                        &nbsp;&nbsp;
                        <button type="button" class="btn btn-blue" style="float: right" id="uploadBtn">&nbsp;&nbsp;确定&nbsp;&nbsp;</button>
                    </div>
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
<!--此处引用必须放在时间插件的上面,以防不必要的错误-->
<script src="/Public/resource/layui/layui.all.js"></script>

<!--时间插件-->
<script type="text/javascript">
    /*时间插件*/
    layui.use('laydate', function () {
        var laydate = layui.laydate;
        /*导入时间*/
        laydate.render({
            elem: '#importdate',
            type: 'month',
            format: 'yyyy-MM',

        });
    });
</script>
<!--上传插件以及进度条-->
<script type="text/javascript">
    var upload = layui.upload,
        element = layui.element;
    element.init();
    upload.render({
        elem: '#button_import', // 文件选择
        accept: 'file',
        url: "<?php echo U('Home/SocialSecurity/socialsecurity_record_upload');?>",
        data: {
            t: function () {
                return $("input[name='times']").val();
            }
        },
        auto: false, // 设置不自动提交
        bindAction: '#uploadBtn', // 提交按钮
        progress: function (e, percent) {
            console.log("进度：" + percent + '%');
            element.progress('progressBar', percent + '%');

        },
        choose: function (obj) {
            obj.preview(function (index, file, result) {
                $("#fileName").html(file.name);
            });
        },
        done: function (res) {
            //layer.msg(res.msg);
            layer.msg(res.describe);
            window.location.href = "<?php echo U('Home/SocialSecurity/socialsecurity_record_show');?>";
        },
        error: function (res) {
            //layer.msg(res.msg);
            console.log(res);
            layer.msg(res)
        }
    });
</script>
<!--分页插件-->
<script type="text/javascript">
    /*分页*/
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
                        var url = "<?php echo U('Home/SocialSecurity/socialsecurity_record_show');?>?p=" + obj.curr + '&limit=' + obj.limit + '&employee_status=' + Request.employee_status;
                    } else {
                        var url = "<?php echo U('Home/SocialSecurity/socialsecurity_record_show');?>?p=" + obj.curr + '&limit=' + obj.limit;
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