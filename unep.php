<?php
$month = Date("M") . ' ' . Date("Y");
$division = ucwords('unep');
if (isset($_GET['office'])) {
    $division = ucwords($_GET['office']);
}
include_once 'totals_algo.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo strtoupper($division);?> | PIMS+ Report</title>
	<!-- Vendor CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/highcharts.css">

    <!-- Vendor JS -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
    <script src="assets/js/main.js"></script>

    <!-- HTML TO PDF LIB LOADED -->
    <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
</head>
<body>
	<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow hidden">
        <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="javascript:void(0);">KIRI</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <input class="form-control form-control-dark w-100 disabled" disabled="disabled" type="text" placeholder="Search" aria-label="Search">
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="#">@rbwafula</a>
            </li>
        </ul>
    </nav>

    <!-- THE DIVISION TO BE EXPORTED MARKED -->
    <div id="to_export">

    <div class="container-fluid printlandscape">
        <div class="row noprint" data-html2canvas-ignore="true">
            <main role="main" class="col-md-12 ml-sm-auto col-lg-12 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Division Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="javascript:void(0);">Share</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print();return false;">Export to PDF</button>
                            <!-- TRIGGER FOR THE HTML TO PDF FUNCTION -->
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="jsp();"> PDF</button>
                        </div>
                        <!--<button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                            <span data-feather="calendar"></span> This week
                        </button>-->
                    </div>
                </div>
            </main>
        </div>

        <div id="toprint" class="toprint">
            <div class="row reportheader">
                <div class="col-md-4 logo">
                    <img class="logo" src="assets/images/pimslogo.png">
                </div>
                <div class="col-md-6 title">
                    <h1><?php echo $processed_divisiondata[$division]["entity"]; ?> Programme</h1>
                    <h6>Programme Delivery Report</h6>
                </div>
                <div class="col-md-2 health">
                    <p class="reportdate"><?php $month; ?></p>
                    <p class="healthrating_box" style="background-color:<?php echo $processed_divisiondata[$division]["healthcolor"]; ?>;">&nbsp;</p>
                    <p class="healthratingdesc">Project Portfolio Rating</p>
                </div>
            </div>

            <div class="row reportbody section1">
                <div class="col-md-4 summary">
                    <h5 class="sectiontitle">Summary</h5>
                    <div class="row summarystatistics">
                        <div class="col metric1">
                            <p class="metricvalue">
                                <?php echo number_format($processed_divisiondata[$division]["totalprojects"], 0, '.', ','); ?>
                            </p>
                            <p class="metricdesc">Total<br/>Projects</p>
                        </div>
                        <div class="col metric2">
                            <p class="metricvalue">
                                <?php echo number_format($processed_divisiondata[$division]["totaloutputs"], 0, '.', ','); ?>
                            </p>
                            <p class="metricdesc">Total<br/>Outputs</p>
                        </div>
                        <div class="col metric3">
                            <p class="metricvalue">
                                <?php echo number_format($processed_divisiondata[$division]["totalactivities"], 0, '.', ','); ?>
                            </p>
                            <p class="metricdesc">Total<br/>Activities</p>
                        </div>
                        <div class="col metric4">
                            <p class="metricvalue">
                                <?php echo number_format($processed_divisiondata[$division]["pastdueprojects"], 0, '.', ','); ?>
                            </p>
                            <p class="metricdesc">Expired<br/>Projects</p>
                        </div>
                        <div class="col metric4">
                            <p class="metricvalue">
                                <?php echo number_format(abs($processed_divisiondata[$division]["avgmonthspastdue"]), 0, '.', ','); ?>
                            </p>
                            <p class="metricdesc">Avg Months<br/>Past Due</p>
                        </div>
                        <?php $complianceclass = ($processed_divisiondata[$division]["reportedprojectspct"] < 80) ? 'metric4' : 'metric5';?>
                        <div class="col <?php echo $complianceclass; ?>">
                            <p class="metricvalue">
                                <?php echo number_format($processed_divisiondata[$division]["reportedprojectspct"], 0); ?>%
                            </p>
                            <p class="metricdesc">Reporting<br/>Compliance</p>
                        </div>
                    </div>
                    <p class="summarytext">The dashboard captured financial data of <strong><?php echo $processed_divisiondata[$division]["totalprojects"]; ?> projects</strong> for the <?php echo $division; ?> Office. The overall budget recorded for this portfolio as of 2020 was <strong>(USD. <?php echo number_format($processed_divisiondata[$division]["consumablebudget"], 0, '.', ','); ?>)</strong>, capturing a rolling total of the cash received over time.</p>
                    <div class="row chartrender">
                        <div class="col-md-12 budgetsize">
                            <div id="budgetsize_chart"></div>
                            <script type="text/javascript">
                                Highcharts.chart('budgetsize_chart', {
                                    credits: {
                                        text: ''
                                    },
                                    chart: {
                                        backgroundColor: 'transparent',
                                        type: 'column',
                                        height: 200
                                    },
                                    title: {
                                        text: 'Figure 1: Projects by Rating',
                                        floating: false,
                                        align: 'left',
                                        verticalAlign: 'top',
                                        margin: 20,
                                        style: {
                                            color: '#707070',
                                            fontSize: '10px',
                                            fontWeight: '900',
                                            textTransform: 'none',
                                            textDecoration: 'underline'

                                        },
                                        x: 0,
                                        y: 0
                                    },
                                    xAxis: {
                                        categories: ["Red", "Yellow", "Green"],
                                        labels: {
                                            style: {
                                                fontSize: '0.25cm',
                                                fontWeight: 700
                                            },
                                            formatter: function() {
                                                var ret = this.value,
                                                    len = ret.length;
                                                //console.log(len);
                                                if (len > 10) {
                                                    ret = ret.split(' ')[0] + '<br/>' +ret.split(' ')[1]
                                                }
                                                if (len > 25) {
                                                    ret = ret.slice(0, 25) + '...';
                                                }
                                                return ret;
                                            }
                                        },
                                        crosshair: true
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: ''
                                        },
                                        labels: {
                                            style: {
                                                fontSize: '0.2cm'
                                            }
                                        }
                                    },
                                    tooltip: {
                                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                            '<td style="padding:0"><b>USD {point.y:.1f} M</b></td></tr>',
                                        footerFormat: '</table>',
                                        shared: true,
                                        useHTML: true,
                                        enabled: false
                                    },
                                    plotOptions: {
                                        column: {
                                            pointPadding: 0.2,
                                            borderWidth: 0,
                                            dataLabels: {
                                                enabled: true,
                                                formatter: function() {
                                                    return '' + Highcharts.numberFormat(this.y,0) + '';
                                                }
                                            }
                                        },
                                        series: {
                                            groupPadding: 0,
                                            pointPadding: 0.1,
                                            borderWidth: 0,
                                            colorByPoint: true,
                                            colors: ['#dc3545','#ffc107', '#28a745']
                                        }
                                    },
                                    series: [{
                                        name: 'Rating',
                                        data: [<?php echo count($processed_divisiondata[$division]["scatterpoints"]["red"]); ?>,<?php echo count($processed_divisiondata[$division]["scatterpoints"]["yellow"]); ?>,<?php echo count($processed_divisiondata[$division]["scatterpoints"]["green"]); ?>],
                                        showInLegend: false

                                    }]
                                });
                            </script>
                        </div>
                    </div>

                    <div class="row chartrender">
                        <div class="col-md-12 budgetutilization">
                            <div id="budgetutilization_chart"></div>
                            <script type="text/javascript">
                                Highcharts.chart('budgetutilization_chart', {
                                    colors: ['#17a2b8'],
                                    credits: {
                                        text: ''
                                    },
                                    chart: {
                                        backgroundColor: 'transparent',
                                        type: 'column',
                                        height: 200
                                    },
                                    title: {
                                        text: 'Figure 2: Budget Utilization (USD M)',
                                        floating: false,
                                        align: 'left',
                                        verticalAlign: 'top',
                                        margin: 20,
                                        style: {
                                            color: '#707070',
                                            fontSize: '10px',
                                            fontWeight: '900',
                                            textTransform: 'none',
                                            textDecoration: 'underline'

                                        },
                                        x: 0,
                                        y: 0
                                    },
                                    xAxis: {
                                        categories: ['Consumable Budget','Consumed Budget','Budget Balance'],
                                        labels: {
                                            style: {
                                                fontSize: '0.2cm'
                                            },
                                            formatter: function() {
                                                var ret = this.value,
                                                    len = ret.length;
                                                //console.log(len);
                                                if (len > 10) {
                                                    ret = ret.split(' ')[0] + '<br/>' +ret.split(' ')[1]
                                                }
                                                if (len > 25) {
                                                    ret = ret.slice(0, 25) + '...';
                                                }
                                                return ret;
                                            }
                                        },
                                        crosshair: true
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: ''
                                        },
                                        labels: {
                                            style: {
                                                fontSize: '0.2cm'
                                            }
                                        }
                                    },
                                    tooltip: {
                                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                            '<td style="padding:0"><b>USD {point.y:.1f} M</b></td></tr>',
                                        footerFormat: '</table>',
                                        shared: true,
                                        useHTML: true,
                                        enabled: false
                                    },
                                    plotOptions: {
                                        column: {
                                            pointPadding: 0.2,
                                            borderWidth: 0,
                                            dataLabels: {
                                                enabled: true,
                                                formatter: function() {
                                                    return '$ ' + Highcharts.numberFormat(this.y,2) + 'M';
                                                }
                                            }
                                        },
                                        series: {
                                            groupPadding: 0,
                                            pointPadding: 0.1,
                                            borderWidth: 0
                                        }
                                    },
                                    series: [{
                                         name: 'Current Yr',
                                        data: [
                                            <?php echo $processed_divisiondata[$division]["consumablebudget"] / 1000000; ?>,
                                            <?php echo $processed_divisiondata[$division]["totalconsumedbudget"] / 1000000; ?>,
                                            <?php echo ($processed_divisiondata[$division]["consumablebudget"] - $processed_divisiondata[$division]["totalconsumedbudget"]) / 1000000; ?>],
                                        showInLegend: false
                                    }]
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 portfolio">
                    <h5 class="sectiontitle">Portfolio Statistics</h5>
                    <div class="row portfoliostatistics">
                        <div class="col-md-4 metric1">
                            <div id="budgetutilized_chart"></div>
                            <div class="desc">Budget Spent</div>
                        </div>
                        <div class="col-md-4 metric2">
                            <div id="timetaken_chart"></div>
                            <div class="desc">Time Used</div>
                        </div>
                        <div class="col-md-4 metric3">
                            <div id="activitiescompleted_chart"></div>
                            <div class="desc">Activities Completed</div>
                        </div>
                        <script type="text/javascript">
                            Highcharts.chart('budgetutilized_chart', {
                                chart: {
                                    backgroundColor: 'rgba(0,0,0,0)',
                                    plotBackgroundColor: null,
                                    plotBorderWidth: 0,
                                    plotShadow: false,
                                    margin: [0, 0, -10, 0],
                                    spacingTop: 0,
                                    spacingBottom: 0,
                                    spacingLeft: 0,
                                    spacingRight: 0,
                                    height: 130
                                },
                                colors: ['#0077b6','#ccc'],
                                credits: {
                                    enabled: false
                                },
                                title: {
                                    text: '<?php echo number_format($processed_divisiondata[$division]["pctbudgetutilized"], 0, '.', ','); ?>%',
                                    align: 'center',
                                    verticalAlign: 'bottom',
                                    y: 15,
                                    style: {
                                        color: '#0077b6',
                                        fontWeight: 500
                                    }
                                },
                                tooltip: {
                                    enabled: false
                                },
                                accessibility: {
                                    point: {
                                        valueSuffix: '%'
                                    }
                                },
                                plotOptions: {
                                    pie: {
                                        size: '100%',
                                        dataLabels: {
                                            enabled: false,
                                            distance: -50,
                                            style: {
                                                fontWeight: 'bold',
                                                color: 'white'
                                            }
                                        },
                                        startAngle: -90,
                                        endAngle: 90,
                                        center: ['50%', '100%']
                                    },
                                    series: {
                                        states: {
                                            hover: {
                                                enabled: false
                                            }
                                        }
                                    }
                                },
                                series: [{
                                    type: 'pie',
                                    name: 'Avg. Time Taken',
                                    innerSize: '70%',
                                    data: [
                                        ['Time Taken', <?php echo $processed_divisiondata[$division]["pctbudgetutilized"]; ?> ],
                                        {
                                            name: '',
                                            y: <?php echo (100 - $processed_divisiondata[$division]["pctbudgetutilized"]); ?>,
                                            dataLabels: {
                                                enabled: false
                                            }
                                        }
                                    ]
                                }]
                            });


                            Highcharts.chart('timetaken_chart', {
                                chart: {
                                    backgroundColor: 'rgba(0,0,0,0)',
                                    plotBackgroundColor: null,
                                    plotBorderWidth: 0,
                                    plotShadow: false,
                                    margin: [0, 0, -10, 0],
                                    spacingTop: 0,
                                    spacingBottom: 0,
                                    spacingLeft: 0,
                                    spacingRight: 0,
                                    height: 130
                                },
                                colors: ['#d59442','#ccc'],
                                credits: {
                                    enabled: false
                                },
                                title: {
                                    text: '<?php echo number_format($processed_divisiondata[$division]["pctgdurationused"], 0, '.', ','); ?>%',
                                    align: 'center',
                                    verticalAlign: 'bottom',
                                    y: 15,
                                    style: {
                                        color: '#d59442',
                                        fontWeight: 500
                                    }
                                },
                                tooltip: {
                                    enabled: false
                                },
                                accessibility: {
                                    point: {
                                        valueSuffix: '%'
                                    }
                                },
                                plotOptions: {
                                    pie: {
                                        size: '100%',
                                        dataLabels: {
                                            enabled: false,
                                            distance: -50,
                                            style: {
                                                fontWeight: 'bold',
                                                color: 'white'
                                            }
                                        },
                                        startAngle: -90,
                                        endAngle: 90,
                                        center: ['50%', '100%']
                                    }
                                },
                                series: [{
                                    type: 'pie',
                                    name: 'Activities Completed',
                                    innerSize: '70%',
                                    data: [
                                        ['Time Taken', <?php echo $processed_divisiondata[$division]["pctgdurationused"]; ?> ],
                                        {
                                            name: '',
                                            y: <?php echo (100 - $processed_divisiondata[$division]["pctgdurationused"]); ?>,
                                            dataLabels: {
                                                enabled: false
                                            }
                                        }
                                    ]
                                }]
                            });

                            Highcharts.chart('activitiescompleted_chart', {
                                chart: {
                                    backgroundColor: 'rgba(0,0,0,0)',
                                    plotBackgroundColor: null,
                                    plotBorderWidth: 0,
                                    plotShadow: false,
                                    margin: [0, 0, -10, 0],
                                    spacingTop: 0,
                                    spacingBottom: 0,
                                    spacingLeft: 0,
                                    spacingRight: 0,
                                    height: 130
                                },
                                colors: ['#688753','#ccc'],
                                credits: {
                                    enabled: false
                                },
                                title: {
                                    text: '<?php echo number_format($processed_divisiondata[$division]["avgactivitiescompleted"], 0, '.', ','); ?>%',
                                    align: 'center',
                                    verticalAlign: 'bottom',
                                    y: 15,
                                    style: {
                                        color: '#688753',
                                        fontWeight: 500
                                    }
                                },
                                tooltip: {
                                    enabled: false
                                },
                                accessibility: {
                                    point: {
                                        valueSuffix: '%'
                                    }
                                },
                                plotOptions: {
                                    pie: {
                                        size: '100%',
                                        dataLabels: {
                                            enabled: false,
                                            distance: -50,
                                            style: {
                                                fontWeight: 'bold',
                                                color: 'white'
                                            }
                                        },
                                        startAngle: -90,
                                        endAngle: 90,
                                        center: ['50%', '100%']
                                    }
                                },
                                series: [{
                                    type: 'pie',
                                    name: 'Activities Completed',
                                    innerSize: '70%',
                                    data: [
                                        ['Time Taken', <?php echo $processed_divisiondata[$division]["avgactivitiescompleted"]; ?> ],
                                        {
                                            name: '',
                                            y: <?php echo (100 - $processed_divisiondata[$division]["avgactivitiescompleted"]); ?>,
                                            dataLabels: {
                                                enabled: false
                                            }
                                        }
                                    ]
                                }]
                            });
                        </script>
                    </div>

                    <div class="row chartrender">
                        <div class="col-md-12 groupingbyage">
                            <div id="groupingbyage_chart"></div>
                            <script type="text/javascript">
                                Highcharts.chart('groupingbyage_chart', {
                                    colors: ['#0077b6'],
                                    credits: {
                                        text: ''
                                    },
                                    chart: {
                                        backgroundColor: 'transparent',
                                        type: 'bar',
                                        height: 200
                                    },
                                    title: {
                                        text: 'Figure 3: Projects Age Category',
                                        floating: false,
                                        align: 'left',
                                        verticalAlign: 'top',
                                        margin: 20,
                                        style: {
                                            color: '#707070',
                                            fontSize: '10px',
                                            fontWeight: '900',
                                            textTransform: 'none',
                                            textDecoration: 'underline'

                                        },
                                        x: 0,
                                        y: 0
                                    },
                                    xAxis: {
                                        categories: ['0-2 Y', '2-5 Y', '5-10 Y', '10+ Y'],
                                        title: {
                                            text: '',
                                            style: {
                                                fontSize: '0.3cm'
                                            }
                                        },
                                        labels: {
                                            style: {
                                                fontSize: '0.2cm'
                                            },
                                            formatter: function() {
                                                var ret = this.value,
                                                    len = ret.length;
                                                //console.log(len);
                                                if (len > 10) {
                                                    ret = ret.split(' ')[0] + '<br/>' +ret.split(' ')[1]
                                                }
                                                if (len > 25) {
                                                    ret = ret.slice(0, 25) + '...';
                                                }
                                                return ret;
                                            }
                                        },
                                        crosshair: true
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: ''
                                        },
                                        labels: {
                                            style: {
                                                fontSize: '0.2cm'
                                            }
                                        }
                                    },
                                    tooltip: {
                                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                            '<td style="padding:0"><b>USD {point.y:.1f} M</b></td></tr>',
                                        footerFormat: '</table>',
                                        shared: true,
                                        useHTML: true,
                                        enabled: false
                                    },
                                    plotOptions: {
                                        bar: {
                                            pointPadding: 0.2,
                                            borderWidth: 0,
                                            dataLabels: {
                                                enabled: true,
                                                formatter: function(){
                                                    return (this.y!=0)?this.y:"";
                                                }
                                            }
                                        },
                                        series: {
                                            groupPadding: 0,
                                            pointPadding: 0.1,
                                            borderWidth: 0
                                        }
                                    },
                                    series: [{
                                        name: 'Project Age',
                                        data: <?php echo json_encode($processed_divisiondata[$division]["projectage"]); ?>,
                                        color: '#4e90e0',
                                        showInLegend: false

                                    }]
                                });
                            </script>
                        </div>
                    </div>

                    <div class="row chartrender">
                        <div class="col-md-12 projectsbysubprogramme">
                            <div id="projectsbysubprogramme_chart"></div>
                            <script type="text/javascript">
                                Highcharts.chart('projectsbysubprogramme_chart', {
                                    colors: ['#0077b6'],
                                    credits: {
                                        text: ''
                                    },
                                    chart: {
                                        backgroundColor: 'transparent',
                                        type: 'column',
                                        height: 250
                                    },
                                    title: {
                                        text: 'Figure 4: Projects by Sub-Programme',
                                        floating: false,
                                        align: 'left',
                                        verticalAlign: 'top',
                                        margin: 20,
                                        style: {
                                            color: '#707070',
                                            fontSize: '10px',
                                            fontWeight: '900',
                                            textTransform: 'none',
                                            textDecoration: 'underline'

                                        },
                                        x: 0,
                                        y: 0
                                    },
                                    xAxis: {
                                        categories: <?php echo json_encode($processed_divisiondata[$division]["projectsubprogramme"]["spnumbers"]); ?>,
                                        labels: {
                                            style: {
                                                fontSize: '0.25cm',
                                                fontWeight: 700
                                            },
                                            formatter: function() {
                                                var ret = this.value,
                                                    len = ret.length;
                                                //console.log(len);
                                                if (len > 10) {
                                                    ret = ret.split(' ')[0] + '<br/>' +ret.split(' ')[1]
                                                }
                                                if (len > 25) {
                                                    ret = ret.slice(0, 25) + '...';
                                                }
                                                return ret;
                                            }
                                        },
                                        crosshair: true
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: ''
                                        },
                                        labels: {
                                            style: {
                                                fontSize: '0.2cm'
                                            }
                                        }
                                    },
                                    tooltip: {
                                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                            '<td style="padding:0"><b>USD {point.y:.1f} M</b></td></tr>',
                                        footerFormat: '</table>',
                                        shared: true,
                                        useHTML: true,
                                        enabled: false
                                    },
                                    plotOptions: {
                                        column: {
                                            pointPadding: 0.2,
                                            borderWidth: 0,
                                            dataLabels: {
                                                enabled: true,
                                                formatter: function() {
                                                    return '' + Highcharts.numberFormat(this.y,0) + '';
                                                }
                                            }
                                        },
                                        series: {
                                            groupPadding: 0,
                                            pointPadding: 0.1,
                                            borderWidth: 0
                                        }
                                    },
                                    series: [{
                                        name: 'Subprogramme',
                                        data: <?php echo json_encode($processed_divisiondata[$division]["projectsubprogramme"]["projectcount"]); ?>,
                                        showInLegend: false

                                    }]
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 humanresource">
                    <h5 class="sectiontitle">Human Resource</h5>
                    <div class="row chartrender">
                        <div class="col-md-12 hrfilled">
                            <div class="row hrstatistics">
                                <?php
                                $totalposts = 0;
                                $filledposts = 0;
                                $vacantposts = 0;
                                $maleposts = 0;
                                $femaleposts = 0;
                                for ($i = 0; $i < count($processed_divisiondata[$division]["hrpostsvacant"]); $i++) {
                                    $vacantposts += $processed_divisiondata[$division]["hrpostsvacant"][$i];
                                    $filledposts += $processed_divisiondata[$division]["hrpostsfilled"][$i];
                                    $totalposts += ($processed_divisiondata[$division]["hrpostsvacant"][$i] + $processed_divisiondata[$division]["hrpostsfilled"][$i]);
                                    $maleposts += $processed_divisiondata[$division]["hrpostsmale"][$i];
                                    $femaleposts += $processed_divisiondata[$division]["hrpostsfemale"][$i];
                                }
                                ?>
                                <div class="col metric1">
                                    <p class="metricvalue">
                                        <?php echo number_format($totalposts, 0, '.', ','); ?>
                                    </p>
                                    <p class="metricdesc">Total Posts</p>
                                </div>
                                <div class="col metric3">
                                    <p class="metricvalue">
                                        <?php echo number_format($vacantposts, 0, '.', ','); ?>
                                    </p>
                                    <p class="metricdesc">Vacant Posts</p>
                                </div>
                                <div class="col metric2">
                                    <p class="metricvalue">
                                        <?php echo number_format($filledposts, 0, '.', ','); ?>
                                    </p>
                                    <p class="metricdesc">Encumbered Posts</p>
                                </div>
                                <div class="col metric4">
                                    <p class="metricvalue">
                                        <?php echo number_format((($femaleposts/max($filledposts,1))*100),0); ?>%
                                    </p>
                                    <p class="metricdesc">Female</p>
                                </div>
                                <div class="col metric5">
                                    <p class="metricvalue">
                                        <?php echo number_format((($maleposts/max($filledposts,1))*100),0); ?>%
                                    </p>
                                    <p class="metricdesc">Male</p>
                                </div>
                            </div>
                            <div id="hrfilled_chart"></div>
                            <script type="text/javascript">
                                Highcharts.chart('hrfilled_chart', {
                                    colors: ['rgb(220,53,69,0.6)','rgb(104,135,83,0.6)'],
                                    /*colors: ['rgb(220,53,69,0.7)','rgb(112,112,112,0.7)'],*/
                                    credits: {
                                        text: ''
                                    },
                                    chart: {
                                        type: 'bar',
                                        height: 260,
                                        backgroundColor: 'transparent'
                                    },
                                    title: {
                                        text: 'Figure 5: Post Occupancy',
                                        floating: false,
                                        align: 'left',
                                        verticalAlign: 'top',
                                        margin: 20,
                                        style: {
                                            color: '#707070',
                                            fontSize: '10px',
                                            fontWeight: '900',
                                            textTransform: 'none',
                                            textDecoration: 'underline'

                                        },
                                        x: 0,
                                        y: 0
                                    },
                                    xAxis: {
                                        categories: <?php echo json_encode($processed_divisiondata[$division]["hrpostscategories"]); ?>,
                                        labels: {
                                            style: {
                                                fontSize: '0.2cm'
                                            }
                                        }
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: ''
                                        }
                                    },
                                    legend: {
                                        reversed: true,
                                        style: {
                                            fontSize: '9px'
                                        }
                                    },
                                    plotOptions: {
                                        bar: {
                                            pointPadding: 0.2,
                                            borderWidth: 0,
                                            dataLabels: {
                                                enabled: false,
                                                formatter: function() {
                                                    return '' + Highcharts.numberFormat(this.y,0) + '';
                                                }
                                            }
                                        },
                                        series: {
                                            stacking: 'normal',
                                            pointWidth: 10,
                                            groupPadding: 0,
                                            pointPadding: 0.1,
                                            borderWidth: 0
                                        }
                                    },
                                    series: [{
                                        name: 'Vacant',
                                        data: <?php echo json_encode($processed_divisiondata[$division]["hrpostsvacant"]); ?>,
                                        showInLegend: true
                                    }, {
                                        name: 'Filled',
                                        data: <?php echo json_encode($processed_divisiondata[$division]["hrpostsfilled"]); ?>,
                                        showInLegend: true
                                    }]
                                });
                            </script>
                        </div>
                    </div>

                    <div class="row chartrender">
                        <div class="col-md-12 hrgender">
                            <div id="hrgender_chart"></div>
                            <script type="text/javascript">
                                Highcharts.chart('hrgender_chart', {
                                    colors: ['#17a2b8','#d59442'],
                                    chart: {
                                        type: 'bar',
                                        height: 250,
                                        backgroundColor: 'transparent'
                                    },
                                    credits: {
                                        text: ''
                                    },
                                    title: {
                                        text: 'Figure 6: Gender Balance',
                                        floating: false,
                                        align: 'left',
                                        verticalAlign: 'top',
                                        margin: 20,
                                        style: {
                                            color: '#707070',
                                            fontSize: '10px',
                                            fontWeight: '900',
                                            textTransform: 'none',
                                            textDecoration: 'underline'

                                        },
                                        x: 0,
                                        y: 0
                                    },
                                    subtitle: {
                                        text: ''
                                    },
                                    tooltip: {
                                        enabled: false
                                    },
                                    accessibility: {
                                        point: {
                                            valueDescriptionFormat: '{index}. Age {xDescription}, {value}%.'
                                        },
                                        enabled: false
                                    },
                                    xAxis: [{
                                        categories: <?php echo json_encode($processed_divisiondata[$division]["hrpostscategories"]); ?>,
                                        reversed: true,
                                        labels: {
                                            style: {
                                                fontSize: '0.2cm'
                                            },
                                            step: 1
                                        }
                                    }, { // mirror axis on right side
                                        opposite: true,
                                        reversed: true,
                                        categories: <?php echo json_encode($processed_divisiondata[$division]["hrpostscategories"]); ?>,
                                        linkedTo: 0,
                                        labels: {
                                            style: {
                                                fontSize: '0.2cm'
                                            },
                                            step: 1
                                        }
                                    }],
                                    yAxis: {
                                        max:100,
                                        min:-100,
                                        title: {
                                            text: null
                                        },
                                        labels: {
                                            formatter: function () {
                                                return Math.abs(this.value) + '%';
                                            }
                                        },
                                        accessibility: {
                                            description: 'Percentage population',
                                            rangeDescription: 'Range: 0 to 5%'
                                        }
                                    },

                                    plotOptions: {
                                        series: {
                                            stacking: 'normal'
                                        }
                                    },

                                    tooltip: {
                                        formatter: function () {
                                            return '<b>' + this.series.name + ', age ' + this.point.category + '</b><br/>' +
                                                'Population: ' + Highcharts.numberFormat(Math.abs(this.point.y), 1) + '%';
                                        },
                                        enabled: false
                                    },
                                    series: [{
                                        name: 'Female',
                                        data: <?php echo str_replace('"', '', json_encode($processed_divisiondata[$division]["hrpostsfilledfemale"])); ?>
                                    },{
                                        name: 'Male',
                                        data: <?php echo str_replace('"', '', json_encode($processed_divisiondata[$division]["hrpostsfilledmale"])); ?>
                                    }]
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <p class="quote">Do the difficult things while they are easy and do the great things while they are small. — LAO TZU</p>
            </div>




            <!--<div class="pagebreak"></div>-->
            <div class="row reportbody section2">
                <h2 class="sectiontitle">Annex 1: UNEP Programme Delivery Overview</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th class="left">Office</th>
                                <th class="center">Consumable</th>
                                <th class="center">Consumed</th>
                                <th class="center">Balance</th>
                                <th class="center">Budget to<br/>Staff Ratio</th>

                                <th class="center">Total<br/>Posts</th>
                                <th class="center">Encumbered<br/>Posts</th>
                                <th class="center">Vacant<br/>Posts</th>
                                <th class="center">%<br/>Vacancy</th>
                                <!--<th class="right">% Senior<br/>Posts<br/>(D2,D1,P5)</th>
                                <th class="right">Average<br/>Post Budget</th>-->
                                <th class="center">Total<br/>Projects</th>
                                <th class="center">Expired<br/>Projects</th>
                                <th class="center">% of Expired<br/>Projects</th>
                                <th class="center">Avg.<br/>Months<br/>Past Due</th>
                                <th class="center">Red<br/>Projects</th>
                                <th class="center">Yellow<br/>Projects</th>
                                <th class="center">Green<br/>Projects</th>
                                <th class="center">Reporting<br/>Compliance</th>
                                <th class="center">Total<br/>Outputs</th>
                                <th class="center">Completed<br/>Activities</th>
                                
                                <!--<th class="right">Short<br/>Projects %</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                            $counterlast;
                            $office_totalconsumable = 0;
                            $office_totalconsumed = 0;
                            $office_totalbalance = 0;
                            $office_totalposts = 0;
                            $office_totalfilledposts = 0;
                            $office_totalvacantposts = 0;
                            $office_totalvacancy = 0;
                            $office_totalsenior = 0;
                            $office_totalbudget= 0;
                            $office_totalprojects = 0;
                            $office_totalredprojects = 0;
                            $office_totalyellowprojects = 0;
                            $office_totalgreenprojects = 0;
                            $office_totalreportingcompliance = 0;
                            $office_totalexpired = 0;
                            $office_totalmonthspastdue = 0;
                            $office_count = count($processed_divisiondata[$division]["divisionlisting_office"]);
                            $office_totaloutputs = 0;
                            $office_totalactivities = 0;
                            $office_completedactivities = 0;

                            for ($i = 0; $i < $office_count; $i++) {
                                echo '<tr>';
                                echo '<td class="right">'.($i + 1).'.</td>';
                                echo '<td class="left">'.$processed_divisiondata[$division]["divisionlisting_office"][$i]['office'].'</td>';
                                echo '<td class="right">$ '.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['consumable']/1000000,1,'.',',').' M</td>';
                                echo '<td class="right">$ '.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['consumed']/1000000,1,'.',',').' M</td>';
                                echo '<td class="right">$ '.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['balance']/1000000,1,'.',',').' M</td>';
                                echo '<td class="right">$ '.number_format(($processed_divisiondata[$division]["divisionlisting_office"][$i]['consumable']/$processed_divisiondata[$division]["divisionlisting_office"][$i]['filled_posts'])/1000000,1,'.',',').' M</td>';
                                echo '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['total_posts'],0,'.',',').'</td>';

                                echo '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['filled_posts'],0,'.',',').'</td>';
                                echo '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['vacant_posts'],0,'.',',').'</td>';

                                echo '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['percentage_vacancy'],0,'.',',').'%</td>';
                                //echo '<td class="right">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['percentage_senior_posts'],0,'.',',').'%</td>';
                                //echo '<td class="right">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['average_post_budget'],0,'.',',').'</td>';
                                echo '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['total_projects'],0,'.',',').'</td>';
                                echo '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['expired_projects'],0,'.',',').'</td>';
                                echo '<td class="center">'.number_format(($processed_divisiondata[$division]["divisionlisting_office"][$i]['expired_projects']*100/$processed_divisiondata[$division]["divisionlisting_office"][$i]['total_projects']),0,'.',',').'%</td>';
                                echo '<td class="center">'.number_format(abs($processed_divisiondata[$division]["divisionlisting_office"][$i]['average_months_past_due']),0,'.',',').'</td>';

                                echo '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['red_projects'],0,'.',',').'</td>';
                                echo '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['yellow_projects'],0,'.',',').'</td>';
                                echo '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['green_projects'],0,'.',',').'</td>';
                                echo '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['reporting_compliance'],0,'.',',').'%</td>';
                                echo '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['total_outputs'],0,'.',',').'</td>';
                                echo '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['completed_activities'],0,'.',',').' / '.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['total_activities'],0,'.',',').'</td>';
                                
                                //echo '<td class="right">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['short_projects_percentage'],0,'.',',').'%</td>';
                                echo '</tr>';

                                $office_totalconsumable += $processed_divisiondata[$division]["divisionlisting_office"][$i]['consumable'];
                                $office_totalconsumed += $processed_divisiondata[$division]["divisionlisting_office"][$i]['consumed'];
                                $office_totalbalance += $processed_divisiondata[$division]["divisionlisting_office"][$i]['balance'];
                                $office_totalposts += $processed_divisiondata[$division]["divisionlisting_office"][$i]['total_posts'];
                                $office_totalfilledposts += $processed_divisiondata[$division]["divisionlisting_office"][$i]['filled_posts'];
                                $office_totalvacantposts += $processed_divisiondata[$division]["divisionlisting_office"][$i]['vacant_posts'];
                                $office_totalvacancy += $processed_divisiondata[$division]["divisionlisting_office"][$i]['percentage_vacancy'];
                                $office_totalsenior += $processed_divisiondata[$division]["divisionlisting_office"][$i]['percentage_senior_posts'];
                                $office_totalbudget += $processed_divisiondata[$division]["divisionlisting_office"][$i]['average_post_budget'];
                                $office_totalprojects += $processed_divisiondata[$division]["divisionlisting_office"][$i]['total_projects'];
                                $office_totalredprojects += $processed_divisiondata[$division]["divisionlisting_office"][$i]['red_projects'];
                                $office_totalyellowprojects += $processed_divisiondata[$division]["divisionlisting_office"][$i]['yellow_projects'];
                                $office_totalgreenprojects += $processed_divisiondata[$division]["divisionlisting_office"][$i]['green_projects'];
                                $office_totalreportingcompliance += $processed_divisiondata[$division]["divisionlisting_office"][$i]['reporting_compliance'];
                                $office_totalexpired += $processed_divisiondata[$division]["divisionlisting_office"][$i]['expired_projects'];
                                $office_totalmonthspastdue += $processed_divisiondata[$division]["divisionlisting_office"][$i]['average_months_past_due'];

                                $office_totaloutputs += $processed_divisiondata[$division]["divisionlisting_office"][$i]['total_outputs'];
                                $office_totalactivities += $processed_divisiondata[$division]["divisionlisting_office"][$i]['total_activities'];
                                $office_completedactivities += $processed_divisiondata[$division]["divisionlisting_office"][$i]['completed_activities'];

                                $counterlast = $i;
                            }

                            echo '<tr style="font-style:italic; font-weight:500;" class="summary">';
                            echo '<td class="right">&nbsp;</td>';
                            echo '<td class="left">Office Summary</td>';
                            echo '<td class="right">$ '.number_format($office_totalconsumable/1000000,1,'.',',').' M</td>';
                            echo '<td class="right">$ '.number_format($office_totalconsumed/1000000,1,'.',',').' M</td>';
                            echo '<td class="right">$ '.number_format($office_totalbalance/1000000,1,'.',',').' M</td>';

                            echo '<td class="right">$ '.number_format(($office_totalconsumable/$office_totalfilledposts)/1000000,1,'.',',').' M</td>';

                            echo '<td class="center">'.number_format($office_totalposts,0,'.',',').'</td>';
                            echo '<td class="center">'.number_format($office_totalfilledposts,0,'.',',').'</td>';
                            echo '<td class="center">'.number_format($office_totalvacantposts,0,'.',',').'</td>';
                            echo '<td class="center">'.number_format(($office_totalvacancy/$office_count),0,'.',',').'%</td>';
                            //echo '<td class="right">'.number_format(($office_totalsenior/$office_count),0,'.',',').'%</td>';
                            //echo '<td class="right">'.number_format($office_totalbudget,0,'.',',').'</td>';
                            echo '<td class="center">'.number_format($office_totalprojects,0,'.',',').'</td>';
                            echo '<td class="center">'.number_format($office_totalexpired,0,'.',',').'</td>';
                            echo '<td class="center">'.number_format(($office_totalexpired*100/$office_totalprojects),0,'.',',').'%</td>';
                            echo '<td class="center">'.number_format(abs($processed_divisiondata[$division]["avgmonthspastdue_division"]), 0, '.', ',').'</td>';

                            echo '<td class="center">'.number_format($office_totalredprojects,0,'.',',').'</td>';
                            echo '<td class="center">'.number_format($office_totalyellowprojects,0,'.',',').'</td>';
                            echo '<td class="center">'.number_format($office_totalgreenprojects,0,'.',',').'</td>';
                            echo '<td class="center">'.number_format(($office_totalreportingcompliance/$office_count),0,'.',',').'%</td>';

                            echo '<td class="center">'.number_format($office_totaloutputs,0,'.',',').'</td>';
                            echo '<td class="center">'.number_format($office_completedactivities,0,'.',',').' / '.number_format($office_totalactivities,0,'.',',').'</td>';
                            
                            //echo '<td class="right">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['short_projects_percentage'],0,'.',',').'%</td>';
                            echo '</tr>';



                            $region_totalconsumable = 0;
                            $region_totalconsumed = 0;
                            $region_totalbalance = 0;
                            $region_totalposts = 0;
                            $region_totalfilledposts = 0;
                            $region_totalvacantposts = 0;
                            $region_totalvacancy = 0;
                            $region_totalsenior = 0;
                            $region_totalbudget= 0;
                            $region_totalprojects = 0;
                            $region_totalredprojects = 0;
                            $region_totalyellowprojects = 0;
                            $region_totalgreenprojects = 0;
                            $region_totalreportingcompliance = 0;
                            $region_totalexpired = 0;
                            $region_totalmonthspastdue = 0;
                            $region_count = count($processed_divisiondata[$division]["divisionlisting_region"]);
                            $region_totaloutputs = 0;
                            $region_totalactivities = 0;
                            $region_completedactivities = 0;


                            

                            for ($i=0; $i < count($processed_divisiondata[$division]["divisionlisting_region"]); $i++) {
                                echo '<tr>';
                                echo '<td class="right">'.($i + $counterlast + 2).'.</td>';
                                echo '<td class="left">'.$processed_divisiondata[$division]["divisionlisting_region"][$i]['office'].'</td>';
                                echo '<td class="right">$ '.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['consumable']/1000000,1,'.',',').' M</td>';
                                echo '<td class="right">$ '.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['consumed']/1000000,1,'.',',').' M</td>';
                                echo '<td class="right">$ '.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['balance']/1000000,1,'.',',').' M</td>';

                                echo '<td class="right">$ '.number_format(($processed_divisiondata[$division]["divisionlisting_region"][$i]['consumable']/$processed_divisiondata[$division]["divisionlisting_region"][$i]['filled_posts'])/1000000,1,'.',',').' M</td>';






                                echo '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['total_posts'],0,'.',',').'</td>';
                                echo '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['filled_posts'],0,'.',',').'</td>';
                                echo '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['vacant_posts'],0,'.',',').'</td>';
                                echo '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['percentage_vacancy'],0,'.',',').'%</td>';
                                //echo '<td class="right">'.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['percentage_senior_posts'],0,'.',',').'%</td>';
                                //echo '<td class="right">'.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['average_post_budget'],0,'.',',').'</td>';
                                echo '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['total_projects'],0,'.',',').'</td>';
                                echo '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['expired_projects'],0,'.',',').'</td>';
                                echo '<td class="center">'.number_format(($processed_divisiondata[$division]["divisionlisting_region"][$i]['expired_projects']*100/$processed_divisiondata[$division]["divisionlisting_region"][$i]['total_projects']),0,'.',',').'%</td>';
                                echo '<td class="center">'.number_format(abs($processed_divisiondata[$division]["divisionlisting_region"][$i]['average_months_past_due']),0,'.',',').'</td>';

                                echo '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['red_projects'],0,'.',',').'</td>';
                                echo '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['yellow_projects'],0,'.',',').'</td>';
                                echo '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['green_projects'],0,'.',',').'</td>';
                                echo '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['reporting_compliance'],0,'.',',').'%</td>';
                                echo '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['total_outputs'],0,'.',',').'</td>';
                                echo '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['completed_activities'],0,'.',',').' / '.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['total_activities'],0,'.',',').'</td>';
                                
                                //echo '<td class="right">'.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['short_projects_percentage'],0,'.',',').'%</td>';
                                echo '</tr>';

                                $region_totalconsumable += $processed_divisiondata[$division]["divisionlisting_region"][$i]['consumable'];
                                $region_totalconsumed += $processed_divisiondata[$division]["divisionlisting_region"][$i]['consumed'];
                                $region_totalbalance += $processed_divisiondata[$division]["divisionlisting_region"][$i]['balance'];
                                $region_totalposts += $processed_divisiondata[$division]["divisionlisting_region"][$i]['total_posts'];

                                $region_totalfilledposts += $processed_divisiondata[$division]["divisionlisting_region"][$i]['filled_posts'];
                                $region_totalvacantposts += $processed_divisiondata[$division]["divisionlisting_region"][$i]['vacant_posts'];

                                $region_totalvacancy += $processed_divisiondata[$division]["divisionlisting_region"][$i]['percentage_vacancy'];
                                $region_totalsenior += $processed_divisiondata[$division]["divisionlisting_region"][$i]['percentage_senior_posts'];
                                $region_totalbudget += $processed_divisiondata[$division]["divisionlisting_region"][$i]['average_post_budget'];
                                $region_totalprojects += $processed_divisiondata[$division]["divisionlisting_region"][$i]['total_projects'];
                                $region_totalredprojects += $processed_divisiondata[$division]["divisionlisting_region"][$i]['red_projects'];
                                $region_totalyellowprojects += $processed_divisiondata[$division]["divisionlisting_region"][$i]['yellow_projects'];
                                $region_totalgreenprojects += $processed_divisiondata[$division]["divisionlisting_region"][$i]['green_projects'];
                                $region_totalreportingcompliance += $processed_divisiondata[$division]["divisionlisting_region"][$i]['reporting_compliance'];
                                $region_totalexpired += $processed_divisiondata[$division]["divisionlisting_region"][$i]['expired_projects'];
                                $region_totalmonthspastdue += $processed_divisiondata[$division]["divisionlisting_region"][$i]['average_months_past_due'];
                                $region_totaloutputs += $processed_divisiondata[$division]["divisionlisting_region"][$i]['total_outputs'];
                                $region_totalactivities += $processed_divisiondata[$division]["divisionlisting_region"][$i]['total_activities'];
                                $region_completedactivities += $processed_divisiondata[$division]["divisionlisting_region"][$i]['completed_activities'];
                            }

                            echo '<tr style="font-style:italic; font-weight:500;" class="summary">';
                            echo '<td class="right">&nbsp;</td>';
                            echo '<td class="left">Regional Summary</td>';
                            echo '<td class="right">$ '.number_format($region_totalconsumable/1000000,1,'.',',').' M</td>';
                            echo '<td class="right">$ '.number_format($region_totalconsumed/1000000,1,'.',',').' M</td>';
                            echo '<td class="right">$ '.number_format($region_totalbalance/1000000,1,'.',',').' M</td>';

                            echo '<td class="right">$ '.number_format(($region_totalconsumable/$region_totalfilledposts)/1000000,1,'.',',').' M</td>';



                            echo '<td class="center">'.number_format($region_totalposts,0,'.',',').'</td>';
                            echo '<td class="center">'.number_format($region_totalfilledposts,0,'.',',').'</td>';
                            echo '<td class="center">'.number_format($region_totalvacantposts,0,'.',',').'</td>';

                            echo '<td class="center">'.number_format(($region_totalvacancy/$region_count),0,'.',',').'%</td>';
                            //echo '<td class="right">'.number_format(($region_totalsenior/$region_count),0,'.',',').'%</td>';
                            //echo '<td class="right">'.number_format($region_totalbudget,0,'.',',').'</td>';
                            echo '<td class="center">'.number_format($region_totalprojects,0,'.',',').'</td>';
                            echo '<td class="center">'.number_format($region_totalexpired,0,'.',',').'</td>';
                            echo '<td class="center">'.number_format(($region_totalexpired*100/$region_totalprojects),0,'.',',').'%</td>';
                            echo '<td class="center">'.number_format(abs($processed_divisiondata[$division]["avgmonthspastdue_region"]), 0, '.', ',').'</td>';

                            echo '<td class="center">'.number_format($region_totalredprojects,0,'.',',').'</td>';
                            echo '<td class="center">'.number_format($region_totalyellowprojects,0,'.',',').'</td>';
                            echo '<td class="center">'.number_format($region_totalgreenprojects,0,'.',',').'</td>';
                            echo '<td class="center">'.number_format(($region_totalreportingcompliance/$region_count),0,'.',',').'%</td>';
                            echo '<td class="center">'.number_format($region_totaloutputs,0,'.',',').'</td>';
                            echo '<td class="center">'.number_format($region_completedactivities,0,'.',',').' / '.number_format($region_totalactivities,0,'.',',').'</td>';
                            
                            //echo '<td class="right">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['short_projects_percentage'],0,'.',',').'%</td>';
                            echo '</tr>';

                            echo '<tr style="font-style:italic; font-weight:500;" class="summarytotal">';
                            echo '<td class="right">&nbsp;</td>';
                            echo '<td class="left">Total UNEP Summary</td>';
                            echo '<td class="right">$ '.number_format(($office_totalconsumable+$region_totalconsumable)/1000000,1,'.',',').' M</td>';
                            echo '<td class="right">$ '.number_format(($office_totalconsumed+$region_totalconsumed)/1000000,1,'.',',').' M</td>';
                            echo '<td class="right">$ '.number_format(($office_totalbalance+$region_totalbalance)/1000000,1,'.',',').' M</td>';
                            echo '<td class="right">$ '.number_format((($office_totalconsumable+$region_totalconsumable) / ($office_totalfilledposts+$region_totalfilledposts))/1000000,1,'.',',').' M</td>';





                            echo '<td class="center">'.number_format(($office_totalposts+$region_totalposts),0,'.',',').'</td>';

                            echo '<td class="center">'.number_format(($office_totalfilledposts+$region_totalfilledposts),0,'.',',').'</td>';
                            echo '<td class="center">'.number_format(($office_totalvacantposts+$region_totalvacantposts),0,'.',',').'</td>';


                            echo '<td class="center">'.number_format(( (($office_totalvacancy/$office_count) + ($region_totalvacancy/$region_count)) / 2),0,'.',',').'%</td>';
                            //echo '<td class="right">'.number_format(((($office_totalsenior/$office_count) + ($region_totalsenior/$region_count))/2),0,'.',',').'%</td>';
                            //echo '<td class="right">'.number_format(($office_totalbudget+$region_totalbudget),0,'.',',').'</td>';
                            echo '<td class="center">'.number_format(($office_totalprojects+$region_totalprojects),0,'.',',').'</td>';
                            echo '<td class="center">'.number_format(($office_totalexpired+$region_totalexpired),0,'.',',').'</td>';

                            echo '<td class="center">'.number_format((($office_totalexpired+$region_totalexpired)*100/($office_totalprojects+$region_totalprojects)),0,'.',',').'%</td>';






                            echo '<td class="center">'.number_format(abs($processed_divisiondata[$division]["avgmonthspastdue"]), 0, '.', ',').'</td>';



                            echo '<td class="center">'.number_format(($office_totalredprojects+$region_totalredprojects),0,'.',',').'</td>';
                            echo '<td class="center">'.number_format(($office_totalyellowprojects+$region_totalyellowprojects),0,'.',',').'</td>';
                            echo '<td class="center">'.number_format(($office_totalgreenprojects+$region_totalgreenprojects),0,'.',',').'</td>';
                            echo '<td class="center">'.number_format(((($office_totalreportingcompliance/$office_count)+($region_totalreportingcompliance/$region_count))/2),0,'.',',').'%</td>';

                            echo '<td class="center">'.number_format(($office_totaloutputs+$region_totaloutputs),0,'.',',').'</td>';
                            echo '<td class="center">'.number_format(($office_completedactivities+$region_completedactivities),0,'.',',').' / '.number_format(($office_totalactivities+$region_totalactivities),0,'.',',').'</td>';

                            
                            //echo '<td class="right">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['short_projects_percentage'],0,'.',',').'%</td>';
                            echo '</tr>';
                            ?>
                        </tbody>
                    </table>
                </div>
            </div><?php exit; ?>
            <!--<div class="pagebreak"></div>-->
            <div class="row reportbody section3">
                <h2 class="sectiontitle">Annex 2: Vacant Positions Table</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>Grade</th>
                                <th>Position Title</th>
                                <th>Position Number</th>
                                <th>Duty Station</th>
                                <th>Fund</th>
                                <th>Org Code</th>
                                <th>Org Unit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $j = 0;
                            for ($i = 0; $i < count($processed_divisiondata[$division]["stafflisting"]); $i++) {
                                if ($processed_divisiondata[$division]["stafflisting"][$i]['position_status'] == 'VACANT') {
                                    echo '<tr>';
                                    echo '<td>' . ($j + 1) . '.</td>';
                                    echo '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['grade'] . '</td>';
                                    echo '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['position_title'] . '</td>';
                                    echo '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['position_number'] . '</td>';
                                    echo '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['duty_station'] . '</td>';
                                    echo '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['category'] . '</td>';
                                    echo '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['org_code'] . '</td>';
                                    echo '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['org_unit_description'] . '</td>';
                                    echo '</tr>';
                                    $j++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--<div class="pagebreak"></div>-->
            <div class="row reportbody section3">
                <h2 class="sectiontitle">Annex 3: Encumbered Positions Table</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>Grade</th>
                                <th>Position Title</th>
                                <th>Position Number</th>
                                <th>Duty Station</th>
                                <!--<th>Fund</th>-->
                                <th>Staff Name</th>
                                <th>Org Code</th>
                                <th>Org Unit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
$j = 0;
for ($i = 0; $i < count($processed_divisiondata[$division]["stafflisting"]); $i++) {
    if ($processed_divisiondata[$division]["stafflisting"][$i]['position_status'] == 'FILLED') {
        echo '<tr>';
        echo '<td>' . ($j + 1) . '.</td>';
        echo '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['grade'] . '</td>';
        echo '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['position_title'] . '</td>';
        echo '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['position_number'] . '</td>';
        echo '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['duty_station'] . '</td>';
        //echo '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['fund'] . '</td>';
        echo '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['staff_name'] . '</td>';
        echo '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['org_code'] . '</td>';
        echo '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['org_unit_description'] . '</td>';
        echo '</tr>';
        $j++;
    }
}
?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- End of .toprint -->
    </div><!-- End of .container-fluid -->
    </div><!-- End of #to_export -->

    <!-- HTML TO PDF  FUNCTION TO EXPORT THE DOCUMENT -->
    <script>
function jsp(){
    var element = document.getElementById('toprint');
    var opt = {
        margin: 0,
        filename: '<?php echo $processed_divisiondata[$division]["entity"]; ?> pimsreport.pdf',
        image: { type: 'jpeg', quality: 75 },
        //html2canvas:  {​​ scale: 0.8 }​​,
        html2canvas:{dpi:600, letterRendering:true},
        //pagebreak: { mode: 'avoid-all', after: '#page1el' },
        //pagebreak: {​​ avoid: 'tr'}​​,
        jsPDF: { unit: 'in', format: 'a4', orientation: 'landscape' }
    };

    // New Promise-based usage:
    html2pdf().set(opt).from(element).save();

    // Old monolithic-style usage:
    // html2pdf(element, opt);
}
</script>
</body>
</html>
