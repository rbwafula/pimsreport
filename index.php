<?php
	// Variables here
	$month = Date("M").' '.Date("Y");
	$division = ucwords('Africa');
	$projectcount = number_format(145);
	$totalactivities = number_format(178);
	$fundedactivities = number_format(0);
	$notfundedactivities = number_format(178);
	$overallbudget_currentyr = number_format(13814609, 0, '.', ',');
	$healthrating = 0.3;
	$colorcode = array(	'name' => ['red','yellow','green'], 
						'color' => ['dc3545', 'ffc107', '28a745'],
						'scale' => ['poor', 'fair', 'good']);

	function getHealthRating($a, $b) {
		if ($a > 0 && $a <= 0.3) {
			$color = '#'.$b['color'][0].' !important';
		} else if ($a > 0.3 && $a <= 0.7) {
			$color = '#'.$b['color'][1].' !important';
		} else if ($a > 0.7) {
			$color = '#'.$b['color'][2].' !important';
		}
		return $color;
	}
	function getHealthName($a, $b) {
		if ($a > 0 && $a <= 0.3) {
			$name = ucwords($b['scale'][0]);
		} else if ($a > 0.3 && $a <= 0.7) {
			$name = ucwords($b['scale'][1]);
		} else if ($a > 0.7) {
			$name = ucwords($b['scale'][2]);
		}
		return $name;
	}

	$healthrating_color = getHealthRating($healthrating, $colorcode);
	$healthrating_name = getHealthName($healthrating, $colorcode);


	$projects = strval($projectcount).' '.($projectcount == 1 ? 'project':'projects');
	$keystoneprojects = strval($fundedactivities).' '.($fundedactivities == 1 ? 'was a keystone project':'were keystone projects');
?>
<!DOCTYPE html>
<html>
<head>
	<title>A4 Report</title>
	<link rel="stylesheet" href="assets/css/highcharts.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet"> 
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
		@media print {
			body, page {
				margin: 0;
				box-shadow: 0;
			}
		}
	</style>
	
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
	<script src="assets/vendor/jquery/jquery.min.js"></script>
