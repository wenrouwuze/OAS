/**
 * Created by Wang Jiaxin on 2018/5/23.
 */

//部门人员图表

var myChart = echarts.init(document.getElementById('showChart_number_of_department'));
var option = {
    color:['#B5E4FF','#FFB622','#FFE8B3','#FCAAAA','#15A1EF'],
    tooltip : {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
    },
    legend: {
        x: 'right',
        data:['运营部','销售部','产品部','人力资源','技术部'],
        textStyle: {
            color:'#666666'
        }
    },
    calculable : true,
    series : [
        {
            name:'部门人数',
            type:'pie',
            radius : [100, 140],

            //for funnel
            x:'60%',
            width:'35%',
            funnelAlign:'left',
            max:1048,
            data:[
                {value:16, name:'运营部'},
                {value:20, name:'销售部'},
                {value:32, name:'产品部'},
                {value:50, name:'人力资源'},
                {value:10, name:'技术部'}
            ]
        },
    ]
};

myChart.setOption(option);
window.onresize = myChart.resize;