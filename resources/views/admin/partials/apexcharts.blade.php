<script>
    'use strict';

    var $barColor = '#f3f3f3';
    var $trackBgColor = '#EBEBEB';
    var $primary_light = '#A9A2F6';
    var $success_light = '#55DD92';
    var $warning_light = '#ffc085';

    var statisticsBarChartOptions;
    var statisticsLineChartOptions;
    var withdrawChartOptions;
    var withdrawamountChartOptions;
    var withdrawchargeChartOptions;
    var withdrawpendingChartOptions;
    var trafficChartOptions;
    var userChartOptions;
    var newsletterChartOptions;

    var lineAreaChart1 = document.querySelector('#line-area-chart-1');
    var lineAreaChart2 = document.querySelector('#line-area-chart-2');
    var lineAreaChart3 = document.querySelector('#line-area-chart-3');
    var lineAreaChart4 = document.querySelector('#line-area-chart-4');
    var lineAreaChart6 = document.querySelector('#line-area-chart-6');
    var lineAreaChart7 = document.querySelector('#line-area-chart-7');
    var lineAreaChart8 = document.querySelector('#line-area-chart-8');
    var lineAreaChart9 = document.querySelector('#line-area-chart-9');
    var lineAreaChart10 = document.querySelector('#line-area-chart-10');
    var lineAreaChart11 = document.querySelector('#line-area-chart-11');
    var lineAreaChart12 = document.querySelector('#line-area-chart-12');

    var statisticsBar;
    var statisticsLine;
    var withdrawChart;
    var withdrawamountChart;
    var withdrawchargeChart;
    var withdrawpendingChart;
    var trafficChart;
    var userChart;
    var newsletterChart;


    // Total Users Chart
    // ----------------------------------

    userChartOptions = {
        chart: {
        height: 100,
        type: 'line',
        dropShadow: {
            enabled: true,
            top: 5,
            left: 0,
            blur: 4,
            opacity: 0.1
        },
        toolbar: {
            show: false
        },
        sparkline: {
            enabled: true
        },
        grid: {
            show: false,
            padding: {
            left: 0,
            right: 0
            }
        }
        },
        colors: [window.colors.solid.success],
        dataLabels: {
        enabled: false
        },
        stroke: {
        curve: 'smooth',
        width: 2.5
        },
        fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 1,
            gradientToColors: [$success_light],
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100, 100, 100]
        }
        },
        series: [
        {
            name: 'Total Users',
            data: [0 @foreach ( $dates['total_users'] as $date => $count ),{{ $count }}@endforeach]
        }
        ],
        xaxis: {
        labels: {
            show: false
        },
        axisBorder: {
            show: false
        }
        },
        yaxis: [
        {
            y: 0,
            offsetX: 0,
            offsetY: 0,
            padding: { left: 0, right: 0 }
        }
        ],
        tooltip: {
        x: { show: false }
        }
    };

    userChart = new ApexCharts(lineAreaChart1, userChartOptions);
    userChart.render();

    // Total Verified Users Chart
    // ----------------------------------

    userChartOptions = {
        chart: {
        height: 100,
        type: 'line',
        dropShadow: {
            enabled: true,
            top: 5,
            left: 0,
            blur: 4,
            opacity: 0.1
        },
        toolbar: {
            show: false
        },
        sparkline: {
            enabled: true
        },
        grid: {
            show: false,
            padding: {
            left: 0,
            right: 0
            }
        }
        },
        colors: [window.colors.solid.success],
        dataLabels: {
        enabled: false
        },
        stroke: {
        curve: 'smooth',
        width: 2.5
        },
        fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 1,
            gradientToColors: [$success_light],
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100, 100, 100]
        }
        },
        series: [
        {
            name: 'Verified Users',
            data: [0 @foreach ( $dates['verified_users'] as $date => $count ),{{ $count }}@endforeach]
        }
        ],
        xaxis: {
        labels: {
            show: false
        },
        axisBorder: {
            show: false
        }
        },
        yaxis: [
        {
            y: 0,
            offsetX: 0,
            offsetY: 0,
            padding: { left: 0, right: 0 }
        }
        ],
        tooltip: {
        x: { show: false }
        }
    };

    userChart = new ApexCharts(lineAreaChart2, userChartOptions);
    userChart.render();

    // Total Email Unverified Users Chart
    // ----------------------------------

    userChartOptions = {
        chart: {
        height: 100,
        type: 'line',
        dropShadow: {
            enabled: true,
            top: 5,
            left: 0,
            blur: 4,
            opacity: 0.1
        },
        toolbar: {
            show: false
        },
        sparkline: {
            enabled: true
        },
        grid: {
            show: false,
            padding: {
            left: 0,
            right: 0
            }
        }
        },
        colors: [window.colors.solid.warning],
        dataLabels: {
        enabled: false
        },
        stroke: {
        curve: 'smooth',
        width: 2.5
        },
        fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 1,
            gradientToColors: [$warning_light],
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100, 100, 100]
        }
        },
        series: [
        {
            name: 'Email Unverified Users',
            data: [0 @foreach ( $dates['email_unverified_users'] as $date => $count ),{{ $count }}@endforeach]
        }
        ],
        xaxis: {
        labels: {
            show: false
        },
        axisBorder: {
            show: false
        }
        },
        yaxis: [
        {
            y: 0,
            offsetX: 0,
            offsetY: 0,
            padding: { left: 0, right: 0 }
        }
        ],
        tooltip: {
        x: { show: false }
        }
    };

    userChart = new ApexCharts(lineAreaChart3, userChartOptions);
    userChart.render();

    // Total Trade Log Chart
    // ----------------------------------

    userChartOptions = {
        chart: {
        height: 100,
        type: 'line',
        dropShadow: {
            enabled: true,
            top: 5,
            left: 0,
            blur: 4,
            opacity: 0.1
        },
        toolbar: {
            show: false
        },
        sparkline: {
            enabled: true
        },
        grid: {
            show: false,
            padding: {
            left: 0,
            right: 0
            }
        }
        },
        colors: [window.colors.solid.success],
        dataLabels: {
        enabled: false
        },
        stroke: {
        curve: 'smooth',
        width: 2.5
        },
        fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 1,
            gradientToColors: [$success_light],
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100, 100, 100]
        }
        },
        series: [
        {
            name: 'Trade Log',
            data: [0 @foreach ( $dates['log'] as $date => $count ),{{ $count }}@endforeach]
        }
        ],
        xaxis: {
        labels: {
            show: false
        },
        axisBorder: {
            show: false
        }
        },
        yaxis: [
        {
            y: 0,
            offsetX: 0,
            offsetY: 0,
            padding: { left: 0, right: 0 }
        }
        ],
        tooltip: {
        x: { show: false }
        }
    };

    userChart = new ApexCharts(lineAreaChart6, userChartOptions);
    userChart.render();

    // Total Wining Trade Chart
    // ----------------------------------

    userChartOptions = {
        chart: {
        height: 100,
        type: 'line',
        dropShadow: {
            enabled: true,
            top: 5,
            left: 0,
            blur: 4,
            opacity: 0.1
        },
        toolbar: {
            show: false
        },
        sparkline: {
            enabled: true
        },
        grid: {
            show: false,
            padding: {
            left: 0,
            right: 0
            }
        }
        },
        colors: [window.colors.solid.primary],
        dataLabels: {
        enabled: false
        },
        stroke: {
        curve: 'smooth',
        width: 2.5
        },
        fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 1,
            gradientToColors: [$primary_light],
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100, 100, 100]
        }
        },
        series: [
        {
            name: 'Winning Trade',
            data: [0 @foreach ( $dates['wining'] as $date => $count ),{{ $count }}@endforeach]
        }
        ],
        xaxis: {
        labels: {
            show: false
        },
        axisBorder: {
            show: false
        }
        },
        yaxis: [
        {
            y: 0,
            offsetX: 0,
            offsetY: 0,
            padding: { left: 0, right: 0 }
        }
        ],
        tooltip: {
        x: { show: false }
        }
    };

    userChart = new ApexCharts(lineAreaChart7, userChartOptions);
    userChart.render();

    // Total Losing Trade Chart
    // ----------------------------------

    userChartOptions = {
        chart: {
        height: 100,
        type: 'line',
        dropShadow: {
            enabled: true,
            top: 5,
            left: 0,
            blur: 4,
            opacity: 0.1
        },
        toolbar: {
            show: false
        },
        sparkline: {
            enabled: true
        },
        grid: {
            show: false,
            padding: {
            left: 0,
            right: 0
            }
        }
        },
        colors: [window.colors.solid.success],
        dataLabels: {
        enabled: false
        },
        stroke: {
        curve: 'smooth',
        width: 2.5
        },
        fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 1,
            gradientToColors: [$success_light],
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100, 100, 100]
        }
        },
        series: [
        {
            name: 'Losing Trade',
            data: [0 @foreach ( $dates['losing'] as $date => $count ),{{ $count }}@endforeach]
        }
        ],
        xaxis: {
        labels: {
            show: false
        },
        axisBorder: {
            show: false
        }
        },
        yaxis: [
        {
            y: 0,
            offsetX: 0,
            offsetY: 0,
            padding: { left: 0, right: 0 }
        }
        ],
        tooltip: {
        x: { show: false }
        }
    };

    userChart = new ApexCharts(lineAreaChart8, userChartOptions);
    userChart.render();

    // Total Withdraw Chart
    // ----------------------------------

    withdrawChartOptions = {
        chart: {
        height: 100,
        type: 'area',
        toolbar: {
            show: false
        },
        sparkline: {
            enabled: true
        },
        grid: {
            show: false,
            padding: {
            left: 0,
            right: 0
            }
        }
        },
        colors: [window.colors.solid.primary],
        dataLabels: {
        enabled: false
        },
        stroke: {
        curve: 'smooth',
        width: 2.5
        },
        fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 0.9,
            opacityFrom: 0.7,
            opacityTo: 0.5,
            stops: [0, 80, 100]
        }
        },
        series: [
        {
            name: 'Withdrawels',
            data: [0 @foreach ( $dates['total_withdraw'] as $date => $count ),{{ $count }}@endforeach]
        }
        ],
        xaxis: {
        labels: {
            show: false
        },
        axisBorder: {
            show: false
        }
        },
        yaxis: [
        {
            y: 0,
            offsetX: 0,
            offsetY: 0,
            padding: { left: 0, right: 0 }
        }
        ],
        tooltip: {
        x: { show: false }
        }
    };

    withdrawChart = new ApexCharts(lineAreaChart9, withdrawChartOptions);
    withdrawChart.render();

    // Total Withdrawel Amount Chart
    // ----------------------------------

    withdrawamountChartOptions = {
        chart: {
        height: 100,
        type: 'area',
        toolbar: {
            show: false
        },
        sparkline: {
            enabled: true
        },
        grid: {
            show: false,
            padding: {
            left: 0,
            right: 0
            }
        }
        },
        colors: [window.colors.solid.success],
        dataLabels: {
        enabled: false
        },
        stroke: {
        curve: 'smooth',
        width: 2.5
        },
        fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 0.9,
            opacityFrom: 0.7,
            opacityTo: 0.5,
            stops: [0, 80, 100]
        }
        },
        series: [
        {
            name: 'Withdrawel Amount',
            data: [0, {{getAmount($paymentWithdraw['total_withdraw_amount'])}}]
        }
        ],
        xaxis: {
        labels: {
            show: false
        },
        axisBorder: {
            show: false
        }
        },
        yaxis: [
        {
            y: 0,
            offsetX: 0,
            offsetY: 0,
            padding: { left: 0, right: 0 }
        }
        ],
        tooltip: {
        x: { show: false }
        }
    };

    withdrawamountChart = new ApexCharts(lineAreaChart10, withdrawamountChartOptions);
    withdrawamountChart.render();

    // Total Withdrwael Charge Chart
    // ----------------------------------

    withdrawchargeChartOptions = {
        chart: {
        height: 100,
        type: 'area',
        toolbar: {
            show: false
        },
        sparkline: {
            enabled: true
        },
        grid: {
            show: false,
            padding: {
            left: 0,
            right: 0
            }
        }
        },
        colors: [window.colors.solid.danger],
        dataLabels: {
        enabled: false
        },
        stroke: {
        curve: 'smooth',
        width: 2.5
        },
        fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 0.9,
            opacityFrom: 0.7,
            opacityTo: 0.5,
            stops: [0, 80, 100]
        }
        },
        series: [
        {
            name: 'Withdrawel Charge',
            data: [0, {{getAmount($paymentWithdraw['total_withdraw_charge'])}}]
        }
        ],
        xaxis: {
        labels: {
            show: false
        },
        axisBorder: {
            show: false
        }
        },
        yaxis: [
        {
            y: 0,
            offsetX: 0,
            offsetY: 0,
            padding: { left: 0, right: 0 }
        }
        ],
        tooltip: {
        x: { show: false }
        }
    };

    withdrawchargeChart = new ApexCharts(lineAreaChart11, withdrawchargeChartOptions);
    withdrawchargeChart.render();

    // Total Pending Withdrawel Chart
    // ----------------------------------

    withdrawpendingChartOptions = {
        chart: {
        height: 100,
        type: 'area',
        toolbar: {
            show: false
        },
        sparkline: {
            enabled: true
        },
        grid: {
            show: false,
            padding: {
            left: 0,
            right: 0
            }
        }
        },
        colors: [window.colors.solid.warning],
        dataLabels: {
        enabled: false
        },
        stroke: {
        curve: 'smooth',
        width: 2.5
        },
        fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 0.9,
            opacityFrom: 0.7,
            opacityTo: 0.5,
            stops: [0, 80, 100]
        }
        },
        series: [
        {
            name: 'Pending Withdrawel',
            data: [0 @foreach ( $dates['total_withdraw_pending'] as $date => $count ),{{ $count }}@endforeach]
        }
        ],
        xaxis: {
        labels: {
            show: false
        },
        axisBorder: {
            show: false
        }
        },
        yaxis: [
        {
            y: 0,
            offsetX: 0,
            offsetY: 0,
            padding: { left: 0, right: 0 }
        }
        ],
        tooltip: {
        x: { show: false }
        }
    };

    withdrawpendingChart = new ApexCharts(lineAreaChart12, withdrawpendingChartOptions);
    withdrawpendingChart.render();

        // apex-bar-chart js
        var options = {
            series: [{
                name: 'Total Deposit',
                data: [
                    @foreach($report['months'] as $month)
                    {{ getAmount(@$depositsMonth->where('months',$month)->first()->depositAmount) }},
                    @endforeach
                ]
            }, {
                name: 'Total Withdraw',
                data: [
                    @foreach($report['months'] as $month)
                    {{ getAmount(@$withdrawalMonth->where('months',$month)->first()->withdrawAmount) }},
                    @endforeach
                ]
            }],
            chart: {
                type: 'bar',
                height: 400,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '50%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: true
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: @json($report['months']->flatten()),
            },
            yaxis: {
                title: {
                    text: "{{__($general->cur_sym)}}",
                    style: {
                        color: '#7c97bb'
                    }
                }
            },
            grid: {
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "{{__($general->cur_sym)}}" + val + " "
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#apex-bar-chart"), options);
        chart.render();

        // apex-line chart
        var options = {
            chart: {
                height: 430,
                type: "area",
                toolbar: {
                    show: false
                },
                dropShadow: {
                    enabled: true,
                    enabledSeries: [0],
                    top: -2,
                    left: 0,
                    blur: 10,
                    opacity: 0.08
                },
                animations: {
                    enabled: true,
                    easing: 'linear',
                    dynamicAnimation: {
                        speed: 1000
                    }
                },
            },
            dataLabels: {
                enabled: false
            },
            series: [
                {
                    name: "Series 1",
                    data: @json($withdrawals['per_day_amount']->flatten())
                }
            ],
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.9,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: @json($withdrawals['per_day']->flatten())
            },
            grid: {
                padding: {
                    left: 5,
                    right: 5
                },
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
            },
        };

        var chart = new ApexCharts(document.querySelector("#withdraw-line"), options);

        chart.render();
</script>
