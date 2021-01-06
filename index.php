<?php
// Variables here
$month = Date("M") . ' ' . Date("Y");
$division = ucwords('Africa');
?>
<!DOCTYPE html>
<html>
<head>
	<title>A4 Report</title>
	<link rel="stylesheet" href="assets/css/highcharts.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/highcharts-more.js"></script>
	<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>

    <style type="text/css">
        body {
            background: rgb(204,204,204);
            font-family: 'Roboto', sans-serif;
            color: #707070;
        }
        page {
            background: white;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
        }
        page[size="A4"] {
            width: 21cm;
            height: 29.7cm;
        }
        page[size="A4"][layout="landscape"] {
            width: 29.7cm;
            height: 21cm;
        }
        page[size="A3"] {
            width: 29.7cm;
            height: 42cm;
        }
        page[size="A3"][layout="landscape"] {
            width: 42cm;
            height: 29.7cm;
        }
        page[size="A5"] {
            width: 14.8cm;
            height: 21cm;
        }
        page[size="A5"][layout="landscape"] {
            width: 21cm;
            height: 14.8cm;
        }
        .highcharts-container {
            margin: 0 auto;
        }

        @import 'https://code.highcharts.com/css/highcharts.css';
        /*#container {
            height: 400px;
            max-width: 800px;
            margin: 0 auto;
        }*/
        .bysubprogramme .highcharts-container {
            margin:0;
        }
        .gauges .highcharts-container {
            height: 70px !important;
        }

        .gauges .highcharts-root {
            margin-top: -55%;
        }

        .tablelisting {
            border-collapse: collapse;
            margin: 0px 0;
            font-size: 12px;
            font-family: 'Roboto',sans-serif;
            min-width: 400px;
            /*box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);*/
        }
        .tablelisting thead tr {
            background-color: #009879;
            color: #ffffff;
            text-align: left;
        }
        .tablelisting th,
        .tablelisting td {
            padding: 5px;
        }
        .tablelisting tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        .tablelisting tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .tablelisting tbody tr:last-of-type {
            border-bottom: 2px solid #009879;
        }
        .tablelisting .styled-table tbody tr.active-row {
            font-weight: bold;
            color: #009879;
        }






        @media print {
            body, page {
                margin: 0;
                box-shadow: 0;
            }
        }
    </style>
	