</head>
<body>
	<?php



		//BASE URL TO GET DATA FROM

		$url = 'https://staging1.unep.org/simon/pims-stg/modules/main/pims3-api/final_data';

		// CURL GET DATA FROM URL
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$data = curl_exec($ch);
		curl_close($ch);

		// DATA COMES IN AS STRING, CONVERT TO JSON OBJECT
		$division_data = json_decode($data);

		//DECLARE THE DIVISIONS ARRAY TO STORE UNIQUES DIVISIONS
		$unique_divisions = [];

		//USE DATA FROM API TO FEED THE UNIQUE DIVISIONS ARRAY

		foreach ($division_data as $key => $value) {
		    if (!in_array($value->managing_division, $unique_divisions)) {
		        $unique_divisions[] = $value->managing_division;
		    }
		}

		// FOR EACH UNIQUE DIVISION CREATE THE REPORT AND MAIL TO THE RELEVANT FOCAL POINTS

		foreach ($unique_divisions as $dkey => $dvalue) {
		//CALCULATE DIVISIONAL METRICS

		//calculate number of projects under this division
		    $d_projects = 0;
		    $d_nullprojects = 0;

		    foreach ($division_data as $key => $value) {
		        if ($value->managing_division == $dvalue) {
		            $d_projects += 1;
		        }

		        if ($value->managing_division == $dvalue && $value->final_rating == null) {
		            $d_nullprojects += 1;
		        }
		    }

		    if ($dvalue == $division) {
		    	$avgreporting = round(((1-($d_nullprojects/$d_projects))*100),1).'%';
		    	$projectcount = number_format($d_projects);
		    }

		    // display the division name its and number of projects
		    //echo '<br />' . $dvalue . ' - ' . $d_nullprojects.' / '.$d_projects;

		//THE REPORT CREATION AND MAILING FUNCTIONS COME HERE
		}

		//var_dump($division_data);
	?>
	<page size="A4">
		<div class="page-margin" style="padding: 2.54cm 1.32cm 3.67cm 1.9cm;">
			<div class="page-content" style="height: 23.49cm; width: 17.78cm; max-height: 23.49cm; max-width: 17.78cm;">
				<div class="header" style="display: -ms-flexbox;display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap; border-bottom: 0.1cm solid #707070; margin-bottom: 0.2cm;">
					<div class="logo" style="position: relative;width: 100%;-ms-flex: 0 0 30%;flex: 0 0 30%;max-width: 30%;margin-bottom: 0.5cm;">
						<img src="assets/images/pimslogo.png" style="max-width: 100%">
					</div>
					<div class="title" style="position: relative;width: 100%;-ms-flex: 0 0 50%;flex: 0 0 50%;max-width: 50%;margin-bottom: 0.5cm;text-align: center;">
						<h1 style="margin: 0;font-weight: 500;font-size: 0.9cm;color: #333;letter-spacing: 0;">
							<?php echo $division; ?>
						</h1>
						<h6 style="margin: 0;letter-spacing: 0;color: #707070;padding-top: 0.1cm;font-size: 0.35cm;font-weight: 400;">
							Programme Delivery Report
						</h6>
					</div>
					<div class="stamp" style="position: relative;width: 100%;-ms-flex: 0 0 20%;flex: 0 0 20%;max-width: 20%;margin-bottom: 0.5cm;text-align: right;">
						<p class="reportdate" style="margin: 0;font-size: 0.35cm;font-weight: 300;">
							<strong><?php echo $month; ?></strong>
						</p>
						<div>
							<div class="healthrating_box" style="border-radius: 50%;width: 1cm;height: 1cm;float: right;background-color:<? echo $healthrating_color; ?>; margin-top: 0.2cm">&nbsp;</div>
							<div style="float: right">
								<p><?php echo $avgreporting; ?></p>
								<p>Average Reporting %</p>
							</div>
						</div>
						
						


						<?php

							/*$url_finaldata = 'https://staging1.unep.org/simon/pims-stg/modules/main/pims3-api/final_data';
							$json_finaldata = file_get_contents($url_finaldata);
							$json_data_finaldata = json_decode($json_finaldata, true);
							

							//print_r($json_data);

							//echo "My token: ". $json_data["access_token"];

							echo '<pre>'.print_r($json_data_finaldata).'</pre>';

							$i = 0;
							$reported0 = 0;
							$reported1 = 0;

							for ($i = 0; $i <= count($json_data_finaldata); $i++) {

							}

							//echo $json_data_finaldata = count($json_data_finaldata);*/



						?>

						
					</div>
				</div>
				<div class="body" style="display: -ms-flexbox;display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap; border-bottom: 0.1cm solid #707070; margin-bottom: 0.5cm; padding: 0.2cm 0 0.2cm">
					<div class="left" style="position: relative;width: 100%;-ms-flex: 0 0 50%;flex: 0 0 50%;max-width: 50%;margin-bottom: 0.2cm;text-align: left;background-color: #f6f6f6;">
						<h5 style="margin: 0.4cm;font-size: 0.45cm;font-weight: 500;color: #333;">Summary</h5>
						<p style="margin: 0.2cm 0.4cm 0.4cm;text-align: justify;font-size: 0.33cm;font-weight: 300;line-height: 0.5cm;">The dashboard captured financial data of <strong><? echo $projectcount; ?> projects</strong> for the <?php echo $division; ?> Division. The overall budget recorded for this portfolio as of 2020 was <strong>(USD. <? echo $overallbudget_currentyr; ?>)</strong>, capturing a rolling total of the cash received over time.</p>
						<p style="margin: 0.2cm 0.4cm 0.4cm;text-align: justify;font-size: 0.33cm;font-weight: 300;line-height: 0.5cm;">Out of the <? echo $projects; ?>, <strong><? echo $keystoneprojects; ?></strong>, these are projects with dollar value of $ 10 million and above, contributing to <strong>USD. <? echo $fundedactivities; ?></strong> of the overall budget. Keystone projects are projects of significant value to the organization as they attract a higher dollar value and require further scrutiny by management, in comparison to other projects.</p>
					</div>
					<div class="right" style="position: relative;width: 100%;-ms-flex: 0 0 50%;flex: 0 0 50%;max-width: 50%;margin-bottom: 0.2cm;text-align: left;background-color: #f6f6f6;">
						<h5 style="margin: 0.4cm;font-size: 0.45cm;font-weight: 500;color: #333;">&nbsp;</h5>
						<div style="display: -ms-flexbox;display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap; margin:0 0.4cm">
							<div style="position: relative;width: 100%;-ms-flex: 0 0 25%;flex: 0 0 25%;max-width: 25%;margin-bottom: 0.5cm;text-align: left;background-color: #f6f6f6;">
								<div style="text-align: center; color: #0077b6;">
									<p style="margin: 0;font-size: 0.5cm;font-weight: 600;"><? echo $projectcount; ?></p>
									<p style="margin: 0;font-size: 0.3cm;font-weight: 400;">Total Projects</p>
								</div>
							</div>
							<div style="position: relative;width: 100%;-ms-flex: 0 0 25%;flex: 0 0 25%;max-width: 25%;margin-bottom: 0.5cm;text-align: left;background-color: #f6f6f6;">
								<div style="text-align: center; color: #688753;">
									<p style="margin: 0;font-size: 0.5cm;font-weight: 600;"><? echo $projectcount; ?></p>
									<p style="margin: 0;font-size: 0.3cm;font-weight: 400;"><? echo ucwords(trim(str_replace($projectcount, "", $projects))); ?> </p>
								</div>
							</div>
							<div style="position: relative;width: 100%;-ms-flex: 0 0 50%;flex: 0 0 50%;max-width: 50%;margin-bottom: 0.5cm;text-align: left;background-color: #f6f6f6;">
								<div style="text-align: center; color: #17a2b8;">
									<p style="margin: 0;font-size: 0.5cm;font-weight: 600;"><? echo '$ '.$overallbudget_currentyr; ?></p>
									<p style="margin: 0;font-size: 0.3cm;font-weight: 400;">Overall Budget</p>
								</div>
							</div>

							<div style="position: relative;width: 100%;-ms-flex: 0 0 50%;flex: 0 0 50%;max-width: 50%;margin-bottom: 0.5cm;text-align: left;background-color: #f6f6f6;">
								<div id="chart1"></div>
							</div>
							<div style="position: relative;width: 100%;-ms-flex: 0 0 100%;flex: 0 0 100%;max-width: 100%;margin-bottom: 0.5cm;text-align: left;background-color: #f6f6f6;">
								<div id="chart2"></div>
								<script type="text/javascript">
									Highcharts.chart('chart2', {
									    colors: ['#6c757d', '#17a2b8'],
									    credits: {
									        text: 'Source: PIMS+ Dev',
									        href: 'https://staging1.unep.org/simon/pims-stg'
									    },
									    chart: {
									        backgroundColor: '#F6F6F6',
									        type: 'column',
									        height: 150
									    },
									    title: {
									        text: 'Budget Utilization',
									        floating: true,
									        align: 'center',
        									x: 30,
        									y: 0,
        									style: {
        										fontSize: '0.35cm',
        										fontWeight: 'bold'
        									}
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
									            borderWidth: 0
									        }
									    },
									    series: [{
									        name: '2019',
									        data: [5.5, 4.8, 0.7]

									    }, {
									        name: '2020',
									        data: [6, 5, 1]

									    }]
									});
								</script>
							</div>
						</div>
					</div>


					<div class="left" style="position: relative;width: 100%;-ms-flex: 0 0 50%;flex: 0 0 50%;max-width: 50%;margin-bottom: 0.2cm;text-align: left;">
						<h5 style="margin: 0.4cm;font-size: 0.45cm;font-weight: 500;color: #333;">Portfolio Statistics</h5>

						<div class="container" style="display: -ms-flexbox;display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap;">
							<div class="left" style="position: relative;width: 100%;-ms-flex: 0 0 50%;flex: 0 0 50%;max-width: 50%;margin-bottom: 0.2cm;text-align: left;">
								<!--<div id="riskschart" style="position:absolute; left:0px; top:0px;"></div>
								<div id="addText" style="position:absolute; left:0px; top:0px;"></div>-->


								<div id="container-speed" style="width: 300px; height: 200px; float: left"></div>


								<div style="width: 600px; height: 400px; margin: 0 auto">
    <div id="container-speed" style="width: 300px; height: 200px; float: left"></div>
    <div id="container-rpm" style="width: 300px; height: 200px; float: left"></div>
