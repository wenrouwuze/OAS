/**
 * Created by Wang Jiaxin on 2018/5/24.
 */


//左侧列表收缩展开效果
$(document).ready(function(){
    $(".list span").click(function(){
            $(this).next(".list-1").animate({height: 'toggle', opacity: 'toggle'}, "slow");
        }
        ,
        function(){
            $(this).next(".list-1").animate({height: 'toggle', opacity: 'toggle'}, "slow");
        });
});

$(document).ready(function(){
    $(".list-select span").click(function(){
            $(this).next(".list-1").animate({height: 'toggle', opacity: 'toggle'}, "slow");/*.animate()是jQuery的动画函数，在此，我们可以修改DOM元素的CSS样式，实现元素的动态改变*/
        }
        ,
        function(){
            $(this).next(".list-1").animate({height: 'toggle', opacity: 'toggle'}, "slow");
        });
});





//修改密码操作提示

/*原密码验证*/

function message(message,area){
    var area = area || ['150px','50px'];

    layui.use('layer', function(){
        var layer = layui.layer;

        layer.msg(message,{area: area});
    });
}

$('.list-con .list').on('click',function () {
    $(this).attr('class','list-select');
    $(this).find('span').attr('class','on');
    $(this).siblings().attr('class','list');
    $(this).siblings().find('span').attr('class','off');
});