</head>
<body>
	<page size="A4">
		<div class="page-margin" style="padding: 0.8cm 1.32cm 0.8cm 1.32cm;">
			<div class="page-content" style="height: 28.1cm; width: 18.36cm; max-height: 28.1cm; max-width: 18.36cm;">
				<div class="header" style="display: -ms-flexbox;display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap; border-bottom: 0.1cm solid #707070; margin-bottom: 0.2cm;">
					<div class="logo" style="position: relative;width: 100%;-ms-flex: 0 0 30%;flex: 0 0 30%;max-width: 30%;margin-bottom: 0.2cm;">
                        <table style="border-collapse: collapse; float: left;">
                            <tr>
                                <td>
                                    <img src="assets/images/pimslogo.png" style="max-width: 100%">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p style="font-size: 0.6cm;text-align: left;font-weight: 600;margin:0;">
                                        <?php echo $processed_divisiondata[$division]["reportedprojectspct"];?>%
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p style="margin: 0;font-size: 0.3cm;color: #17a2b8;">Compliance Reporting</p>
                                </td>
                            </tr>
                        </table>
						
					</div>
					</div>
                    <div class="stamp" style="position: relative;width: 100%;-ms-flex: 0 0 20%;flex: 0 0 20%;max-width: 20%;margin-bottom: 0.2cm;text-align: right;">
                        <table style="border-collapse: collapse; float: right; width: 5cm">
                            <tr>
                                <td>
                                    <p style="margin: 0;font-size: 0.35cm;font-weight: 400; margin-bottom: 0.2cm; margin-right: 25px;">
                                        <?php echo $month; ?>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td width="1cm">
                                    <div class="healthrating_box" style="border-radius: 30%;width: 1cm;height: 1cm;float: right;background-color:<?php echo $processed_divisiondata[$division]["healthcolor"];?>; margin-top: 0cm; margin-right:30px;">&nbsp;</div>
                                    <?php //echo $processed_divisiondata[$division]["healthrating"];?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p style="margin: 0;font-size: 0.3cm;color: #17a2b8;">Project Portfolio Rating</p>
                                </td>
                            </tr>
                        </table>
                    </div>
				</div>
				<div class="body" style="display: -ms-flexbox;display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap; border-bottom: 0.1cm solid #707070; margin-bottom: 0.5cm; padding: 0.2cm 0 0.2cm">
					<div class="left" style="position: relative;width: 100%;-ms-flex: 0 0 50%;flex: 0 0 50%;max-width: 50%;margin-bottom: 0.2cm;text-align: left;background-color: #f6f6f6;">
						<h5 style="margin: 0.2cm 0.4cm;font-size: 0.45cm;font-weight: 500;color: #333;">Summary</h5>
						<p style="margin: 0.2cm 0.4cm 0.4cm;text-align: justify;font-size: 0.33cm;font-weight: 300;line-height: 0.5cm;">The dashboard captured financial data of <strong><?php echo $processed_divisiondata[$division]["totalprojects"];?> projects</strong> for the <?php echo $division; ?> Office. The overall budget recorded for this portfolio as of 2020 was <strong>(USD. <?php echo number_format($processed_divisiondata[$division]["consumablebudget"], 0, '.', ',');?>)</strong>, capturing a rolling total of the cash received over time.</p>
						<?php 
                           // echo '<p style="display:none;margin: 0.2cm 0.4cm 0.4cm;text-align: justify;font-size: 0.33cm;font-weight: 300;line-height: 0.5cm;">Out of the '.$projects.', <strong>.'.$keystoneprojects.'.</strong>, these are projects with dollar value of $ 10 million and above, contributing to <strong>USD. '.$fundedactivities.'</strong> of the overall budget. Keystone projects are projects of significant value to the organization as they attract a higher dollar value and require further scrutiny by management, in comparison to other projects.</p>';
                        ?>
                        

                        <div class="bysubprogramme">
                            <div id="bysubprogramme_chart"></div>
                            <script type="text/javascript">
                                Highcharts.chart('bysubprogramme_chart', {
                                    credits: {
                                        text: ''
                                    },
                                    chart: {
                                        backgroundColor: 'transparent',
                                        type: 'column',
                                        height: 200
                                    },
                                    title: {
                                        text: 'Projects by Sub-Programme',
                                        floating: false,
                                        align: 'center',
                                        verticalAlign: 'bottom',
                                        margin: 0,
                                        style: {
                                            color: '#707070',
                                            fontSize: '10px',
                                            fontWeight: '700',
                                            textTransform: 'none'
                                        },
                                        x: 30,
                                        y: 5,
                                        /*style: {
                                            fontSize: '0.35cm',
                                            fontWeight: 'bold'
                                        }*/
                                    },
                                    xAxis: {
                                        categories: <?php echo json_encode($d_subprogramme_projects_distribution_number); ?>,
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
                                            text: 'Projects'
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
                                        data: <?php echo json_encode($d_subprogramme_projects_distribution_projects); ?>,
                                        showInLegend: false

                                    }]
                                });
                            </script>
                        </div>
					</div>
					<div class="right" style="position: relative;width: 100%;-ms-flex: 0 0 50%;flex: 0 0 50%;max-width: 50%;margin-bottom: 0.2cm;text-align: left;background-color: #f6f6f6;">
						<h5 style="margin: 0.2cm 0.4cm;font-size: 0.45cm;font-weight: 500;color: #333;">&nbsp;</h5>
						<div style="display: -ms-flexbox;display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap; margin:0 0.4cm">
							<div style="position: relative;width: 100%;-ms-flex: 0 0 25%;flex: 0 0 25%;max-width: 25%;margin-bottom: 0.5cm;text-align: left;background-color: #f6f6f6;">
								<div style="text-align: center; color: #0077b6;">
									<p style="margin: 0;font-size: 0.5cm;font-weight: 600;"><?php echo number_format($processed_divisiondata[$division]["totalprojects"],0,'.',',');?></p>
									<p style="margin: 0;font-size: 0.25cm;font-weight: 400;">Total Projects</p>
								</div>
							</div>
							<div style="position: relative;width: 100%;-ms-flex: 0 0 25%;flex: 0 0 25%;max-width: 25%;margin-bottom: 0.5cm;text-align: left;background-color: #f6f6f6;">
								<div style="text-align: center; color: #17a2b8;">
									<p style="margin: 0;font-size: 0.5cm;font-weight: 600;"><?php echo number_format($processed_divisiondata[$division]["totaloutputs"],0,'.',',');?></p>
									<p style="margin: 0;font-size: 0.25cm;font-weight: 400;">Total Outputs</p>
								</div>
							</div>
							<div style="position: relative;width: 100%;-ms-flex: 0 0 25%;flex: 0 0 25%;max-width: 25%;margin-bottom: 0.5cm;text-align: left;background-color: #f6f6f6;">
								<div style="text-align: center; color: #688753;">
									<p style="margin: 0;font-size: 0.5cm;font-weight: 600;"><?php echo number_format($processed_divisiondata[$division]["totalactivities"],0,'.',',');?></p>
									<p style="margin: 0;font-size: 0.25cm;font-weight: 400;">Total Activities</p>
								</div>
							</div>
                            <div style="position: relative;width: 100%;-ms-flex: 0 0 25%;flex: 0 0 25%;max-width: 25%;margin-bottom: 0.5cm;text-align: left;background-color: #f6f6f6;">
                                <div style="text-align: center; color: #dc3545;">
                                    <p style="margin: 0;font-size: 0.5cm;font-weight: 600;"><?php echo number_format($processed_divisiondata[$division]["pastdueprojects"],0,'.',',');?></p>
                                    <p style="margin: 0;font-size: 0.25cm;font-weight: 400;">Expired Projects</p>
                                </div>
                            </div>
							

							<div style="position: relative;width: 100%;-ms-flex: 0 0 50%;flex: 0 0 50%;max-width: 50%;margin-bottom: 0.5cm;text-align: left;background-color: #f6f6f6;">
								<div id="chart1"></div>
							</div>
							<div style="position: relative;width: 100%;-ms-flex: 0 0 100%;flex: 0 0 100%;max-width: 100%;margin-bottom: 0.5cm;text-align: left;background-color: #f6f6f6;">
								<div id="chart2"></div>
								<script type="text/javascript">
									Highcharts.chart('chart2', {
									    colors: ['#17a2b8'],
									    credits: {
									        text: ''
									    },
									    chart: {
									        backgroundColor: '#F6F6F6',
									        type: 'column',
									        height: 200
									    },
									    title: {
									        text: 'Budget Utilization',
									        floating: true,
									        align: 'center',
                                            verticalAlign: 'bottom',
                                            margin: 0,
                                            style: {
                                                color: '#707070',
                                                fontSize: '12px',
                                                fontWeight: '500',
                                                textTransform: 'none'
                                            },
        									x: 30,
        									y: 30,
        									/*style: {
        										fontSize: '0.35cm',
        										fontWeight: 'bold'
        									}*/
									    },
									    xAxis: {
									        categories: [
									            'Consumable Budget',
									            'Consumed Budget',
									            'Budget Balance'
									        ],
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
									            text: 'USD (M)'
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
									        useHTML: true
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
									        name: '2020',
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


					<div class="left" style="position: relative;width: 100%;-ms-flex: 0 0 50%;flex: 0 0 50%;max-width: 50%;margin-bottom: 0.2cm;text-align: left;">
						<h5 style="margin: 0.4cm;font-size: 0.45cm;font-weight: 500;color: #333;">Portfolio Statistics</h5>
						<div class="container gauges" style="display: -ms-flexbox;display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap;">
                            <table style="border-collapse: collapse; width: 350px; height: 100px;">
                                <tr>
                                    <td height="70px" width="33%" style="background-color: transparent; width: 33%; max-width: 33%; vertical-align: top;">
                                        <div id="budgetutilized_chart"></div>
                                        
                                    </td>
                                    <td width="33%" style="background-color: transparent; width: 33%; max-width: 33%; vertical-align: top;">
                                        <div id="timetaken_chart"></div>
                                    </td>
                                    <td width="33%" style="background-color: transparent; width: 33%; max-width: 33%; vertical-align: top;">
                                        <div id="activitiescompleted_chart"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background-color: transparent; width: 33%; max-width: 33%; vertical-align: top;text-align: center;font-size: 0.33cm;" width="33%">
                                        <p style="margin:0;">Budget Spent</p>
                                    </td>
                                    <td style="background-color: transparent; width: 33%; max-width: 33%; vertical-align: top;text-align: center;font-size: 0.33cm;" width="33%">
                                        <p style="margin:0;">Time Used</p>
                                    </td>
                                    <td style="background-color: transparent; width: 33%; max-width: 33%; vertical-align: top;text-align: center;font-size: 0.33cm;" width="33%">
                                        <p style="margin:0;">Activities Completed</p>
                                    </td>
                                </tr>
                            </table>
							<div id="budgetutilized" style="position: relative;width: 33%;-ms-flex: 0 0 33%;flex: 0 0 33%;max-width: 33%;margin-bottom: 0.2cm;text-align: left;">

                                

                                <script type="text/javascript">
                                    Highcharts.chart('budgetutilized_chart', {
                                        chart: {
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
                                </script>

                                

                                
                            </div>
                            <div id="timetaken" style="position: relative;width: 33%;-ms-flex: 0 0 33%;flex: 0 0 33%;max-width: 33%;margin-bottom: 0.2cm;text-align: left;">
                                
                                <script type="text/javascript">
                                    Highcharts.chart('timetaken_chart', {
                                        chart: {
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
                                </script>
                                
							</div>
							<div id="activitiescompleted" style="position: relative;width: 33%;-ms-flex: 0 0 33%;flex: 0 0 33%;max-width: 33%;margin-bottom: 0.2cm;text-align: left;">
								
								<script type="text/javascript">

                                    Highcharts.chart('activitiescompleted_chart', {
                                        chart: {
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
							
						</div>
						<div class="container" style="display: -ms-flexbox;display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap;">
							<div id="projectdis" style="position: relative;width: 100%;-ms-flex: 0 0 100%;flex: 0 0 100%;max-width: 100%;margin-bottom: 0.2cm;text-align: left;">
								<div id="budgetage_chart"></div>
								<script type="text/javascript">
									Highcharts.chart('budgetage_chart', {
                                        colors: ['#17a2b8'],
                                        credits: {
                                            text: 'Figure n'
                                        },
                                        chart: {
                                            type: 'bar',
                                            height: 180
                                        },
                                        title: {
                                            text: 'Figure n: Grouping by Age',
                                            floating: false,
                                            align: 'left',
                                            verticalAlign: 'top',
                                            margin: 0,
                                            style: {
                                                color: '#333',
                                                fontSize: '11px',
                                                fontWeight: '600',
                                                textTransform: 'none',
                                            },
                                            x: 30,
                                            y: 0
                                        },
                                        xAxis: {
                                            categories: ['0-2 Y', '2-5 Y', '5-10 Y', '10+ Y'],
                                            title: {
                                                text: 'Age Category',
                                                style: {
                                                    fontSize: '0.3cm'
                                                }
                                            },
                                            labels: {
                                                style: {
                                                    fontSize: '0.2cm'
                                                }
                                            }
                                        },
                                        yAxis: {
                                            min: 0,
                                            title: {
                                                text: '',
                                                style: {
                                                    fontSize: '0.3cm'
                                                },
                                                align: 'high'
                                            },
                                            labels: {
                                                overflow: 'justify'
                                            }
                                        },
                                        tooltip: {
                                            valueSuffix: ' years'
                                        },
                                        plotOptions: {
                                            bar: {
                                                dataLabels: {
                                                    enabled: true,
                                                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black',
                                                    formatter: function(){
                                                        return (this.y!=0)?this.y:"";
                                                    }
                                                },
                                                pointPadding: 0,
                                                groupPadding: 0.1
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

							<div id="budgetsize" style="position: relative;width: 100%;-ms-flex: 0 0 100%;flex: 0 0 100%;max-width: 100%;margin-bottom: 0.2cm;text-align: left;">
								<div id="budgetsize_chart"></div>
								<script type="text/javascript">
                                    $(function () {
                                        Highcharts.setOptions({
                                            lang: {
                                                thousandsSep: ','
                                            }
                                        });
                                        
                                        $('#budgetsize_chart').highcharts({
                                            credits: {
                                                text: 'Figure n'
                                            },
                                            chart: {
                                                type: 'bar',
                                                height: 180
                                            },
                                            title: {
                                                text: 'Figure n: Grouping by Budget Size',
                                                floating: false,
                                                align: 'left',
                                                verticalAlign: 'top',
                                                margin: 0,
                                                style: {
                                                    color: '#333',
                                                    fontSize: '11px',
                                                    fontWeight: '600',
                                                    textTransform: 'none',
                                                },
                                                x: 30,
                                                y: 0
                                            },
                                            xAxis: {
                                                categories: ['0-1 M','1-2 M', '2-5 M', '5-10 M', '10+ M'],
                                                title: {
                                                    text: 'Budget Size',
                                                    style: {
                                                        fontSize: '0.3cm'
                                                    }
                                                },
                                                labels: {
                                                    style: {
                                                        fontSize: '0.2cm'
                                                    }
                                                }
                                            },
                                            yAxis: {
                                                min: 0,
                                                title: {
                                                    text: '',
                                                    style: {
                                                        fontSize: '0.3cm'
                                                    },
                                                    align: 'high'
                                                },
                                                labels: {
                                                    overflow: 'justify'
                                                }
                                            },
                                            tooltip: {
                                                valueSuffix: ' millions'
                                            },
                                            plotOptions: {
                                                bar: {
                                                    dataLabels: {
                                                        enabled: true,
                                                        formatter: function(){
                                                            return (this.y!=0)? Highcharts.numberFormat(this.y,1):"";
                                                        }
                                                    },
                                                    pointPadding: 0,
                                                    groupPadding: 0.1
                                                }
                                            },
                                            series: [{
                                                name: 'Grant Funding',
                                                data: <?php echo json_encode($processed_divisiondata[$division]["grantfundingbygroup"]); ?>,
                                                color: '#0077b6',
                                                showInLegend: false
                                            }]
                                        });
                                    });


									
								</script>
							</div>
						</div>

				</div>
				<div class="footer">Footer</div>
			</div>
		</div>
	</page>
	<page size="A4" layout="landscape">
		<div class="page-margin" style="padding: 0.8cm 1.32cm 0.8cm 1.32cm;">
			<div class="page-content" style="height: 18.36cm; width: 27.1cm; max-height: 18.36cm; max-width: 28.1cm;">
				<h5 style="margin: 0.2cm 0.4cm 0.4cm;font-size: 0.45cm;font-weight: 500;color: #333;">Annex 1: Projects Table</h5>
                <div id="annex1" class="tablelisting" style="width: 100%; max-width: 100%; box-sizing: border-box; margin: 0 auto 1em; -moz-box-sizing: border-box;">
                    <table style="width:100%; table-layout: auto !important; border-collapse: collapse;">
                        <thead>
                            <th>Project ID</th>
                            <th>Project Title</th>
                            <th>Subprogramme</th>
                            <th >Budget</th>
                            <th>System Rating</th>
                            <th>Management Rating</th>
                            <th>Reported</th>
                            <th>Project Manager</th>
                            <th>Outputs</th>
                            <th>Completed Activities</th>
                            <th>Total Activities</th>
                        </thead>
                        <tbody>
                            <?php 
                                for($i=0; $i < count($processed_divisiondata[$division]["projectlisting"]); $i++ ) {
                                    echo '<tr>';
                                    echo '<td>'.$processed_divisiondata[$division]["projectlisting"][$i]['project_id'].'</td>';
                                    echo '<td>'.$processed_divisiondata[$division]["projectlisting"][$i]['project_title'].'</td>';
                                    echo '<td>'.$processed_divisiondata[$division]["projectlisting"][$i]['subprogramme'].'</td>';
                                    echo '<td>'.number_format($processed_divisiondata[$division]["projectlisting"][$i]['budget'],2,'.',',') .'</td>';
                                    echo '<td>'.$processed_divisiondata[$division]["projectlisting"][$i]['system_rating'].'</td>';
                                    echo '<td>'.$processed_divisiondata[$division]["projectlisting"][$i]['management_rating'].'</td>';
                                    echo '<td>'.$processed_divisiondata[$division]["projectlisting"][$i]['reported'].'</td>';
                                    echo '<td>'.$processed_divisiondata[$division]["projectlisting"][$i]['project_manager'].'</td>';
                                    echo '<td>'.$processed_divisiondata[$division]["projectlisting"][$i]['outputs'].'</td>';
                                    echo '<td>'.$processed_divisiondata[$division]["projectlisting"][$i]['completed_activities'].'</td>';
                                    echo '<td>'.$processed_divisiondata[$division]["projectlisting"][$i]['total_activities'].'</td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
			</div>
		</div>
	</page>
</body>
</html>
