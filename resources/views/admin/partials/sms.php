// Total SMS Unverified Users Chart
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
      width: 5
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
        name: 'Sms Unverified Users',
        data: [0 @foreach ( $dates['sms_unverified_users'] as $date => $count ),{{ $count }}@endforeach]
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

  userChart = new ApexCharts(lineAreaChart4, userChartOptions);
  userChart.render();