</div>




								<script type="text/javascript">
									const gaugeOptions = {
									    chart: {
									        type: 'solidgauge'
									    },
									    title: null,
									    pane: {
									        center: ['50%', '85%'],
									        size: '140%',
									        startAngle: -90,
									        endAngle: 90,
									        background: {
									            backgroundColor: '#EEE',
									            innerRadius: '60%',
									            outerRadius: '100%',
									            shape: 'arc'
									        }
									    },
									    tooltip: {
									        enabled: false
									    },
									    // the value axis
									    yAxis: {
									        minColor: '#FFFFFF',
									        maxColor: '#000000',
									        lineWidth: 0,
									        minorTickInterval: null,
									        tickPixelInterval: 400,
									        tickWidth: 0,
									        title: {
									            y: -70
									        },
									        labels: {
									            y: 16
									        }
									    },
									    plotOptions: {
									        solidgauge: {
									            dataLabels: {
									                y: -30,
									                borderWidth: 0,
									                useHTML: true
									            }
									        }
									    }
									};

									Highcharts.chart('container-speed', Highcharts.merge(gaugeOptions, {
									    yAxis: {
									        min: 0,
									        max: 200,
									        title: {
									            text: 'Speed'
									        }
									    },
									    credits: {
									        enabled: false
									    },
									    series: [{
									        name: 'Speed',
									        data: [30],
									        dataLabels: {
									            format:
									                '<div style="text-align:center">' +
									                '<span style="font-size:25px;color:black">{y}</span><br/>' +
									                '<span style="font-size:12px;color:silver">km/h</span>' +
									                '</div>'
									        },
									        tooltip: {
									            valueSuffix: ' km/h'
									        }
									    }]
									}));

								</script>
								<div id="timetaken"></div>
								<div id="activitiescompleted"></div>



							</div>
							<div class="right" style="position: relative;width: 100%;-ms-flex: 0 0 50%;flex: 0 0 50%;max-width: 50%;margin-bottom: 0.2cm;text-align: left;">
								<div id="activitieschart" style="display:none;margin: 0.2cm 0.4cm 0.4cm;text-align: justify;font-size: 0.33cm;font-weight: 300;line-height: 0.5cm;"></div>
							</div>
						</div>




						
						<script type="text/javascript">
							$(function() {
							    var chart = new Highcharts.Chart({
							        chart: {
							            renderTo: 'riskschart',
							            type: 'pie',
							            margin: [0, 0, 0, 0],
								        spacingTop: 0,
								        spacingBottom: 0,
								        spacingLeft: 0,
								        spacingRight: 0,
								        width: 120,
								        height: 200
							        },
							        title: {
								        text: ''
								    },
								    credits: {
								        enabled: false
								    },
							        plotOptions: {
							            pie: {
							            	size: '100%',
							                innerSize: '80%',
							                center: ['50%', '20%'],
							                dataLabels: {
								                enabled: false,
								            }
							            }
							        },
							        series: [{
							        	data: (function() {
							            var names = 'Covid-19,Insufficient Funding,Delayed Funding',
							                arr = [];

							            Highcharts.each(names.split(','), function(name) {
							                arr.push({
							                    name: name,
							                    y: Math.round(Math.random() * 100)
							                });
							            });

							            return arr;
							        }())}]
							    },
							                                     
							    function(chart) { // on complete
							        var textX = chart.plotLeft + (chart.plotWidth  * 0.5);
							        var textY = chart.plotTop  + (chart.plotHeight * 0.5);

							        var span = '<span id="pieChartInfoText" style="position:absolute; text-align:center;color:#0077b6;">';
							        span += '<span style="font-size: 0.8cm; font-weight: 500;">92</span><br>';
							        span += '<span style="font-size: 0.4cm">Risks</span>';
							        span += '</span>';

							        $("#addText").append(span);
							        span = $('#pieChartInfoText');
							        span.css('left', textX + (span.width() * -0.5));
							        span.css('top', textY + (span.height() * -1.3));
							    });
							});


							/*Highcharts.chart('riskschart', {
							    chart: {
							        type: 'pie',
							        margin: [0, 0, 0, 0],
							        spacingTop: 0,
							        spacingBottom: 0,
							        spacingLeft: 0,
							        spacingRight: 0,
							        width: 120,
							        height: 200
							    },
							    plotOptions: {
							        pie: {
							        	size: 80,
							            shadow: false,
							            center: ['50%', '20%'],
							            innerSize: 60,
							            dataLabels: {
							                enabled: false,
							            }
							        }
							    },
							    title: {
							        text: ''
							    },
							    credits: {
							        enabled: false
							    },
							    legend: {
							        layout: 'horizontal',
							        align: 'right',
							        verticalAlign: 'bottom',
							        y: 0,
							        title: {
							            text: 'Risk'
							        },
							        enabled: false
							    },
							    tooltip: {
					                formatter: function() {
					                    return '<b>'+ this.point.name +'</b>: '+ this.y +' projects ('+ Highcharts.numberFormat(this.point.percentage,1) +'%)';
					                }
					            },
							    series: [{
							        data: (function() {
							            var names = 'Covid-19,Insufficient Funding,Delayed Funding',
							                arr = [];

							            Highcharts.each(names.split(','), function(name) {
							                arr.push({
							                    name: name,
							                    y: Math.round(Math.random() * 100)
							                });
							            });

							            return arr;
							        }()),
							        showInLegend: true
							    }]
							},
                                     
						    function(chart) { // on complete
						        var textX = chart.plotLeft + (chart.plotWidth  * 0.5);
						        var textY = chart.plotTop  + (chart.plotHeight * 0.5);

						        var span = '<span id="pieChartInfoText" style="position:absolute; text-align:center;">';
						        span += '<span style="font-size: 32px">Upper</span><br>';
						        span += '<span style="font-size: 16px">Lower</span>';
						        span += '</span>';

						        $("#addText").append(span);
						        span = $('#pieChartInfoText');
						        span.css('left', textX + (span.width() * -0.5));
						        span.css('top', textY + (span.height() * -0.5));
						    });*/
						</script>


						<script type="text/javascript">
							Highcharts.chart('activitieschart', {
							    chart: {
							        type: 'pie',
							        margin: [0, 0, 0, 0],
							        spacingTop: 0,
							        spacingBottom: 0,
							        spacingLeft: 0,
							        spacingRight: 0,
							        width: 120,
							        height: 200
							    },
							    plotOptions: {
							        pie: {
							        	size: 80,
							            shadow: false,
							            center: ['50%', '20%'],
							            innerSize: 60,
							            dataLabels: {
							                enabled: false,
							            }
							        }
							    },
							    title: {
							        text: '72 Activities',
							        verticalAlign: 'middle',
    								floating: true
							    },
							    credits: {
							        enabled: false
							    },
							    legend: {
							        layout: 'horizontal',
							        align: 'right',
							        verticalAlign: 'bottom',
							        y: 0,
							        title: {
							            text: 'Risk'
							        },
							        enabled: false
							    },
							    tooltip: {
					                formatter: function() {
					                    return '<b>'+ this.point.name +'</b>: '+ this.y +' projects ('+ Highcharts.numberFormat(this.point.percentage,1) +'%)';
					                }
					            },
							    series: [{
							        data: (function() {
							            var names = 'Covid-19,Insufficient Funding,Delayed Funding',
							                arr = [];

							            Highcharts.each(names.split(','), function(name) {
							                arr.push({
							                    name: name,
							                    y: Math.round(Math.random() * 100)
							                });
							            });

							            return arr;
							        }()),
							        showInLegend: true
							    }]
							});
						</script>
					</div>

					<!--<div class="left" style="position: relative;width: 100%;-ms-flex: 0 0 25%;flex: 0 0 25%;max-width: 25%;margin-bottom: 0.2cm;text-align: left;">
						<h5 style="margin: 0.4cm;font-size: 0.45cm;font-weight: 500;color: #333;">&nbsp;</h5>
						<p style="margin: 0.2cm 0.4cm 0.4cm;text-align: justify;font-size: 0.33cm;font-weight: 300;line-height: 0.5cm;">The dashboard captured financial data of <strong><? echo $projects; ?></strong> for the <?php echo $division; ?> Division. The overall budget recorded for this portfolio as of 2020 was <strong>(USD. <? echo $overallbudget_currentyr; ?>)</strong>, capturing a rolling total of the cash received over time.</p>
						<p style="margin: 0.2cm 0.4cm 0.4cm;text-align: justify;font-size: 0.33cm;font-weight: 300;line-height: 0.5cm;">Out of the <? echo $projects; ?>, <strong><? echo $keystoneprojects; ?></strong>, these are projects with dollar value of $ 10 million and above, contributing to <strong>USD. <? echo $fundedactivities; ?></strong> of the overall budget. Keystone projects are projects of significant value to the organization as they attract a higher dollar value and require further scrutiny by management, in comparison to other projects.</p>
					</div>-->




					<div class="left" style="position: relative;width: 100%;-ms-flex: 0 0 50%;flex: 0 0 50%;max-width: 50%;margin-bottom: 0.2cm;text-align: left;">
						<h5 style="margin: 0.4cm;font-size: 0.45cm;font-weight: 500;color: #333;">Portfolio Health</h5>
						<p style="margin: 0.2cm 0.4cm 0.4cm;text-align: justify;font-size: 0.33cm;font-weight: 300;line-height: 0.5cm;">The overall portfolio health as calculated by the systems algorithm was <strong style="color:<? echo $healthrating_color; ?>; font-weight: 700;"><? echo $healthrating_name.' ('.($healthrating*100).'%)'; ?></strong>, indicating that all the projects need close monitoring by the respective Project Managers.</p>

						<p style="margin: 0.2cm 0.4cm 0.2cm;text-align: justify;font-size: 0.33cm;font-weight: 300;line-height: 0.5cm;">A breakdown of the caclulated portfolio health score is as follows:</p>
						<div class="calculations" style="width: 200px;margin: 0 auto;">
							<table style="width: 100%;margin: 0cm 0.4cm 0.4cm;text-align: justify;font-size: 0.33cm;font-weight: 300;line-height: 0.5cm;border-collapse: collapse;">
								<thead style="border-bottom: 1px solid rgba(0,0,0,.5) !important">
									<tr>
										<th>Element</th>
										<th>Score</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>System Rating</td>
										<td style="text-align: right;padding-right: 5px;"><?php echo $healthrating*100; ?>%</td>
										<td><span class="rating" style="width: 0.33cm;display: inline-block;height: 0.33cm;margin: 0;border-radius: 50%;background-color:<?php echo $healthrating_color; ?>"></span></td>
									</tr>
									<tr>
										<td>Management Rating</td>
										<td style="text-align: right;padding-right: 5px;"><?php echo $healthrating*100; ?>%</td>
										<td><span class="rating" style="width: 0.33cm;display: inline-block;height: 0.33cm;margin: 0;border-radius: 50%;background-color:<?php echo $healthrating_color; ?>"></span></td>
									</tr>
									<tr style="border-top: 1px dotted rgba(0,0,0,.5) !important;">
										<td><strong><i>Average Rating</i></strong></td>
										<td style="text-align: right;padding-right: 5px;"><strong><i><?php echo $healthrating*100; ?>%</i></strong></td>
										<td><span class="rating" style="width: 0.33cm;display: inline-block;height: 0.33cm;margin: 0;border-radius: 50%;background-color:<?php echo $healthrating_color; ?>"></span></td>
									</tr>
								</tbody>
							</table>
							<table style="width: 100%;margin: 0cm 0.4cm 0.4cm;text-align: justify;font-size: 0.33cm;font-weight: 300;line-height: 0.5cm;border-collapse: collapse;">
								<thead>
									<tr>
										<th style="font-style: italic;">Key</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td style="text-align: right;padding-right: 5px;"><span class="rating" style="width: 0.33cm;display: inline-block;height: 0.33cm;margin: 0;border-radius: 50%;background-color:#cd4f4f"></span></td>
										<td style="text-align: left;padding-right: 5px;">Poor</td>
										<td style="text-align: right;padding-right: 5px;"><span class="rating" style="width: 0.33cm;display: inline-block;height: 0.33cm;margin: 0;border-radius: 50%;background-color:#f9c034"></span></td>
										<td style="text-align: left;padding-right: 5px;">Fair</td>
										<td style="text-align: right;padding-right: 5px;"><span class="rating" style="width: 0.33cm;display: inline-block;height: 0.33cm;margin: 0;border-radius: 50%;background-color:#539e46"></span></td>
										<td style="text-align: left;padding-right: 5px;">Good</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="footer">Footer</div>
			</div>
		</div>
	</page>
	<page size="A4">
		<div class="page-margin" style="padding: 1.9cm 1.32cm 3.67cm 1.9cm;">
			<div class="page-content" style="height: 23.49cm; width: 17.78cm; max-height: 23.49cm; max-width: 17.78cm;">
				<div class="header">Header</div>
				<div class="body">Body</div>
				<div class="footer">Footer</div>
			</div>
		</div>
	</page>	
</body>
</html>