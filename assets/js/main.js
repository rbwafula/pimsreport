Highcharts.chart('chart1', {
  colors: ['#17a2b8'] /* '#6c757d','#17a2b8' */,
  credits: {
      text: '',
      href: 'https://staging1.unep.org/simon/pims-stg'
  },
  chart: {
    backgroundColor: '#F6F6F6',
    type: 'column'
  },
  title: {
    text: 'Budget Utilization'
  },
  xAxis: {
    categories: [
      'Consumable Budget',
      'Consumed Budget',
      'Budget Balance'
    ],
    crosshair: true
  },
  yAxis: {
    min: 0,
    title: {
      text: 'USD (M)'
    }
  },
  tooltip: {
    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
      '<td style="padding:0"><b>USD {point.y:.1f} M</b></td></tr>',
    footerFormat: '</table>',
    shared: true,
    useHTML: true
  },
  plotOptions: {
    column: {
      pointPadding: 0.2,
      borderWidth: 0
    }
  },
  series: [/*{
    name: '2019',
    data: [5.5, 4.8, 0.7]

  },*/ {
    name: '2020',
    data: [6, 5, 1]

  }]
});