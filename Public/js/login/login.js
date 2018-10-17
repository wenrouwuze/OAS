$(document).ready(function () {
    if ($.cookie("rmbUser") == "true") {
        $("#ck_rmbUser").attr("checked", true);
        $("#m_username").val($.cookie("username"));
        $("#m_password").val($.cookie("password"));
    }
    $("input[name='m_username']").focus();
});
/*登录按钮绑定点击事件*/
$(".btn").on('click',function(){
    if($('#ck_rmbUser').is(':checked')) {
        var str_username = $("#m_username").val();
        var str_password = $("#m_password").val();
        $.cookie("rmbUser", "true", { expires: 7 }); //存储一个带7天期限的cookie
        $.cookie("username", str_username, { expires: 7 });
        $.cookie("password", str_password, { expires: 7 });
    }
});