<?php
	$month = Date("M") . ' ' . Date("Y");
	$division = ucwords('Africa');
	if( isset($_GET['office']) ) {
	     $division = ucwords($_GET['office']);
	}
    include_once('dynamic_algo.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Landscape Report</title>
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
</head>
<body>
	<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
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

    <div class="container-fluid printlandscape">
        <div class="row noprint">
            <main role="main" class="col-md-12 ml-sm-auto col-lg-12 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Division Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="javascript:void(0);">Share</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print();return false;">Export to PDF</button>
                        </div>
                        <!--<button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                            <span data-feather="calendar"></span> This week
                        </button>-->
                    </div>
                </div>
            </main>
        </div>

        <div class="row reportheader">
        	<div class="col-md-4 logo">
        		<img class="logo" src="assets/images/pimslogo.png">
        		<p class="compliancerating"><?php echo $processed_divisiondata[$division]["reportedprojectspct"];?>%</p>
                <p class="compliancedescription">Compliance Reporting</p>
        	</div>
        	<div class="col-md-4 title">
        		<h1><?php echo $processed_divisiondata[$division]["entity"]; ?></h1>
                <h6>Programme Delivery Report</h6>
        	</div>
        	<div class="col-md-4 health">
        		<p class="reportdate">Jan 2021</p>
        		<p class="healthrating_box" style="background-color:<?php echo $processed_divisiondata[$division]["healthcolor"];?>;">&nbsp;</p>
        		<p class="healthratingdesc">Project Portfolio Rating</p>
        	</div>
        </div>
        <div class="row reportbody section1">
        	<div class="col-md-4 summary">
        		<h5 class="sectiontitle">Summary</h5>
        		<div class="row summarystatistics">
        			<div class="col-md-3 metric1">
        				<p class="metricvalue">
        					<?php echo number_format($processed_divisiondata[$division]["totalprojects"],0,'.',',');?>
    					</p>
        				<p class="metricdesc">Total Projects</p>
        			</div>
        			<div class="col-md-3 metric2">
        				<p class="metricvalue">
        					<?php echo number_format($processed_divisiondata[$division]["totaloutputs"],0,'.',',');?>
        				</p>
        				<p class="metricdesc">Total Outputs</p>
        			</div>
        			<div class="col-md-3 metric3">
        				<p class="metricvalue">
        					<?php echo number_format($processed_divisiondata[$division]["totalactivities"],0,'.',',');?>
        				</p>
        				<p class="metricdesc">Total Activities</p>
        			</div>
        			<div class="col-md-3 metric4">
        				<p class="metricvalue">
        					<?php echo number_format($processed_divisiondata[$division]["pastdueprojects"],0,'.',',');?>
        				</p>
        				<p class="metricdesc">Expired Projects</p>
        			</div>
        		</div>
                <p class="summarytext">The dashboard captured financial data of <strong><?php echo $processed_divisiondata[$division]["totalprojects"];?> projects</strong> for the <?php echo $division; ?> Office. The overall budget recorded for this portfolio as of 2020 was <strong>(USD. <?php echo number_format($processed_divisiondata[$division]["consumablebudget"], 0, '.', ',');?>)</strong>, capturing a rolling total of the cash received over time.</p>
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
                                    height: 200
                                },
                                title: {
                                    text: 'Figure 1: Projects by Sub-Programme',
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
                                        <? echo $processed_divisiondata[$division]["consumablebudget"]/1000000; ?>, 
                                        <? echo $processed_divisiondata[$division]["totalconsumedbudget"]/1000000; ?>, 
                                        <?php echo ($processed_divisiondata[$division]["consumablebudget"] - $processed_divisiondata[$division]["totalconsumedbudget"])/1000000; ?>],
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
                                        y: <?php echo (100 - $processed_divisiondata[$division]["pctbudgetutilized"]);  ?>,
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
                                        y: <?php echo (100 - $processed_divisiondata[$division]["pctgdurationused"]);  ?>,
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
                                        y: <?php echo (100 - $processed_divisiondata[$division]["avgactivitiescompleted"]);  ?>,
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
                                    height: 250
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
        			<div class="col-md-12 budgetsize">
        				<div id="budgetsize_chart"></div>
        				<script type="text/javascript">
                            Highcharts.chart('budgetsize_chart', {
                                chart: {
                                    type: 'scatter',
                                    zoomType: 'xy',
                                    height: 200
                                },
                                title: {
                                    text: 'Figure 4: Grouping by Budget Size',
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
                                    borderWidth: 1
                                },
                                plotOptions: {
                                    scatter: {
                                        marker: {
                                            radius: 2,
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
                                            pointFormat: '{point.x} cm, {point.y} kg'
                                        }
                                    }
                                },
                                series: [{
                                    name: 'Red',
                                    color: 'rgba(220, 53, 69, .5)',
                                    data: [ <?php echo str_replace(']', '', str_replace('[', '', json_encode($processed_divisiondata[$division]["grantfundingcountbygroup"]))); ?> ,{
                                        dataLabels: {
                                            enabled: true,
                                            formatter: function(){
                                                return (this.y!=0)? Highcharts.numberFormat(this.y,1):"";
                                            }
                                        }
                                    }],
                                    showInLegend: false
                                }, {
                                    name: 'Yellow',
                                    color: 'rgba(255, 193, 7, .5)',
                                    data: [ <?php echo str_replace(']', '', str_replace('[', '', json_encode($processed_divisiondata[$division]["grantfundingcountbygroup"]))); ?> ,{
                                        dataLabels: {
                                            enabled: true,
                                            formatter: function(){
                                                return (this.y!=0)? Highcharts.numberFormat(this.y,1):"";
                                            }
                                        }
                                    }],
                                    showInLegend: false
                                }, {
                                    name: 'Green',
                                    color: 'rgba(40, 167, 69, .5)',
                                    data: [ <?php echo str_replace(']', '', str_replace('[', '', json_encode($processed_divisiondata[$division]["grantfundingcountbygroup"]))); ?> ,{
                                        dataLabels: {
                                            enabled: true,
                                            formatter: function(){
                                                return (this.y!=0)? Highcharts.numberFormat(this.y,1):"";
                                            }
                                        }
                                    }],
                                    showInLegend: false
                                }
                                /*{
                                    name: 'Red',
                                    
                                    data: [[161.2, 51.6], [167.5, 59.0]]

                                }, {
                                    name: 'Yellow',
                                    color: 'rgba(255, 193, 7, .5)',
                                    data: [[161.2, 51.6], [167.5, 59.0]]

                                }, {
                                    name: 'Green',
                                    color: 'rgba(40, 167, 69, .5)',
                                    data: [[161.2, 51.6], [167.5, 59.0]]

                                }*/]
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
                                for ($i=0; $i<count($processed_divisiondata[$division]["hrpostsvacant"]); $i++) {
                                    $vacantposts += $processed_divisiondata[$division]["hrpostsvacant"][$i];
                                    $filledposts += $processed_divisiondata[$division]["hrpostsfilled"][$i];
                                    $totalposts += ($processed_divisiondata[$division]["hrpostsvacant"][$i] + $processed_divisiondata[$division]["hrpostsfilled"][$i]);
                                }
                            ?>
                            <div class="col-md-2 metric1">
                                <p class="metricvalue">
                                    <?php echo number_format($totalposts,0,'.',',');?>
                                </p>
                                <p class="metricdesc">Total Posts</p>
                            </div>
                            <div class="col-md-2 metric3">
                                <p class="metricvalue">
                                    <?php echo number_format($vacantposts,0,'.',',');?>
                                </p>
                                <p class="metricdesc">Vacant Posts</p>
                            </div>
                            <div class="col-md-2 metric2">
                                <p class="metricvalue">
                                    <?php echo number_format($filledposts,0,'.',',');?>
                                </p>
                                <p class="metricdesc">Filled Posts</p>
                            </div>
                            <div class="col-md-2 metric3">
                                <p class="metricvalue">
                                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                    
                                    <!--<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                      <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                    </svg>-->
                                </p>
                                <p class="metricdesc">&nbsp;</p>
                            </div>
                            <div class="col-md-2 metric4">
                                <p class="metricvalue">
                                    <?php 
                                        echo number_format(abs(array_sum($processed_divisiondata[$division]["hrpostsfilledfemale"]))/count($processed_divisiondata[$division]["hrpostsfilledfemale"]), 0) ; ?>%
                                </p>
                                <p class="metricdesc">Female</p>
                            </div>
                            <div class="col-md-2 metric5">
                                <p class="metricvalue">
                                    <?php 
                                        echo number_format(abs(array_sum($processed_divisiondata[$division]["hrpostsfilledmale"]))/count($processed_divisiondata[$division]["hrpostsfilledmale"]), 0) ; ?>%
                                </p>
                                <p class="metricdesc">Male</p>
                            </div>
                        </div>
        				<div id="hrfilled_chart"></div>
        				<script type="text/javascript">
                            Highcharts.chart('hrfilled_chart', {
                                colors: ['#ddd','#17a2b8'],
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
                                    data: <?php echo json_encode($processed_divisiondata[$division]["hrpostsfilledfemale"]); ?>
                                },{
                                    name: 'Male',
                                    data: <?php echo json_encode($processed_divisiondata[$division]["hrpostsfilledmale"]); ?>
                                }]
                            });
                        </script>
        			</div>
        		</div>
        	</div>
        </div>
        <div class="pagebreak"></div>
        <div class="row reportbody section2">
        	<h2 class="sectiontitle">Annex 1: Projects Table</h2>
        	<div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                        	<th>&nbsp;</th>
                        	<th>Project ID</th>
                            <th>Project Title</th>
                            <th>Subprogramme</th>
                            <th>Project Manager</th>
                            <th>Budget</th>
                            <th>System Rating <span>(40%)</span></th>
                            <th>Management Rating <span>(60%)</span></th>
                            <th>Final Rating</th>
                            <th>Project Rank</th>
                            <th>Outputs</th>
                            <th>Completed Activities</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php 
                            for($i=0; $i < count($processed_divisiondata[$division]["projectlisting"]); $i++ ) {
                                echo '<tr>';
                                echo '<td>'.($i+1).'.</td>';
                                echo '<td>'.$processed_divisiondata[$division]["projectlisting"][$i]['project_id'].'</td>';
                                echo '<td>'.$processed_divisiondata[$division]["projectlisting"][$i]['project_title'].'</td>';
                                echo '<td>SP '.$processed_divisiondata[$division]["projectlisting"][$i]['sp_number'].'</td>';
                                echo '<td>'.$processed_divisiondata[$division]["projectlisting"][$i]['project_manager'].'</td>';
                                echo '<td>'.number_format($processed_divisiondata[$division]["projectlisting"][$i]['budget'],0,'.',',') .'</td>';
                                echo '<td><p class="projectlistinghealth" style="background-color:'.gethealthcolor($processed_divisiondata[$division]["projectlisting"][$i]['system_rating']).'">&nbsp;</p></td>';
                                echo '<td><p class="projectlistinghealth" style="background-color:'.gethealthcolor($processed_divisiondata[$division]["projectlisting"][$i]['management_rating']).'">&nbsp;</p></td>';
                                echo '<td><p class="projectlistinghealth" style="background-color:'.gethealthcolor($processed_divisiondata[$division]["projectlisting"][$i]['final_rating']).'">&nbsp;</p></td>';
                                echo '<td>'.$processed_divisiondata[$division]["projectlisting"][$i]['project_rank'].'</td>';
                                echo '<td>'.$processed_divisiondata[$division]["projectlisting"][$i]['outputs'].'</td>';
                                echo '<td>'.$processed_divisiondata[$division]["projectlisting"][$i]['completed_activities'].' / '.$processed_divisiondata[$division]["projectlisting"][$i]['total_activities'].' </td>';
                                echo '</tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="pagebreak"></div>
        <div class="row reportbody section3">
        	<h2 class="sectiontitle">Annex 2: Position Table</h2>
        	<div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                        	<th>&nbsp;</th>
                        	<th>Grade</th>
                            <th>Position Title</th>
                            <th>Position Number</th>
                            <th>Duty Station</th>
                            <th>Status</th>
                            <th>Staff Name</th>
                            <th>Org Code</th>
                            <th>Org Unit</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php 
                            for($i=0; $i < count($processed_divisiondata[$division]["stafflisting"]); $i++ ) {
                            	echo '<tr>';
                                echo '<td>'.($i+1).'.</td>';
                            	echo '<td>'.$processed_divisiondata[$division]["stafflisting"][$i]['grade'].'</td>';
                                echo '<td>'.$processed_divisiondata[$division]["stafflisting"][$i]['position_title'].'</td>';
                                echo '<td>'.$processed_divisiondata[$division]["stafflisting"][$i]['position_number'].'</td>';
                                echo '<td>'.$processed_divisiondata[$division]["stafflisting"][$i]['duty_station'].'</td>';
                                echo '<td>'.$processed_divisiondata[$division]["stafflisting"][$i]['position_status'].'</td>';
                                echo '<td>'.$processed_divisiondata[$division]["stafflisting"][$i]['staff_name'].'</td>';
                                echo '<td>'.$processed_divisiondata[$division]["stafflisting"][$i]['org_code'].'</td>';
                                echo '<td>'.$processed_divisiondata[$division]["stafflisting"][$i]['org_unit_description'].'</td>';
                                echo '</tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
