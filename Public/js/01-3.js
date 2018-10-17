/**
 * Created by Wang Jiaxin on 2018/5/24.
 */

//在职人数图表

var myChart = echarts.init(document.getElementById('showChart_number_of_incumbency'));
var option = {
    color: ['#15A1EF', '#B5E4FF', '#FFB622'],
    tooltip: {
        trigger: "item",
        formatter: "{a} <br/>{b} : {c}"
    },
    legend: {
        x: 'right',
        textStyle: {
            color:'#666666'
        },
        data: ["正式", "试用", "实习"]
    },
    xAxis: [
        {
            type: "category",
            splitLine: {
                show: true,
                lineStyle: {
                    color: "#E6E6E6"
                }
            },
            boundaryGap : false,
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
            data: ["6月", "7月", "8月", "9月", "10月", "11月"]
        }
    ],
    yAxis: [
        {
            type: "value",
            splitLine: {
                show: true,
                lineStyle: {
                    color: "#E6E6E6"
                }
            },
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
        }
    ],
    calculable: true,
    series: [
        {
            name: "正式",
            type: "line",
            data: [8, 20, 20, 30, 30, 40]

        },
        {
            name: "试用",
            type: "line",
            data: [2, 10, 15, 22, 21, 30]

        },
        {
            name: "实习",
            type: "line",
            data: [0, 2, 3, 3, 2, 10]

        }
    ]
};

myChart.setOption(option);
window.onresize = myChart.resize;