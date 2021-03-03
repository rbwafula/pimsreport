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
    <script src="assets/vendor/highcharts/v9.0.1/highcharts.js"></script>
    <script src="assets/vendor/highcharts/v9.0.1/highcharts-more.js"></script>
    <script src="assets/vendor/highcharts/v9.0.1/solid-gauge.js"></script>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
    <script src="assets/js/main.js"></script>

    <!-- HTML TO PDF LIB LOADED -->
    <!--<script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>-->

    <script src="assets/vendor/canvg/canvg.min.js"></script>
    <script src="assets/vendor/html2canvas/html2canvas.min.js"></script>
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
                    <h1 class="h2">Corporate Dashboard</h1>
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
            <div id="dashboardcanvas">
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
                                            <?php echo number_format($processed_divisiondata[$division]["activeconsultants"],0); ?>
                                        </p>
                                        <p class="metricdesc">Active<br/>Consultants</p>
                                    </div>
                                    <div class="col metric1">
                                        <p class="metricvalue">
                                            <?php echo number_format($totalposts, 0, '.', ','); ?>
                                        </p>
                                        <p class="metricdesc">Total<br/>Posts</p>
                                    </div>
                                    <div class="col metric3">
                                        <p class="metricvalue">
                                            <?php echo number_format($vacantposts, 0, '.', ','); ?>
                                        </p>
                                        <p class="metricdesc">Vacant<br/>Posts</p>
                                    </div>
                                    <div class="col metric2">
                                        <p class="metricvalue">
                                            <?php echo number_format($filledposts, 0, '.', ','); ?>
                                        </p>
                                        <p class="metricdesc">Encumbered<br/>Posts</p>
                                    </div>
                                    <!--<div class="col metric4">
                                        <p class="metricvalue">
                                            <?php //echo number_format((($femaleposts/max($filledposts,1))*100),0); ?>%
                                        </p>
                                        <p class="metricdesc">Female</p>
                                    </div>
                                    <div class="col metric5">
                                        <p class="metricvalue">
                                            <?php //echo number_format((($maleposts/max($filledposts,1))*100),0); ?>%
                                        </p>
                                        <p class="metricdesc">Male</p>
                                    </div>-->
                                     <div class="col metric6">
                                        <p class="metricvalue">
                                            <?php echo number_format($processed_divisiondata[$division]["epass_compliance"],0); ?>%
                                        </p>
                                        <p class="metricdesc">ePAS<br/>Compliance</p>
                                    </div>
                                     <div class="col metric6">
                                        <p class="metricvalue">
                                            <?php echo number_format($processed_divisiondata[$division]["mandatory_training_completion"],0); ?>%
                                        </p>
                                        <p class="metricdesc">Mandatory<br/>Training</p>
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
                                            name: 'Encumbered',
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
                                    var chart = new Highcharts.Chart({
                                        chart: {
                                            renderTo: 'hrgender_chart',
                                            type: 'bar',
                                            height: 250,
                                            backgroundColor: 'transparent'
                                            /*,
                                            events: {
                                                load: function() {
                                                    var chart = this,
                                                    series = chart.series,
                                                    seriesSum = 0;
                                                    seriesElements = 0;
                                                    series.forEach(function(series) {
                                                        series.data.forEach(function(point) {
                                                        seriesSum += point.y;
                                                        seriesElements += 1;
                                                        })
                                                    })
                                                    chart.renderer.text('62%' + seriesSum, 100, 10)
                                                    .css({
                                                        fontWeight: 600
                                                    })
                                                    .add()
                                                }
                                            }*/
                                        },
                                        colors: ['#d59442','#17a2b8'],
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
                                            enabled: true
                                        },
                                        series: [{
                                            name: 'Female',
                                            data: <?php echo str_replace('"', '', json_encode($processed_divisiondata[$division]["hrpostsfilledfemale"])); ?>
                                        },{
                                            name: 'Male',
                                            data: <?php echo str_replace('"', '', json_encode($processed_divisiondata[$division]["hrpostsfilledmale"])); ?>
                                        }]
                                    }, function(chart){
                                        //setTimeout(savedashboard(), 10000);
                                        chart.renderer.text('<p style="text-align:center; font-weight:600;"><?php echo number_format((($femaleposts/max($filledposts,1))*100),0); ?>%</p>', 30, 227).css({
                                            color: '#d59442',
                                            textAlign: 'center'
                                        })
                                        .add();

                                        chart.renderer.text('<p style="text-align:center; font-weight:600;"><?php echo number_format((($maleposts/max($filledposts,1))*100),0); ?>%</p>', 270, 227).css({
                                            color: '#17a2b8',
                                            textAlign: 'center'
                                        })
                                        .add();
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                    <p class="quote">Do the difficult things while they are easy and do the great things while they are small. — LAO TZU</p>
                </div>
            </div><!-- End of #dashboardcanvas -->
            
            <div id="dashboardimg" style="display:none;">
                <img src="" id="newimg" class="top" />
            </div>
            <div class="pagebreak"></div>

            <!-- new dashboard: Finance -->
            <div id="dashboard2" class="row reportbody section1" style="background-color:#f9f9f9;">
                <div class="col-md-4">
                    <h5 class="sectiontitle">Finance</h5>
                    <?php
                        array_multisort(array_column($processed_divisiondata[$division]["grantsdata"], 'grantenddate'), SORT_ASC,$processed_divisiondata[$division]["grantsdata"]);
                        $totalgrants_count = 0;
                        $totalexpired_count = 0;
                        $totalnegative_count = 0;
                        $sixmonthexpiry_count = 0;
                        $totalgrants_amount = 0;
                        $totalexpired_amount = 0;
                        $totalnegative_amount = 0;
                        $sixmonthexpiry_amount = 0;
                        foreach ($processed_divisiondata[$division]["grantsdata"] as $key => $value) {
                            if (number_format($value["grantamount"],0,".",",") != "0") {
                                $totalgrants_count++; // count the grant
                                $totalgrants_amount += $value["grantamount"]; // count the grant
                                if ($value["grantexpired"] == "YES") {
                                    $totalexpired_count++; // count as expired
                                    $totalexpired_amount += $value["grantamount"]; // add to the dollar value
                                }
                                if ($value["grantamount"] < 0) {
                                    $totalnegative_count++;  // count as negative
                                    $totalnegative_amount += $value["grantamount"]; // add to the dollar
                                }
                                if ($value["grantenddate"] > date("Y-m-d", strtotime("now")) && $value["grantenddate"] <= date("Y-m-d", strtotime("+6 month"))) {
                                    $sixmonthexpiry_count++;  // count as 6months to expiry
                                    $sixmonthexpiry_amount += $value["grantamount"]; // add to the dollar
                                }
                            }
                        }
                    ?>
                    <div class="row summarystatistics pb-20">
                        <div class="col metric1">
                            <p class="metricvalue"><?php echo number_format($totalgrants_count,0); ?></p>
                            <p class="metricdesc">Total Grants</p>
                        </div>
                        <div class="col metric1">
                            <p class="metricvalue">$ <?php echo number_format( ($totalgrants_amount/1000000),1,".",","); ?>M</p>
                            <p class="metricdesc">Total Grant Amount</p>
                        </div>
                        <div class="col metric1">
                            &nbsp;
                        </div>
                    </div>
                    <div class="row summarystatistics pb-20">
                        <div class="col metric2">
                            <p class="metricvalue"><?php echo number_format($sixmonthexpiry_count);?></p>
                            <p class="metricdesc">Grants Expiring in 6 Months</p>
                        </div>
                        <div class="col metric2">
                            <p class="metricvalue">$ <?php echo number_format(($sixmonthexpiry_amount/1000000),1,".",","); ?>M</p>
                            <p class="metricdesc">Amount of Grants Expiring in 6 Months</p>
                        </div>
                        <div class="col metric2">
                            <p class="metricvalue"><?php echo number_format(($sixmonthexpiry_count*100/max($totalgrants_count,1)),0,".",","); ?>%</p>
                            <p class="metricdesc">% of Grants Expiring in 6 Months</p>
                        </div>
                    </div>
                    <div class="row summarystatistics pb-20">
                        <div class="col metric4">
                            <p class="metricvalue"><?php echo number_format($totalexpired_count,0); ?></p>
                            <p class="metricdesc">Expired Grants</p>
                        </div>
                        <div class="col metric4">
                            <p class="metricvalue">$ <?php echo number_format(($totalexpired_amount/1000000),1,".",","); ?>M</p>
                            <p class="metricdesc">Amount of Expired Grants</p>
                        </div>
                        <div class="col metric4">
                            <p class="metricvalue"><?php echo number_format(($totalexpired_count*100/max($totalgrants_count,1)),0,".",","); ?>%</p>
                            <p class="metricdesc">% of Expired Grants</p>
                        </div>
                    </div>
                    <div class="row summarystatistics pb-20">
                        <div class="col metric4">
                            <p class="metricvalue"><?php echo number_format($totalnegative_count,0); ?></p>
                            <p class="metricdesc">Negative Grants</p>
                        </div>
                        <div class="col metric4">
                            <p class="metricvalue">$ (<?php echo number_format((abs($totalnegative_amount)/1000000),1,".",","); ?>)M</p>
                            <p class="metricdesc">Amount of Negative Grants</p>
                        </div>
                        <div class="col metric4">
                            <p class="metricvalue"><?php echo number_format(($totalnegative_count*100/max($totalgrants_count,1)),0,".",","); ?>%</p>
                            <p class="metricdesc">% of Negative Grants</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">

                </div>
                <div class="col-md-4">
                    
                    
                </div>
            </div>
            <!-- end of new dashboard: Finance -->

            <!--<div id="dashboardimg2" style="display:none;">
                <img src="" id="newimg2" class="top" />
            </div>-->
            <div class="pagebreak"></div>








            <!-- new dashboard: Human Resource -->
            <div id="dashboard3" class="row reportbody section1" style="background-color:#f9f9f9;">
                <div class="col-md-4">
                    <h5 class="sectiontitle">Human Resource</h5>

                    <?php
                        $seniorstaffretiring_count = 0;
                        $expiringstaffcontracts_count = 0;
                        $hrfilledpositionsfundingtypes_categories = [];
                        $hrfilledpositionsfundingtypes_data = [];
                        $hrfilledpositionsfundingtypes_categories_xaxis = [];
                        $hrfilledpositionsfundingtypes_categories_series = [];

                        foreach ($processed_divisiondata[$division]["stafflisting"] as $key => $value) {
                            if ($value["position_status"] == "FILLED") {
                                $hrfilledpositionsfundingtypes_categories[] = $value["category"];
                                $seniorposts = ['USG', 'ASG', 'D-2', 'D-1', 'P-5'];
                                if ( in_array($value["grade"], $seniorposts) && $value["retirement_date"] <= date("Y-m-d", strtotime("+24 month")) ) {
                                    $seniorstaffretiring_count++;
                                }
                                if ( $value["contract_expiry"] <= date("Y-m-d", strtotime("+6 month")) ) {
                                    $expiringstaffcontracts_count++;
                                }
                            }
                        }foreach (array_count_values($hrfilledpositionsfundingtypes_categories) as $key => $value) {
                            $hrfilledpositionsfundingtypes_data[] = [
                                "name" => $key,
                                "count" => $value
                            ];
                        }
                        array_multisort(array_column($hrfilledpositionsfundingtypes_data, 'count'), SORT_DESC,$hrfilledpositionsfundingtypes_data);

                        foreach ($hrfilledpositionsfundingtypes_data as $key => $value) {
                            $hrfilledpositionsfundingtypes_categories_xaxis[] = $value["name"];
                            $hrfilledpositionsfundingtypes_categories_series[] = $value["count"];
                        }
                        $consultantsmorethan11months_count = 0;
                        foreach ($processed_divisiondata[$division]["consultants_data"] as $key => $value) {
                            if ($value["expired"] == "NO" && $value["morethan11months"] == "Yes") {
                                $consultantsmorethan11months_count++;
                            }
                        }
                    ?>

                    <div class="row summarystatistics pb-20">
                        <div class="col metric1">
                            <p class="metricvalue"><?php echo number_format($seniorstaffretiring_count,0,".",","); ?></p>
                            <p class="metricdesc">Senior Positions<br/>Retiring in 2 Years<br/>(D2, D1, P5)</p>
                        </div>
                        <div class="col metric4">
                            <p class="metricvalue"><?php echo number_format($expiringstaffcontracts_count,0,".",","); ?></p>
                            <p class="metricdesc">Expiring Staff<br/>Contracts in 6 Months</p>
                        </div>
                        <div class="col metric1">
                            <p class="metricvalue"><?php echo number_format($consultantsmorethan11months_count,0,".",","); ?></p>
                            <p class="metricdesc">Consultancies More<br/>Than 11 Months</p>
                        </div>
                    </div>

                    <div id="hrfilledpositionsfundingtypes_chart"></div>
                    <script type="text/javascript">
                        Highcharts.chart('hrfilledpositionsfundingtypes_chart', {
                            colors: ['#0077b6'],
                            credits: {
                                text: ''
                            },
                            chart: {
                                backgroundColor: 'transparent',
                                type: 'bar',
                                height: 250
                            },
                            title: {
                                text: 'Figure n: Filled Positions by Funding Type',
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
                                categories: <?php echo json_encode($hrfilledpositionsfundingtypes_categories_xaxis); ?>,
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
                                bar: {
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
                                data: <?php echo json_encode($hrfilledpositionsfundingtypes_categories_series); ?>,
                                showInLegend: false

                            }]
                        });
                    </script>

                    <!--
                        consultancies more than 11 months
                        funding type for filled positions
                        senior positions retiring in 2 years
                    -->
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <!-- end of new dashboard: Audit Risks -->

            <!--<div id="dashboardimg4" style="display:none;">
                <img src="" id="newimg4" class="top" />
            </div>-->
            <div class="pagebreak"></div>









            <!-- new dashboard: Audit Risks -->
            <div id="dashboard4" class="row reportbody section1" style="background-color:#f9f9f9;">
                <div class="col-md-4">
                    <h5 class="sectiontitle">Audits &amp; Risks</h5>

                    <!-- Start of Top Risks -->
                    <?php
                        $toprisks_categories_xaxis = [];
                        $toprisks_categories_series = [];
                        array_multisort(array_column($processed_divisiondata[$division]["risks_data"], 'year'), SORT_ASC,$processed_divisiondata[$division]["risks_data"]);

                        foreach ($processed_divisiondata[$division]["risks_data"] as $key => $value) {
                            if ($value["year"] == date("Y", strtotime("now"))) {
                                /* If current year risk has not been captured before, add it to the array */
                                if (!in_array($value["riskname"], $toprisks_categories_xaxis)) {
                                    $toprisks_categories_xaxis[] = $value["riskname"];
                                    $toprisks_categories_series[] = (int)$value["projectcount"];
                                } else {
                                    /* Get key where the risk is in the array, and add the project count */
                                    $riskkey = array_search ($value["riskname"], $toprisks_categories_xaxis);
                                    $toprisks_categories_series[$riskkey] += (int)$value["projectcount"];
                                }
                            }
                            /*if ($value["year"] == date("Y", strtotime("now"))) {
                                $toprisks_categories_xaxis[] = $value["riskname"];
                                $toprisks_categories_series[] = (int)$value["projectcount"];
                            }*/
                        }
                    ?>
                    <div class="col-md-12 toprisks pb-20">
                        <div id="toprisks_chart"></div>
                        <script type="text/javascript">
                            Highcharts.chart('toprisks_chart', {
                                colors: ['#0077b6'],
                                credits: {
                                    text: ''
                                },
                                chart: {
                                    backgroundColor: 'transparent',
                                    type: 'bar',
                                    height: 220,
                                    marginLeft: 150
                                },
                                title: {
                                    text: 'Figure n: Top Risks Current Year',
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
                                    categories: <?php echo json_encode($toprisks_categories_xaxis); ?>,
                                    labels: {
                                        style: {
                                            fontSize: '0.25cm',
                                            fontWeight: 700
                                        },
                                        formatter: function() {
                                            var ret = this.value,
                                                len = ret.length;
                                            //console.log(len);
                                            /*if (len > 10) {
                                                ret = ret.split(' ')[0] + '<br/>' +ret.split(' ')[1]
                                            }
                                            if (len > 25) {
                                                ret = ret.slice(0, 25) + '...';
                                            }*/
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
                                    data: <?php echo json_encode($toprisks_categories_series); ?>,
                                    showInLegend: false

                                }]
                            });
                        </script>
                    </div>
                    <!-- End of Top Risks -->



                    <?php
                        $boa_priorities_xaxis = [];
                        $boa_priorities_elapsed = [];
                        $boa_priorities_current = [];
                        $boa_priorities_total = [];
                        $boa_elapsedpriorities_seriesdata;
                        $boa_currentpriorities_seriesdata;
                        $boa_totalpriorities_seriesdata;

                        // BOAs by Office
                        $boa_offices = [];
                        $boa_offices_xaxis = [];
                        $boa_offices_series = [];

                        // BOAs by Audit Year
                        $boa_audityear = [];
                        $boa_audityear_xaxis = [];
                        $boa_audityear_series = [];

                        // BOA by TargetDate
                        $boa_targetdate_3months = 0;
                        $boa_targetdate_6months = 0;
                        $boa_targetdate_9months = 0;
                        $boa_targetdate_12months = 0;
                        $boa_targetdate_over12 = 0;
                        $boa_targetdate_elapsed = 0;

                        // BOAs by Status
                        $boa_status_red = 0;
                        $boa_status_yellow = 0;
                        $boa_status_green = 0;

                        // BOAs by Category
                        $boa_category = [];
                        $boa_category_xaxis = [];
                        $boa_category_series = [];

                        // BOAs by Suggested Status
                        $boa_suggestedstatus = [];
                        $boa_suggestedstatus_xaxis = [];
                        $boa_suggestedstatus_series = [];
                        $selectedboastatus = array("Under Implementation", "Not Implemented");
                        foreach ($processed_divisiondata[$division]["boa_data"] as $key => $value) {
                            if (in_array($value["suggestedstatusverified"], $selectedboastatus)) {
                                $priority = (rtrim(ltrim($value["priority"])) == "" ) ? "Not Defined" : rtrim(ltrim($value["priority"]));
                                if (!in_array($priority, $boa_priorities_xaxis)) {
                                    $boa_priorities_xaxis[] = $priority;
                                }
                                if (date("Y-m-d",time()) <= $value["targetdate"]) {
                                    $boa_priorities_current[] = $priority;
                                } else {
                                    $boa_priorities_elapsed[] = $priority;
                                }
                                $boa_priorities_total[] = $priority;
                                $boa_offices[] = ltrim(rtrim($value["office"]));
                                $boa_audityear[] = ltrim(rtrim($value["year"]));
                                $boa_category[] = ltrim(rtrim($value["category"]));
                                $boa_suggestedstatus[] = ltrim(rtrim($value["suggestedstatus"]));

                                // BOAs by Status
                                $elapsed = floor(getdaysbetween($value["year"]."/01/01",min(date("Y-m-d",time()),$value["targetdate"])));
                                $duration = ceil(getdaysbetween($value["year"]."/01/01",$value["targetdate"]));
                                $score = number_format(($elapsed*100/max($duration,1) ),0,'.',',');
                                if ($score >= 0 && $score < 75) {
                                    $boa_status_green++;
                                } else if ($score >= 75 && $score < 100) {
                                    $boa_status_yellow++;
                                } else {
                                    $boa_status_red++;
                                }


                                // BOAs by TargetDate
                                $td = $value["targetdate"];
                                if ($td >= date("Y-m-d", strtotime("now"))) {
                                    // Current
                                    if ($td <= date("Y-m-d", strtotime("+3 month"))) {
                                        $boa_targetdate_3months++;
                                    } else if ($td > date("Y-m-d", strtotime("+3 month")) && $td <= date("Y-m-d", strtotime("+6 month"))) {
                                        $boa_targetdate_6months++;
                                    } else if ($td > date("Y-m-d", strtotime("+6 month")) && $td <= date("Y-m-d", strtotime("+9 month"))) {
                                        $boa_targetdate_9months++;
                                    } else if ($td > date("Y-m-d", strtotime("+9 month")) && $td <= date("Y-m-d", strtotime("+12 month"))) {
                                        $boa_targetdate_12months++;
                                    } else {
                                        $boa_targetdate_over12++;
                                    }
                                } else {
                                    // Elapsed
                                    $boa_targetdate_elapsed++;
                                }
                            }
                        }
                        // initialize everything to zero
                        foreach ($boa_priorities_xaxis as $key => $value) {
                            $boa_currentpriorities_seriesdata[$value] = 0;
                            $boa_elapsedpriorities_seriesdata[$value] = 0;
                            $boa_totalpriorities_seriesdata[$value] = 0;

                        }
                        // Assign values to respective series data
                        foreach (array_count_values($boa_priorities_current) as $key => $value) {
                            $boa_currentpriorities_seriesdata[$key] = $value;
                        }
                        foreach (array_count_values($boa_priorities_elapsed) as $key => $value) {
                            $boa_elapsedpriorities_seriesdata[$key] = $value;
                        }
                        foreach (array_count_values($boa_priorities_total) as $key => $value) {
                            $boa_totalpriorities_seriesdata[$key] = $value;
                        }

                        // BOA by Offices
                        $boa_offices = array_count_values($boa_offices);
                        arsort($boa_offices);
                        foreach ($boa_offices as $key => $value) {
                            $boa_offices_xaxis[] = $key;
                            $boa_offices_series[] = $value;
                        }

                        // BOA by Audit Year
                        $boa_audityear = array_count_values($boa_audityear);
                        ksort($boa_audityear);
                        foreach ($boa_audityear as $key => $value) {
                            $boa_audityear_xaxis[] = $key;
                            $boa_audityear_series[] = $value;
                        }

                        // BOA by Category
                        $boa_category = array_count_values($boa_category);
                        arsort($boa_category);
                        foreach ($boa_category as $key => $value) {
                            $boa_category_xaxis[] = $key;
                            $boa_category_series[] = $value;
                        }


                        // BOA by Suggested Status
                        $boa_suggestedstatus = array_count_values($boa_suggestedstatus);
                        arsort($boa_suggestedstatus);
                        foreach ($boa_suggestedstatus as $key => $value) {
                            $boa_suggestedstatus_xaxis[] = $key;
                            $boa_suggestedstatus_series[] = $value;
                        }
                    ?>

                    <div class="col-md-12 boapriorities pb-20">
                        <div id="boapriorities_chart"></div>
                        <script type="text/javascript">
                            Highcharts.chart('boapriorities_chart', {
                                colors: ['#0077b6'],//colors: ['#688753','#dc3545'],
                                credits: {
                                    text: ''
                                },
                                chart: {
                                    backgroundColor: 'transparent',
                                    type: 'bar',
                                    height: 200
                                },
                                title: {
                                    text: 'Figure n: BOA by Priority',
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
                                    categories: <?php echo json_encode($boa_priorities_xaxis); ?>,
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
                                    bar: {
                                        pointPadding: 0.2,
                                        borderWidth: 0,
                                        stacking: 'normal',
                                        dataLabels: {
                                            enabled: true,
                                            formatter: function() {
                                                if(this.y != 0) {
                                                    return '' + Highcharts.numberFormat(this.y,0) + '';
                                                }
                                            }
                                        }
                                    },
                                    series: {
                                        groupPadding: 0,
                                        pointPadding: 0.1,
                                        borderWidth: 0
                                    }
                                },
                                /*legend: {
                                    align: 'right',
                                    x: -20,
                                    verticalAlign: 'top',
                                    y: 15,
                                    floating: true,
                                    backgroundColor:
                                        Highcharts.defaultOptions.legend.backgroundColor || 'white',
                                    borderColor: '#CCC',
                                    borderWidth: 1,
                                    shadow: false
                                },*/
                                series: [{
                                    name: 'BOAs',
                                    data: <?php echo json_encode(array_values($boa_totalpriorities_seriesdata)); ?>,
                                    showInLegend: false

                                }
                                /*,{
                                    name: 'Current',
                                    data: <?php echo json_encode(array_values($boa_currentpriorities_seriesdata)); ?>,
                                    showInLegend: true

                                },{
                                    name: 'Elapsed',
                                    data: <?php echo json_encode(array_values($boa_elapsedpriorities_seriesdata)); ?>,
                                    showInLegend: true

                                }*/]
                            });
                        </script>
                    </div>


                    <?php
                        $oios_categories_xaxis = [];
                        $oios_categories_series_elapsed = [];
                        $oios_categories_series_current = [];
                        $oios_categories_series_total = [];
                        $oios_elapsedseriesdata;
                        $oios_currentseriesdata;
                        $oios_totalseriesdata;

                        // OIOS by Office
                        $oios_offices = [];
                        $oios_offices_xaxis = [];
                        $oios_offices_series = [];

                        // OIOS by Audit Year
                        $oios_audityear = [];
                        $oios_audityear_xaxis = [];
                        $oios_audityear_series = [];

                        // OIOS by TargetDate
                        $oios_targetdate_3months = 0;
                        $oios_targetdate_6months = 0;
                        $oios_targetdate_9months = 0;
                        $oios_targetdate_12months = 0;
                        $oios_targetdate_over12 = 0;
                        $oios_targetdate_elapsed = 0;

                        foreach ($processed_divisiondata[$division]["oios_data"] as $key => $value) {
                            $priority = (rtrim(ltrim($value["recommendation_update"])) == "" ) ? "Not Defined" : rtrim(ltrim($value["recommendation_update"]));
                            if (!in_array($priority, $oios_categories_xaxis)) {
                                $oios_categories_xaxis[] = $priority;
                            }
                            if (date("Y-m-d",time()) <= $value["implementation_date"]) {
                                $oios_categories_series_current[] = $priority;
                            } else {
                                $oios_categories_series_elapsed[] = $priority;
                            }
                            $oios_categories_series_total[] = $priority;
                            $oios_offices[] = ltrim(rtrim($value["office"]));
                            $oios_audityear[] = ltrim(rtrim(date('Y', strtotime($value["issue_date"]))));

                            // BOAs by TargetDate
                            $td = $value["implementation_date"];
                            if ($td >= date("Y-m-d", strtotime("now"))) {
                                // Current
                                if ($td <= date("Y-m-d", strtotime("+3 month"))) {
                                    $oios_targetdate_3months++;
                                } else if ($td > date("Y-m-d", strtotime("+3 month")) && $td <= date("Y-m-d", strtotime("+6 month"))) {
                                    $oios_targetdate_6months++;
                                } else if ($td > date("Y-m-d", strtotime("+6 month")) && $td <= date("Y-m-d", strtotime("+9 month"))) {
                                    $oios_targetdate_9months++;
                                } else if ($td > date("Y-m-d", strtotime("+9 month")) && $td <= date("Y-m-d", strtotime("+12 month"))) {
                                    $oios_targetdate_12months++;
                                } else {
                                    $oios_targetdate_over12++;
                                }
                            } else {
                                // Elapsed
                                $oios_targetdate_elapsed++;
                            }
                        }

                        // initialize everything to zero
                        foreach ($oios_categories_xaxis as $key => $value) {
                            $oios_currentseriesdata[$value] = 0;
                            $oios_elapsedseriesdata[$value] = 0;
                        }
                        // Assign values to respective series data
                        foreach (array_count_values($oios_categories_series_current) as $key => $value) {
                            $oios_currentseriesdata[$key] = $value;
                        }
                        foreach (array_count_values($oios_categories_series_elapsed) as $key => $value) {
                            $oios_elapsedseriesdata[$key] = $value;
                        }
                        foreach (array_count_values($oios_categories_series_total) as $key => $value) {
                            $oios_totalseriesdata[$key] = $value;
                        }

                        // OIOS by Offices
                        $oios_offices = array_count_values($oios_offices);
                        arsort($oios_offices);
                        foreach ($oios_offices as $key => $value) {
                            $oios_offices_xaxis[] = $key;
                            $oios_offices_series[] = $value;
                        }

                        // OIOS by Audit Year
                        $oios_audityear = array_count_values($oios_audityear);
                        ksort($oios_audityear);
                        foreach ($oios_audityear as $key => $value) {
                            $oios_audityear_xaxis[] = $key;
                            $oios_audityear_series[] = $value;
                        }
                    ?>


                    <div class="col-md-12 oioscategories pb-20">
                        <div id="oioscategories_chart"></div>
                        <script type="text/javascript">
                            Highcharts.chart('oioscategories_chart', {
                                colors: ['#0077b6'],//colors: ['#688753','#dc3545'],
                                credits: {
                                    text: ''
                                },
                                chart: {
                                    backgroundColor: 'transparent',
                                    type: 'bar',
                                    height: 200
                                },
                                title: {
                                    text: 'Figure n: OIOS by Priority',
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
                                    categories: <?php echo json_encode($oios_categories_xaxis); ?>,
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
                                    bar: {
                                        pointPadding: 0.2,
                                        borderWidth: 0,
                                        stacking: 'normal',
                                        dataLabels: {
                                            enabled: true,
                                            formatter: function() {
                                                if(this.y != 0) {
                                                    return '' + Highcharts.numberFormat(this.y,0) + '';
                                                }
                                            }
                                        }
                                    },
                                    series: {
                                        groupPadding: 0,
                                        pointPadding: 0.1,
                                        borderWidth: 0
                                    }
                                },
                                /*legend: {
                                    align: 'right',
                                    x: -20,
                                    verticalAlign: 'top',
                                    y: 15,
                                    floating: true,
                                    backgroundColor:
                                        Highcharts.defaultOptions.legend.backgroundColor || 'white',
                                    borderColor: '#CCC',
                                    borderWidth: 1,
                                    shadow: false
                                },*/
                                series: [{
                                    name: 'OIOS',
                                    data: <?php echo json_encode(array_values($oios_totalseriesdata)); ?>,
                                    showInLegend: false
                                }
                                /*{
                                    name: 'Current',
                                    data: <?php echo json_encode(array_values($oios_currentseriesdata)); ?>,
                                    showInLegend: true

                                },{
                                    name: 'Elapsed',
                                    data: <?php echo json_encode(array_values($oios_elapsedseriesdata)); ?>,
                                    showInLegend: true

                                }*/]
                            });
                        </script>
                    </div>

                    

                    <!--
                        Project risks

                        -    top risks
                        -    BOA , OIOS

                        -    recommendation categories
                        -    priority
                        -    aging
                    -->
                </div>
                <div class="col-md-4">
                    <h5 class="sectiontitle">&nbsp;</h5>
                    <div id="boaoffices_chart"></div>
                    <script type="text/javascript">
                        Highcharts.chart('boaoffices_chart', {
                                colors: ['#0077b6'],
                                credits: {
                                    text: ''
                                },
                                chart: {
                                    backgroundColor: 'transparent',
                                    type: 'bar',
                                    height: 220
                                },
                                title: {
                                    text: 'Figure n: BOA by Office',
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
                                    categories: <?php echo json_encode($boa_offices_xaxis); ?>,
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
                                    bar: {
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
                                    name: 'Office',
                                    data: <?php echo json_encode($boa_offices_series); ?>,
                                    showInLegend: false

                                }]
                            });
                    </script>


                    <div id="boaaudityear_chart"></div>
                    <script type="text/javascript">
                        Highcharts.chart('boaaudityear_chart', {
                                colors: ['#0077b6'],
                                credits: {
                                    text: ''
                                },
                                chart: {
                                    backgroundColor: 'transparent',
                                    type: 'column',
                                    height: 220
                                },
                                title: {
                                    text: 'Figure n: BOA by Audit Year',
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
                                    categories: <?php echo json_encode($boa_audityear_xaxis); ?>,
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
                                    name: 'Office',
                                    data: <?php echo json_encode($boa_audityear_series); ?>,
                                    showInLegend: false

                                }]
                            });
                    </script>







                    <div id="boatargetdate_chart"></div>
                    <script type="text/javascript">
                        Highcharts.chart('boatargetdate_chart', {
                            colors: ['#0077b6'],
                            credits: {
                                text: ''
                            },
                            chart: {
                                backgroundColor: 'transparent',
                                type: 'column',
                                height: 200
                            },
                            title: {
                                text: 'Figure n: BOA by Target Date',
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
                                categories: ["Elapsed","0-3 Months", "3-6 Months", "6-9 Months", "9-12 Months", "Over 1year"],
                                labels: {
                                    useHTML:true,
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
                                    colorByPoint: false
                                }
                            },
                            series: [{
                                name: 'Target Date',
                                data: [<?php echo $boa_targetdate_elapsed; ?>,<?php echo $boa_targetdate_3months; ?>,<?php echo $boa_targetdate_6months; ?>,<?php echo $boa_targetdate_9months; ?>,<?php echo $boa_targetdate_12months; ?>,<?php echo $boa_targetdate_over12; ?>],
                                showInLegend: false

                            }]
                        });
                    </script>



                </div>
                <div class="col-md-4">
                    <h5 class="sectiontitle">&nbsp;</h5>
                    <div id="oiosoffices_chart"></div>
                    <script type="text/javascript">
                        Highcharts.chart('oiosoffices_chart', {
                                colors: ['#0077b6'],
                                credits: {
                                    text: ''
                                },
                                chart: {
                                    backgroundColor: 'transparent',
                                    type: 'bar',
                                    height: 220
                                },
                                title: {
                                    text: 'Figure n: OIOS by Office',
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
                                    categories: <?php echo json_encode($oios_offices_xaxis); ?>,
                                    labels: {
                                        /*x: 25,
                                        y: -22,
                                        align: 'left',
                                        style: {
                                            width: '300px'
                                        }*/
                                        style: {
                                            fontSize: '0.25cm',
                                            fontWeight: 700,
                                            width: '300px'
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
                                    name: 'Office',
                                    data: <?php echo json_encode($oios_offices_series); ?>,
                                    showInLegend: false

                                }]
                            });
                    </script>

                    <div id="oiosaudityear_chart"></div>
                    <script type="text/javascript">
                        Highcharts.chart('oiosaudityear_chart', {
                                colors: ['#0077b6'],
                                credits: {
                                    text: ''
                                },
                                chart: {
                                    backgroundColor: 'transparent',
                                    type: 'column',
                                    height: 220
                                },
                                title: {
                                    text: 'Figure n: OIOS by Audit Year',
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
                                    categories: <?php echo json_encode($oios_audityear_xaxis); ?>,
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
                                    name: 'Audit Year',
                                    data: <?php echo json_encode($oios_audityear_series); ?>,
                                    showInLegend: false

                                }]
                            });
                    </script>

                    <div id="oiostargetdate_chart"></div>
                    <script type="text/javascript">
                        Highcharts.chart('oiostargetdate_chart', {
                            colors: ['#0077b6'],
                            credits: {
                                text: ''
                            },
                            chart: {
                                backgroundColor: 'transparent',
                                type: 'column',
                                height: 200
                            },
                            title: {
                                text: 'Figure n: OIOS by Target Date',
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
                                categories: ["Elapsed","0-3 Months", "3-6 Months", "6-9 Months", "9-12 Months", "Over 1year"],
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
                                    colorByPoint: false
                                }
                            },
                            series: [{
                                name: 'Target Date',
                                data: [<?php echo $oios_targetdate_elapsed; ?>,<?php echo $oios_targetdate_3months; ?>,<?php echo $oios_targetdate_6months; ?>,<?php echo $oios_targetdate_9months; ?>,<?php echo $oios_targetdate_12months; ?>,<?php echo $oios_targetdate_over12; ?>],
                                showInLegend: false

                            }]
                        });
                    </script>










                </div>
            </div>
            <!-- end of new dashboard: Audit Risks -->

            <!--<div id="dashboardimg3" style="display:none;">
                <img src="" id="newimg3" class="top" />
            </div>-->
            <div class="pagebreak"></div>









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
            </div>

            <div class="row reportbody section2">
                <h2 class="sectiontitle">Annex 2: Board of Auditors</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th class="text-left">Office</th>
                                <th class="text-left">Recommendation</th>
                                <th class="text-left">Reference</th>
                                <th class="text-center">Priority</th>
                                <th class="text-center">Audit Year</th>
                                <th class="text-center">Target Date</th>
                                <th class="text-center">Status</th>
                                <!--<th class="text-center">Age <br><span>(Months)</span></th>-->
                                <th class="text-center">Category</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                array_multisort(array_column($processed_divisiondata[$division]["boa_data"], 'year'), SORT_ASC,$processed_divisiondata[$division]["boa_data"]);

                                $j = 0;
                                foreach ($processed_divisiondata[$division]["boa_data"] as $key => $value) {
                                    if (in_array($value["suggestedstatusverified"], $selectedboastatus)) {
                                        echo '<tr>';
                                        echo '<td class="text-right">'.($j + 1).'.</td>';
                                        echo '<td class="text-left" style="max-width: 100px;">'.$value["office"].'</td>';
                                        echo '<td class="text-left" style="max-width: 300px;">'.$value["summaryrecommendation"].'</td>';
                                        echo '<td class="text-left" style="max-width: 70px;">'.$value["reportreference"].'</td>';
                                        echo '<td class="text-center">'.$value["priority"].'</td>';
                                        echo '<td class="text-center">'.$value["year"].'</td>';
                                        echo '<td class="text-center">'.$value["targetdate"].'</td>';
                                        $elapsed = floor(getdaysbetween($value["year"]."/01/01",min(date("Y-m-d",time()),$value["targetdate"])));
                                        $duration = ceil(getdaysbetween($value["year"]."/01/01",$value["targetdate"]));
                                        $score = number_format(($elapsed*100/max($duration,1) ),0,'.',',');
                                        if ($score >= 0 && $score < 75) {
                                            $scorecolor = '#28a745 !important'; //green
                                        } else if ($score >= 75 && $score < 100) {
                                            $scorecolor = '#ffc107 !important'; // yellow
                                        } else {
                                            $scorecolor = '#dc3545 !important'; //red
                                        }
                                        echo '<td><p class="projectlistinghealth" style="background-color:'.$scorecolor.'">&nbsp;</p></td>';
                                        echo '<td class="text-center">'.$value["category"].'</td>';
                                        echo '</tr>';
                                        $j++;
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="row reportbody section2">
                <h2 class="sectiontitle">Annex 3: OIOS</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th class="text-left">Office</th>
                                <th class="text-left">Title</th>
                                <th class="text-left">Recommendation</th>
                                <th class="text-left">Code</th>
                                <th class="text-left">Priority</th>
                                <th class="text-center">Start Date</th>
                                <th class="text-center">End Date</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Category</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                array_multisort(array_column($processed_divisiondata[$division]["oios_data"], 'issue_date'), SORT_ASC,$processed_divisiondata[$division]["oios_data"]);

                                $j = 0;
                                foreach ($processed_divisiondata[$division]["oios_data"] as $key => $value) {
                                    echo '<tr>';
                                    echo '<td class="text-right">'.($j + 1).'.</td>';
                                    echo '<td class="text-left">'.$value["office"].'</td>';
                                    echo '<td class="text-left">'.$value["title"].'</td>';
                                    if (is_numeric(substr($value["recommendation"], 0, 1))) {
                                        //echo "Numeric sentence: ".substr($var, (strpos($var, '.')+1));
                                        echo '<td class="text-left" style="max-width: 300px;">'.substr($value["recommendation"], (strpos($value["recommendation"], '.')+1)).'</td>';
                                    } else if (substr($value["recommendation"], 0, 1) == "(" ) {
                                        echo '<td class="text-left" style="max-width: 300px;">'.substr($value["recommendation"], (strpos($value["recommendation"], ')')+1)).'</td>';
                                    } else {
                                        echo '<td class="text-left" style="max-width: 300px;">'.$value["recommendation"].'</td>';
                                    }
                                    echo '<td class="text-left">'.$value["projectcode"].'</td>';
                                    echo '<td class="text-center">'.$value["recommendation_update"].'</td>';
                                    echo '<td class="text-center">'.$value["issue_date"].'</td>';
                                    echo '<td class="text-center">'.$value["implementation_date"].'</td>';


                                    $elapsed = floor(getdaysbetween($value["issue_date"],min(date("Y-m-d",time()),$value["implementation_date"])));
                                    $duration = ceil(getdaysbetween($value["issue_date"],$value["implementation_date"]));
                                    $score = number_format(($elapsed*100/max($duration,1) ),0,'.',',');
                                    if ($score >= 0 && $score < 75) {
                                        $scorecolor = '#28a745 !important'; //green
                                    } else if ($score >= 75 && $score < 100) {
                                        $scorecolor = '#ffc107 !important'; // yellow
                                    } else {
                                        $scorecolor = '#dc3545 !important'; //red
                                    }

                                    echo '<td><p class="projectlistinghealth" style="background-color:'.$scorecolor.'">&nbsp;</p></td>';
                                    /*if ($elapsed != 0 && $duration != 0) {
                                        $elapsedtime = number_format(($elapsed*100/max($duration,1) ),0,'.',',');
                                        if ($elapsedtime >= 0 && $elapsedtime < 100) {
                                            echo '<td class="center"><div class="progress-bar"><span class="progress-bar-fill green" style="width: '.$elapsedtime.'%;">'.$elapsedtime.'%</span></div></td>';
                                        } else if ($elapsedtime >= 100) {
                                            echo '<td class="center"><div class="progress-bar"><span class="progress-bar-fill red" style="width: 100%;">'.$elapsedtime.'%</span></div></td>';
                                        } else {
                                            $elapsedtime = 'N/A';
                                            echo '<td class="center"><div class="progress-bar"><span class="progress-bar-fill gray" style="width:100%;">'.$elapsedtime.'</span></div></td>';
                                        }
                                    } else {
                                        $elapsedtime = 'N/A';
                                        echo '<td class="center"><div class="progress-bar"><span class="progress-bar-fill gray" style="width:100%;">'.$elapsedtime.'</span></div></td>';
                                    }
                                    echo '<td class="text-center">'.$value["age_months"].'</td>';
                                    */
                                    echo '<td class="text-center">'.$value["category"].'</td>';
                                    echo '</tr>';
                                    $j++;
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
    <script type="text/javascript">
        //$container = $("#dashboardcanvas");
        $container = '';
        function screencapture(container,number) {
            $container = $(container);
            var svgElements= $container.find('svg');
            //replace all svgs with a temp canvas
            svgElements.each(function () {
                var canvas, xml;
                canvas = document.createElement("canvas");
                canvas.className = "screenShotTempCanvas";
                xml = (new XMLSerializer()).serializeToString(this); //convert SVG into a XML string
                xml = xml.replace(/xmlns=\"http:\/\/www\.w3\.org\/2000\/svg\"/, ''); // Removing the name space as IE throws an error
                canvg(canvas, xml); //draw the SVG onto a canvas
                $(canvas).insertAfter(this);
                this.className = "tempHide"; //hide the SVG element
                $(this).hide();
            });
            savedashboard(container,number);
        }

        function savedashboard(container,number) {
            $container = $(container);
            var entityname = '<?php echo $division; ?>' + number;
            html2canvas($container[0],{scale:2}).then(function(canvas) {
                var imgsrc = canvas.toDataURL("image/png");
                $("#newimg").attr('src', imgsrc);
                var dataURL = canvas.toDataURL();
                $.ajax({
                    type: "POST",
                    url: "savedashboard.php",
                    data: {imgBase64: dataURL, entity: entityname}
                }).done(function(o) {
                    console.log(entityname + ' saved');
                    $container.find('.screenShotTempCanvas').remove();
                    $container.find('svg').show();
                    $container.find('.tempHide').show().removeClass('tempHide');
                });
            });
        }

        $(function() {
            // on page load, scroll to div#dashboardcanvas, wait 3s for chart rendering to complete then grab screen
            $('html, body').animate({scrollTop: $("#dashboardcanvas").offset().top}, 0);
            setTimeout(screencapture("#dashboardcanvas",""),6000);
            //setTimeout(screencapture("#dashboard2","2"),8000);
        });
    </script>
</body>
</html>
