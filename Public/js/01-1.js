/**
 * Created by Wang Jiaxin on 2018/5/23.
 */


//人员变动图表

var myChart = echarts.init(document.getElementById('showChart_employee_change'));
var option = {
    color:['#15A1EF', '#B5E4FF', '#FFB622', '#FFE8B3'],
    tooltip: {
        trigger: 'axis',
        axisPointer: {
            type: 'shadow'
        }
    },
    legend: {
        data:['入职','转正','离职','试用期离职'],
        x: 'right',
        textStyle: {
            color:'#666666'
        }
    },
    calculable: true,
    xAxis: {
        type: 'category',
        axisTick: {show: false},
        axisLabel: {
            show: true,
            textStyle: {
                color: '#999999'
            }
        },
        axisLine: {
            lineStyle: {
                color: '#DDDDDD'
            }
        },
        data: ['6月', '7月', '8月', '9月', '10月', '11月']
    },
    yAxis: {
        type: 'value',
        axisLabel: {
            formatter: '{value}',
            textStyle: {
                color: '#999999'
            }
        },
        axisLine: {
            lineStyle: {
                color: '#DDDDDD'
            }
        }
    },
    series: [
        {
            name: '入职',
            type: 'bar',
            barGap: 0,
            barWidth:20,
            data: [0, 12, 0, 8, 8, 0]
        },
        {
            name: '转正',
            type: 'bar',
            barGap: 0,
            barWidth:20,
            data: [0, 9, 0, 3, 15, 8]
        },
        {
            name: '离职',
            type: 'bar',
            barGap: 0,
            barWidth:20,
            data: [0, 3, 0, 0, 6, 0]
        },
        {
            name: '试用期离职',
            type: 'bar',
            barGap: 0,
            barWidth:20,
            data: [0, 0, 0, 1, 0, 3]
        }
    ],
    itemStyle:{
        boderColor: '#DDDDDD'
    }
};

myChart.setOption(option);
window.onresize = myChart.resize;

