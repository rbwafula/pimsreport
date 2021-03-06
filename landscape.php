<?php
$month = Date("M", strtotime("-1 months")).' '.Date("Y");
$office = array('Europe', 'Economy', 'Disasters and Conflicts', 'Latin America', 'Asia Pacific', 'Law', 'Communication', 'Ecosystems', 'Science', 'Africa', 'West Asia');
$officeid = (isset($_GET['office'])) ? $_GET['office'] : 0;
$division = $office[$officeid];
include_once 'dynamic_algo.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $division;?> | PIMS+ Report</title>
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
	<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 hidden "><!-- shadow -->
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
                    <h1 class="h2">Office Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="dropdown mr-2">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Select Office
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="unep.php">UNEP Consolidated</a>
                                <div class="dropdown-divider"></div>
                                <?php

                                for ($i=0; $i < count($office); $i++) {
                                    if ($i == $officeid) {
                                        echo '<a class="dropdown-item active" href="landscape.php?office='.$i.'">'.$office[$i].'</a>';
                                    } else {
                                        echo '<a class="dropdown-item" href="landscape.php?office='.$i.'">'.$office[$i].'</a>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="btn-group">
                            <!--<button type="button" class="btn btn-sm btn-outline-secondary" onclick="javascript:void(0);">Share</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print();return false;">Export to PDF</button>-->
                            <!-- TRIGGER FOR THE HTML TO PDF FUNCTION -->
                            <a class="btn btn-sm btn-outline-secondary" target="_new" href="table.php?office=<?php echo $officeid; ?>">Print PDF</a>
                            <!--<button type="button" class="btn btn-sm btn-outline-secondary" onclick="jsp();"> PDF</button>-->
                        </div>
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
                        <h1><?php echo $processed_divisiondata[$division]["entity"]; ?></h1>
                        <h6>Programme Delivery Report</h6>
                    </div>
                    <div class="col-md-2 health">
                        <p class="reportdate"><?php echo $month; ?></p>
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
                                    /*
                                    Highcharts.chart('budgetsize_chart', {
                                        chart: {
                                            type: 'scatter',
                                            zoomType: 'xy',
                                            height: 200
                                        },
                                        credits: {
                                            enabled: false
                                        },
                                        title: {
                                            text: 'Figure 4: Project Rank vs Budget',
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
                                            min: 0,
                                            max: 3,
                                            categories: ["Not Reported","Red", "Yellow", "Green"],
                                            title: {
                                                enabled: false,
                                                text: 'Project Rating'
                                            },
                                            startOnTick: true,
                                            endOnTick: true,
                                            showLastLabel: true
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
                                        legend: {
                                            layout: 'vertical',
                                            align: 'left',
                                            verticalAlign: 'top',
                                            x: 100,
                                            y: 70,
                                            floating: true,
                                            backgroundColor: Highcharts.defaultOptions.chart.backgroundColor,
                                            borderWidth: 1,
                                            enabled: false
                                        },
                                        plotOptions: {
                                            scatter: {
                                                marker: {
                                                    radius: 3,
                                                    states: {
                                                        hover: {
                                                            enabled: true,
                                                            lineColor: 'rgb(100,100,100)'
                                                        }
                                                    }
                                                },
                                                states: {
                                                    hover: {
                                                        marker: {
                                                            enabled: false
                                                        }
                                                    }
                                                },
                                                tooltip: {
                                                    headerFormat: '<b>{series.name}</b><br>',
                                                    pointFormat: 'Rating: {point.x}, Budget size: {point.y}'
                                                }
                                            }
                                        },
                                        series: [{
                                            name: 'Red',
                                            color: 'rgba(220, 53, 69, .9)',
                                            data: <?php echo json_encode($processed_divisiondata[$division]["scatterpoints"]["red"]); ?>

                                        }, {
                                            name: 'Yellow',
                                            color: 'rgba(255, 193, 7, .9)',
                                            data: <?php echo json_encode($processed_divisiondata[$division]["scatterpoints"]["yellow"]); ?>

                                        }, {
                                            name: 'Green',
                                            color: 'rgba(40, 167, 69, .9)',
                                            data: <?php echo json_encode($processed_divisiondata[$division]["scatterpoints"]["green"]); ?>

                                        }]
                                    });*/
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
$epas_completed = 0;
$training_total = 0;
for ($i = 0; $i < count($processed_divisiondata[$division]["stafflisting"]); $i++) {
    if ($processed_divisiondata[$division]["stafflisting"][$i]['position_status'] == 'FILLED' && $processed_divisiondata[$division]["stafflisting"][$i]['stage'] == 'Completed') {
        $epas_completed++;
        $training_total += $processed_divisiondata[$division]["stafflisting"][$i]['mandatory_training'];
    } else if ($processed_divisiondata[$division]["stafflisting"][$i]['position_status'] == 'FILLED' && $processed_divisiondata[$division]["stafflisting"][$i]['stage'] == 'SM Self & FRO Evaluation') {
        $epas_completed++;
        $training_total += $processed_divisiondata[$division]["stafflisting"][$i]['mandatory_training'];
    }


    
}


                                    ?>
                                    <div class="col metric1">
                                        <p class="metricvalue">
                                            <?php 
                                            $activeconsultants = 0;
                                            foreach ($processed_divisiondata[$division]["consultants_data"] as $key => $value) {
                                                if ($value["expired"] == "NO") {
                                                    $activeconsultants++;
                                                }
                                            }
                                            echo number_format($activeconsultants, 0, '.', ','); ?>
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
                                            <?php echo number_format((($epas_completed/max($filledposts,1))*100),0); ?>%
                                        </p>
                                        <p class="metricdesc">ePAS<br/>Compliance</p>
                                    </div>
                                     <div class="col metric6">
                                        <p class="metricvalue">
                                            <?php echo number_format((($training_total/max(($filledposts*9),1))*100),0); ?>%
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
                                            height: 250,
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
                                            data: <?php echo json_encode($processed_divisiondata[$division]["hrpostsfilledfemale"]); ?>
                                        },{
                                            name: 'Male',
                                            data: <?php echo json_encode($processed_divisiondata[$division]["hrpostsfilledmale"]); ?>
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


                                    /*Highcharts.chart('hrgender_chart', {
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
                                            data: <?php echo json_encode($processed_divisiondata[$division]["hrpostsfilledfemale"]); ?>
                                        },{
                                            name: 'Male',
                                            data: <?php echo json_encode($processed_divisiondata[$division]["hrpostsfilledmale"]); ?>
                                        }]
                                    });*/
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


            <!-- new dashboard -->
            <div id="dashboard2"  class="row reportbody section1 dashboard2" style="width:28.1cm;height:21cm;background-color:#f9f9f9;">
                <div class="col-md-4">
                    <h5 class="sectiontitle">Finance &amp; Grants</h5>
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
                            <p class="metricvalue">$ <?php echo number_format($totalgrants_amount,0); ?></p>
                            <p class="metricdesc">Total Grant Amount</p>
                        </div>
                        <div class="col metric1">
                            &nbsp;
                        </div>
                    </div>
                    <div class="row summarystatistics pb-20">
                        <div class="col metric2">
                            <p class="metricvalue"><?php echo number_format($sixmonthexpiry_count,0); ?></p>
                            <p class="metricdesc">Grants Expiring in 6 Months</p>
                        </div>
                        <div class="col metric2">
                            <p class="metricvalue">$ <?php echo number_format($sixmonthexpiry_amount,0,".",","); ?></p>
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
                            <p class="metricvalue">$ <?php echo number_format($totalexpired_amount,0,".",","); ?></p>
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
                            <p class="metricvalue">$ (<?php echo number_format(abs($totalnegative_amount),0,".",","); ?>)</p>
                            <p class="metricdesc">Amount of Negative Grants</p>
                        </div>
                        <div class="col metric4">
                            <p class="metricvalue"><?php echo number_format(($totalnegative_count*100/max($totalgrants_count,1)),0,".",","); ?>%</p>
                            <p class="metricdesc">% of Negative Grants</p>
                        </div>
                    </div>
                    <div class="row summarystatistics pt-40">
                        <p><b>New financial chart coming ...</b></p>
                    </div>
                </div>
                <div class="col-md-4" style="background-color: #fff">
                    <h5 class="sectiontitle">Audits &amp; Risks</h5>

                    <!-- Start of Top Risks -->
                    <?php
                        $toprisks_categories_xaxis = [];
                        $toprisks_categories_series = [];
                        array_multisort(array_column($processed_divisiondata[$division]["risks_data"], 'year'), SORT_ASC,$processed_divisiondata[$division]["risks_data"]);
                        foreach ($processed_divisiondata[$division]["risks_data"] as $key => $value) {
                            if ($value["year"] == date("Y", strtotime("now"))) {
                                $toprisks_categories_xaxis[] = $value["riskname"];
                                $toprisks_categories_series[] = (int)$value["projectcount"];
                            }
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
                                    type: 'column',
                                    height: 250
                                },
                                title: {
                                    text: 'Figure 7: Top Risks Current Year',
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
                                    data: <?php echo json_encode($toprisks_categories_series); ?>,
                                    showInLegend: false

                                }]
                            });
                        </script>
                    </div>
                    <!-- End of Top Risks -->



                    <?php
                        $boa_categories = [];
                        $boa_categories_xaxis = [];
                        $boa_categories_series = [];
                        foreach ($processed_divisiondata[$division]["boa_data"] as $key => $value) {
                            $boa_categories[] = $value["category"];
                        }
                        foreach (array_count_values($boa_categories) as $key => $value) {
                            $boa_categories_xaxis[] = $key;
                            $boa_categories_series[] = $value;
                        }
                    ?>

                    <div class="col-md-12 boacategories pb-20">
                        <div id="boacategories_chart">
                            <?php
                                $showboa = 1;
                                if (empty($processed_divisiondata[$division]["boa_data"])) {
                                    echo "<p style='font-size: 10px;font-weight: bold;padding: 40px 10px 0 10px;text-decoration: underline;margin-bottom: 0;'>Figure 8: BOA by Category</p>";
                                    echo "<p style='font-size: 10px;padding: 5px 10px 40px 10px;'>No BOA audit open</p>";
                                    $showboa = 0;
                                }
                            ?>
                        </div>
                        <script type="text/javascript">
                            var showboa = <?php echo $showboa; ?>;
                            if (showboa != false) {
                                Highcharts.chart('boacategories_chart', {
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
                                        text: 'Figure 8: BOA by Category',
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
                                        categories: <?php echo json_encode($boa_categories_xaxis); ?>,
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
                                        data: <?php echo json_encode($boa_categories_series); ?>,
                                        showInLegend: false

                                    }]
                                });
                            }
                        </script>
                    </div>


                    <?php
                        $oios_categories = [];
                        $oios_categories_xaxis = [];
                        $oios_categories_series = [];
                        foreach ($processed_divisiondata[$division]["oios_data"] as $key => $value) {
                            $oios_categories[] = $value["category"];
                        }
                        foreach (array_count_values($oios_categories) as $key => $value) {
                            $oios_categories_xaxis[] = $key;
                            $oios_categories_series[] = $value;
                        }
                    ?>

                    <div class="col-md-12 oioscategories pb-20">
                        <div id="oioscategories_chart">
                            <?php
                                $showoios = 1;
                                if (empty($processed_divisiondata[$division]["oios_data"])) {
                                    echo "<p style='font-size: 10px;font-weight: bold;padding: 40px 10px 0 10px;text-decoration: underline;margin-bottom: 0;'>Figure 8: OIOS by Category</p>";
                                    echo "<p style='font-size: 10px;padding: 5px 10px 40px 10px;'>No OIOS audit open</p>";
                                    $showoios = 0;
                                }
                            ?>
                        </div>
                        <script type="text/javascript">
                            var showoios = <?php echo $showoios; ?>;
                            if (showoios != false) {
                                Highcharts.chart('oioscategories_chart', {
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
                                        text: 'Figure 9: OIOS by Category',
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
                                        data: <?php echo json_encode($oios_categories_series); ?>,
                                        showInLegend: false

                                    }]
                                });
                            }
                        </script>
                    </div>
                </div>
                <div class="col-md-4">
                    <h5 class="sectiontitle">Human Resource</h5>

                    <?php
                        $seniorstaffretiring_count = 0;
                        $expiringstaffcontracts_count = 0;
                        $hrfilledpositionsfundingtypes_categories = [];
                        $hrfilledpositionsfundingtypes_data = [];
                        $hrfilledpositionscontracttype_categories = [];
                        $hrfilledpositionscontracttype_data = [];

                        foreach ($processed_divisiondata[$division]["stafflisting"] as $key => $value) {
                            if ($value["position_status"] == "FILLED") {
                                $hrfilledpositionsfundingtypes_categories[] = checknotdefined($value["category"]);
                                
                                if (checknotdefined($value["contract_type"]) == "Undefined") {
                                    $hrfilledpositionscontracttype_categories[] = "Fixed Term";
                                } else {
                                    $hrfilledpositionscontracttype_categories[] = checknotdefined($value["contract_type"]);
                                }
                                $seniorposts = ['USG', 'ASG', 'D-2', 'D-1', 'P-5'];
                                if ( in_array($value["grade"], $seniorposts) && $value["retirement_date"] <= date("Y-m-d", strtotime("+12 month")) ) {
                                    $seniorstaffretiring_count++;
                                }
                                if ( $value["contract_expiry"] <= date("Y-m-d", strtotime("+6 month")) ) {
                                    $expiringstaffcontracts_count++;
                                }
                            }
                        }
                        foreach (array_count_values($hrfilledpositionsfundingtypes_categories) as $key => $value) {
                            $hrfilledpositionsfundingtypes_data[] = [
                                "name" => $key,
                                "count" => $value
                            ];
                        }
                        array_multisort(array_column($hrfilledpositionsfundingtypes_data, 'count'), SORT_DESC,$hrfilledpositionsfundingtypes_data);

                        $hrfilledpositionsfundingtypes_categories_xaxis = [];
                        $hrfilledpositionsfundingtypes_categories_series = [];
                        foreach ($hrfilledpositionsfundingtypes_data as $key => $value) {
                            $hrfilledpositionsfundingtypes_categories_xaxis[] = $value["name"];
                            $hrfilledpositionsfundingtypes_categories_series[] = $value["count"];
                        }

                        foreach (array_count_values($hrfilledpositionscontracttype_categories) as $key => $value) {
                            $hrfilledpositionscontracttype_data[] = [
                                "name" => $key,
                                "count" => $value
                            ];
                        }
                        array_multisort(array_column($hrfilledpositionscontracttype_data, 'count'), SORT_DESC,$hrfilledpositionscontracttype_data);

                        $hrfilledpositionscontracttype_xaxis = [];
                        $hrfilledpositionscontracttype_series = [];
                        foreach ($hrfilledpositionscontracttype_data as $key => $value) {
                            $hrfilledpositionscontracttype_xaxis[] = $value["name"];
                            $hrfilledpositionscontracttype_series[] = $value["count"];
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
                            <p class="metricdesc">Senior Positions<br/>Retiring in 1 Year<br/>(D2, D1, P5)</p>
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
                                text: 'Figure 10: Filled Positions by Funding Type',
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
                                name: 'Funding Type',
                                data: <?php echo json_encode($hrfilledpositionsfundingtypes_categories_series); ?>,
                                showInLegend: false

                            }]
                        });
                    </script>

                    <div class="pt-20" id="hrfilledpositionscontracttype_chart"></div>
                    <script type="text/javascript">
                        Highcharts.chart('hrfilledpositionscontracttype_chart', {
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
                                text: 'Figure 11: Filled Positions by Contract Type',
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
                                categories: <?php echo json_encode($hrfilledpositionscontracttype_xaxis); ?>,
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
                                name: 'Contract Type',
                                data: <?php echo json_encode($hrfilledpositionscontracttype_series); ?>,
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
            </div><!-- End of #dashboard2 -->
            <div class="pagebreak"></div>












            <div class="row reportbody section2">
                <h2 class="sectiontitle">Annex 1: Projects Table</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th class="left">Branch</th>
                                <th width="115px" class="left">Project ID</th>
                                <th class="left">Project Title</th>
                                <th class="center">Sub<br/>Programme</th>
                                <th class="center">Months<br/>Past Due</th>
                                <th class="left">Project<br/>Manager</th>
                                <th class="right">Budget</th>
                                <th class="projectlistinghealth">System Rating <span>(40%)</span></th>
                                <th class="projectlistinghealth">Management Rating <span>(60%)</span></th>
                                <th class="projectlistinghealth">Final Rating</th>
                                <th class="center">Project Rank</th>
                                <th class="center"># of Reports</th>
                                <th class="center">Outputs</th>
                                <th class="center">Completed Activities</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
for ($i = 0; $i < count($processed_divisiondata[$division]["projectlisting"]); $i++) {
    echo '<tr>';
    echo '<td class="right">' . ($i + 1) . '.</td>';
    echo '<td class="left">' . $processed_divisiondata[$division]["projectlisting"][$i]['branch'] . '</td>';
    echo '<td class="left">' . $processed_divisiondata[$division]["projectlisting"][$i]['project_id'] . '</td>';
    echo '<td class="left">' . $processed_divisiondata[$division]["projectlisting"][$i]['project_title'] . '</td>';
    echo '<td class="center">SP ' . $processed_divisiondata[$division]["projectlisting"][$i]['sp_number'] . '</td>';

    if ($processed_divisiondata[$division]["projectlisting"][$i]['months_remaining'] < 0) {
        echo '<td class="center" style="color:#dc3545; font-weight: 500;">' . abs($processed_divisiondata[$division]["projectlisting"][$i]['months_remaining']) . '</td>';
    } else if ($processed_divisiondata[$division]["projectlisting"][$i]['months_remaining'] == 'No Enddate') {
        echo '<td class="center" style="color:#dc3545; font-weight: 500;">No end date</td>';
    } else {
        echo '<td class="center" style="font-weight:500; color:green">&nbsp;</td>';
    }
    echo '<td class="left">' . $processed_divisiondata[$division]["projectlisting"][$i]['project_manager'] . '</td>';
    echo '<td class="right">' . number_format($processed_divisiondata[$division]["projectlisting"][$i]['budget'], 0, '.', ',') . '</td>';
    echo '<td><p class="projectlistinghealth" style="background-color:' . gethealthcolor($processed_divisiondata[$division]["projectlisting"][$i]['system_rating']) . '">&nbsp;</p></td>';
    echo '<td><p class="projectlistinghealth" style="background-color:' . gethealthcolor($processed_divisiondata[$division]["projectlisting"][$i]['management_rating']) . '">&nbsp;</p></td>';
    echo '<td><p class="projectlistinghealth" style="background-color:' . gethealthcolor($processed_divisiondata[$division]["projectlisting"][$i]['final_rating']) . '">&nbsp;</p></td>';
    echo '<td class="center">' . $processed_divisiondata[$division]["projectlisting"][$i]['project_rank'] . '</td>';



    echo '<td class="center">' . $processed_divisiondata[$division]["projectlisting"][$i]['reports'] . ' / '.Date("n").' </td>';




    echo '<td class="center">' . $processed_divisiondata[$division]["projectlisting"][$i]['outputs'] . '</td>';
    if ($processed_divisiondata[$division]["projectlisting"][$i]['completed_activities'] != '' && $processed_divisiondata[$division]["projectlisting"][$i]['total_activities'] != '') {
        echo '<td class="center">' . $processed_divisiondata[$division]["projectlisting"][$i]['completed_activities'] . ' / ' . $processed_divisiondata[$division]["projectlisting"][$i]['total_activities'] . ' </td>';
    } else {
        echo '<td class="center"> - </td>';
    }
    echo '</tr>';
}
?>
                        </tbody>
                    </table>
                </div>
            </div>
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
                            foreach ($processed_divisiondata[$division]["stafflisting"] as $key => $value) {
                                if ($value["position_status"] == "VACANT") {
                                    echo '<tr>';
                                    echo '<td class="text-right">'.($j+1).'.</td>';
                                    echo '<td class="text-center">'.$value["grade"].'</td>';
                                    echo '<td class="text-left">'.$value["position_title"].'</td>';
                                    echo '<td class="text-center">'.$value["position_number"].'</td>';
                                    echo '<td class="text-left">'.$value["duty_station"].'</td>';
                                    echo '<td class="text-center">'.$value["category"].'</td>';
                                    echo '<td class="text-left">'.$value["org_code"].'</td>';
                                    echo '<td class="text-left">'.$value["org_unit_description"].'</td>';
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
                <h2 class="sectiontitle">Annex 3: Encumbered Positions</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th class="text-center">Grade</th>
                                <th class="text-left">Position Title</th>
                                <th class="text-center">Position Number</th>
                                <th class="text-left">Duty Station</th>
                                <th class="text-left">Staff Name</th>
                                <th class="text-center">Fund</th>
                                <th class="text-center">Contract Type</th>
                                <th class="text-center">ePAS Status</th>
                                <th class="text-center">Mandatory Training</th>
                                <th class="text-center">Contract Expiration</th>
                                <th class="text-center">Retirement</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $j = 0;
                            foreach ($processed_divisiondata[$division]["stafflisting"] as $key => $value) {
                                if ($value["position_status"] == "FILLED") {
                                    echo '<tr>';
                                    echo '<td class="text-right">'.($j+1).'.</td>';
                                    echo '<td class="text-center">'.$value["grade"].'</td>';
                                    echo '<td class="text-left">'.$value["position_title"].'</td>';
                                    echo '<td class="text-center">'.$value["position_number"].'</td>';
                                    echo '<td class="text-left">'.$value["duty_station"].'</td>';
                                    echo '<td class="text-left">'.$value["staff_name"].'</td>';
                                    echo '<td class="text-center">'.$value["category"].'</td>';
                                    echo '<td class="text-center">'.$value["contract_type"].'</td>';
                                    if ($value["stage"] != "" && $value["stage"] != null) {
                                        echo '<td class="text-center">'.$value["stage"].'</td>';
                                    } else {
                                        echo '<td class="text-center">-N/A-</td>';
                                    }
                                    if ($value["mandatory_training"] != "" && $value["mandatory_training"] != null) {
                                        echo '<td class="text-center">'.$value["mandatory_training"].' / 9</td>';
                                    } else {
                                        echo '<td class="text-center">0 / 9</td>'; 
                                    }
                                    if ($value["contract_expiry"] <= date("Y-m-d", strtotime("+6 month")) ) {
                                        echo '<td class="text-center text-red">'.$value["contract_expiry"].'</td>';
                                    } else {
                                        echo '<td class="text-center">'.$value["contract_expiry"].'</td>';
                                    }
                                    if ($value["retirement_date"] <= date("Y-m-d", strtotime("+24 month")) ) {
                                        echo '<td class="text-center text-red">'.$value["retirement_date"].'</td>';
                                    } else {
                                        echo '<td class="text-center">'.$value["retirement_date"].'</td>';
                                    }
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
                <h2 class="sectiontitle">Annex 4: Consultants</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm budgetclass">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th class="text-left">Name</th>
                                <th class="text-center">Start Date</th>
                                <th class="text-center">End Date</th>
                                <!--<th class="text-right">Contract Type</th>-->
                                <th class="text-right">Duration</th>
                                <th class="text-center">More than 11 months</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $j = 0;
                            foreach ($processed_divisiondata[$division]["consultants_data"] as $key => $value) {
                                if ($value["expired"] == "NO") {
                                    echo '<tr>';
                                    echo '<td class="text-right">'.($j + 1).'.</td>';
                                    echo '<td class="text-left">'.$value["names"].'</td>';
                                    echo '<td class="text-center">'.$value["startdate"].'</td>';
                                    echo '<td class="text-center">'.$value["enddate"].'</td>';
                                    //echo '<td class="text-center">'.checknotdefined($value["contract_type"]).'</td>';
                                    echo '<td class="text-right">'.number_format($value["duration"],0,".",",").' days</td>';
                                    echo '<td class="text-center">'.$value["morethan11months"].'</td>';
                                    $j++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>


<div class="row reportbody section2">
                <h2 class="sectiontitle">Annex 5: Umoja Grants Data</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm budgetclass">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>Keys</th>
                                <th class="text-right">Amounts</th>
                                <th class="text-center">Start Date</th>
                                <th class="text-center">End Date</th>
                                <th class="text-center">Elapsed</th>
                                <th class="text-center">Expiration</th>
                                <th class="text-center">Months Remaining</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                            $j = 0;
                            foreach ($processed_divisiondata[$division]["grantsdata"] as $key => $value) {
                                if (number_format($value["grantamount"],0,".",",") != "0") {
                                    echo '<tr>';
                                    echo '<td class="text-right">'.($j + 1).'.</td>';
                                    echo '<td>'.$value["grantkey"].'</td>';
                                    if ($value["grantamount"] < 0) {
                                        echo '<td class="text-right text-red">'.number_format($value["grantamount"],0,".",",").'</td>';
                                    } else {
                                        echo '<td class="text-right">'.number_format($value["grantamount"],0,".",",").'</td>';
                                    }
                                    echo '<td class="text-center">'.$value["grantstartdate"].'</td>';
                                    echo '<td class="text-center">'.$value["grantenddate"].'</td>';

                                    $elapsed = floor(getdaysbetween($value["grantstartdate"],min(date("Y-m-d",time()),$value["grantenddate"])));
                                    $duration = ceil(getdaysbetween($value["grantstartdate"],$value["grantenddate"]));
                                    $score = number_format(($elapsed * 100 / max($duration, 1)), 0, '.', ',');
                                    if ($score >= 0 && $score < 75) {
                                        $scorecolor = '#28a745 !important'; //green
                                    } else if ($score >= 75 && $score < 100) {
                                        $scorecolor = '#ffc107 !important'; // yellow
                                    } else {
                                        $scorecolor = '#dc3545 !important'; //red
                                    }

                                    echo '<td><p class="projectlistinghealth" style="background-color:' . $scorecolor . '">&nbsp;</p></td>';
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
                                    }*/
                                    echo '<td class="text-center">'.$value["grantexpired"].'</td>';
                                    echo '<td class="text-center">'.$value["grantaging"].'</td>';
                                    $j++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row reportbody section3">
                <h2 class="sectiontitle">Annex 6: Project Risks</h2>
                <div class="table-responsive">
                <?php 
                    if (empty($processed_divisiondata[$division]["risks_data"])) {
                        echo "<p><b>Nothing to report</b></p>";
                    } else {
                    ?>
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th class="text-left">Risk Name</th>
                                <th class="text-center">Number of Projects</th>
                                <!--<th class="text-center">Month</th>-->
                                <th class="text-center">Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $j = 0;
                                foreach ($processed_divisiondata[$division]["risks_data"] as $key => $value) {
                                    if ($value["year"] == date("Y", strtotime("now"))) {
                                        echo '<tr>';
                                        echo '<td class="text-right">'.($j + 1).'.</td>';
                                        echo '<td class="text-left">'.$value["riskname"].'</td>';
                                        echo '<td class="text-center">'.$value["projectcount"].'</td>';
                                        //echo '<td class="text-center">'.date('F', mktime(0, 0, 0, $value["month"], 10)).'</td>';
                                        echo '<td class="text-center">'.$value["year"].'</td>';
                                        echo '</tr>';
                                        $j++;
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php
                    }
                ?>  
                </div>
            </div>

            <div class="row reportbody section2">
                <h2 class="sectiontitle">Annex 7: Board of Auditors</h2>
                <div class="table-responsive">
                <?php 
                    if (empty($processed_divisiondata[$division]["boa_data"])) {
                        echo "<p><b>Nothing to report</b></p>";
                    } else {
                    ?>
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th class="text-left">Recommendation</th>
                                <th class="text-left">Reference</th>
                                <th class="text-center">Priority</th>
                                <th class="text-center">Audit Year</th>
                                <th class="text-center">Target Date</th>
                                <th class="text-center">Elapsed</th>
                                <!--<th class="text-center">Age <br><span>(Months)</span></th>-->
                                <th class="text-center">Category</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                array_multisort(array_column($processed_divisiondata[$division]["boa_data"], 'year'), SORT_ASC,$processed_divisiondata[$division]["boa_data"]);

                                $j = 0;
                                $selectedboastatus = array("Pending");
                                foreach ($processed_divisiondata[$division]["boa_data"] as $key => $value) {
                                    if (in_array($value["suggestedstatus"], $selectedboastatus)) {
                                        echo '<tr>';
                                        echo '<td class="text-right">'.($j + 1).'.</td>';
                                        echo '<td class="text-left" style="max-width: 300px;">'.$value["summaryrecommendation"].'</td>';
                                        echo '<td class="text-left" style="max-width: 70px;">'.$value["reportreference"].'</td>';
                                        echo '<td class="text-center">'.$value["priority"].'</td>';
                                        echo '<td class="text-center">'.$value["year"].'</td>';
                                        echo '<td class="text-center">'.$value["targetdate"].'</td>';


                                        $elapsed = floor(getdaysbetween($value["year"]."/01/01",min(date("Y-m-d",time()),$value["targetdate"])));
                                        $duration = ceil(getdaysbetween($value["year"]."/01/01",$value["targetdate"]));
                                        $score = number_format(($elapsed * 100 / max($duration, 1)), 0, '.', ',');
                                        if ($score >= 0 && $score < 75) {
                                            $scorecolor = '#28a745 !important'; //green
                                        } else if ($score >= 75 && $score < 100) {
                                            $scorecolor = '#ffc107 !important'; // yellow
                                        } else {
                                            $scorecolor = '#dc3545 !important'; //red
                                        }

                                        echo '<td><p class="projectlistinghealth" style="background-color:' . $scorecolor . '">&nbsp;</p></td>';
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
                                        }*/
                                        //echo '<td class="text-center">'.$value["agemonths"].'</td>';
                                        echo '<td class="text-center">'.$value["category"].'</td>';
                                        echo '</tr>';
                                        $j++;
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php
                    }
                ?>  
                </div>
            </div>

            <div class="row reportbody section3">
                <h2 class="sectiontitle">Annex 8: OIOS</h2>
                <div class="table-responsive">
                <?php 
                    if (empty($processed_divisiondata[$division]["oios_data"])) {
                        echo "<p><b>Nothing to report</b></p>";
                    } else {
                        ?>
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th class="text-left">Recommendation</th>
                                    <th class="text-left">Code</th>
                                    <th class="text-left">Priority</th>
                                    <th class="text-center">Start Date</th>
                                    <th class="text-center">End Date</th>
                                    <th class="text-center" style="width: 100px">Elapsed</th>
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
                                        if ($elapsed != 0 && $duration != 0) {
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
                                        echo '<td class="text-center">'.$value["category"].'</td>';
                                        echo '</tr>';
                                        $j++;
                                    }
                                ?>
                            </tbody>
                        </table>
                        <?php
                    }
                ?>
                </div>
            </div>
        </div><!-- End of .toprint -->
    </div><!-- End of .container-fluid -->
    </div><!-- End of #to_export -->

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


        window.addEventListener('load', function () {
            $('html, body').animate({scrollTop: $("#dashboardcanvas").offset().top}, 0);
            setTimeout(()=>{screencapture("#dashboardcanvas","")},4000);
            setTimeout(()=>{screencapture("#dashboard2","2")},4000);
        })


        $(function() {
            // on page load, scroll to div#dashboardcanvas, wait 3s for chart rendering to complete then grab screen

            //setTimeout(screencapture("#dashboard2","2"),8000);
        });
    </script>
</body>
</html>
