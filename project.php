<?php
$month = Date("M") . ' ' . Date("Y");
include_once 'proj_algo.php';
$projectid = (isset($_GET['id'])) ? strtoupper($_GET['id']) : strtoupper(key($projectlisting));
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $projectlisting[$projectid]["id"];?> | PIMS+ Report</title>
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
    <script src="assets/vendor/html2pdf/html2pdf.bundle.js"></script>

    <link href="assets/vendor/select2/select2.min.css" rel="stylesheet" />
    <script src="assets/vendor/select2/select2.min.js"></script>
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
                    <h1 class="h2">Project Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                       <select class="projectlisting"  name="projectlist" style="max-width: 500px;" onchange="location=this.value;">
                            <?php
                            $projectlisting_keys = array_keys($projectlisting);
                            for ($i=0;$i<count($projectlisting);$i++) {
                                $selecteditem = ($projectlisting[$projectlisting_keys[$i]]["id"] == $projectid) ? 'selected="selected"' : '';
                                echo '<option value="project.php?id='.$projectlisting[$projectlisting_keys[$i]]["id"].'" '.$selecteditem.'>'.$projectlisting[$projectlisting_keys[$i]]["title"].'</option>';
                            }
                            ?>
                        </select>
                        <div class="btn-group ml-2">
                            <!--<button type="button" class="btn btn-sm btn-outline-secondary" onclick="javascript:void(0);">Share</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print();return false;">Export to PDF</button>-->
                            <!-- TRIGGER FOR THE HTML TO PDF FUNCTION -->
                            <a class="btn btn-sm btn-outline-secondary" target="_new" href="printproject.php?id=<?php echo $officeid; ?>">Print PDF</a>
                            <!--<button type="button" class="btn btn-sm btn-outline-secondary" onclick="jsp();"> PDF</button>-->
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <div id="toprint" class="toprint">
            <div class="row reportheader projectinfo">
                <div class="col-md-4 logo">
                    <img class="logo" src="assets/images/pimslogo.png">
                </div>
                <div class="col-md-6 title">
                    <h1><?php echo $projectlisting[$projectid]["title"]; ?></h1>
                    <h6>Project Delivery Report</h6>
                </div>
                <div class="col-md-2 health">
                    <p class="reportdate">Jan 2021</p>
                    <p class="healthrating_box" style="background-color:<?php echo $projectlisting[$projectid]["healthcolor"]; ?>;">&nbsp;</p>
                    <p class="healthratingdesc">Project Rating<?php //echo ': '.$projectlisting[$projectid]["healthrating"];?></p>
                </div>
            </div>


            <div class="row reportbody section1">
                <div class="col-md-6 summary">
                    <h5 class="sectiontitle">Summary</h5>
                    <div class="row summarystatistics">
                        <div class="col metric1">
                            <p class="metricvalue">
                                

                                <?php 
                                echo '$'.number_format((array_sum($projectlisting[$projectid]["budgetclass"]["amounts"])/1000000) ,1,'.',',').'M';
                                //echo '$'.number_format( ($projectlisting[$projectid]["fundamount"]/1) , 1, '.', ',').'M'; ?>
                            </p>
                            <p class="metricdesc">Fund<br/>Amount</p>
                        </div>
                        <div class="col metric2">
                            <p class="metricvalue">
                                <?php echo 'N/A';//number_format($projectlisting[$projectid]["prodocamount"], 0, '.', ','); ?>
                            </p>
                            <p class="metricdesc">Prodoc<br/>Amount</p>
                        </div>
                        <div class="col metric3">
                            <p class="metricvalue">
                                <?php echo number_format($projectlisting[$projectid]["outputscount"], 0, '.', ','); ?>
                            </p>
                            <p class="metricdesc">Total<br/>Outputs</p>
                        </div>
                        <div class="col metric4">
                            <p class="metricvalue">
                                <?php echo number_format($projectlisting[$projectid]["activities_completed_count"], 0, '.', ',').' / '.number_format($projectlisting[$projectid]["activitiescount"], 0, '.', ','); ?>
                            </p>
                            <p class="metricdesc">Completed<br/>Activities</p>
                        </div>
                        <div class="col metric5">
                            <p class="metricvalue">
                                <?php echo number_format($projectlisting[$projectid]["duration"], 0, '.', ','); ?><span>Years</span>
                            </p>
                            <p class="metricdesc">Project<br/>Duration</p>
                        </div>
                        <div class="col metric6">
                            <p class="metricvalue">
                                <?php echo $projectlisting[$projectid]["rank"]; ?>
                            </p>
                            <p class="metricdesc">Project<br/>Rank</p>
                        </div>
                    </div>

                    <div class="row portfoliostatistics individualproject">
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
                                    text: '<?php echo number_format($projectlisting[$projectid]["budget_spent"], 0, '.', ','); ?>%',
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
                                        ['Time Taken', <?php echo $projectlisting[$projectid]["budget_spent"]; ?> ],
                                        {
                                            name: '',
                                            y: <?php echo (100 - $projectlisting[$projectid]["budget_spent"]); ?>,
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
                                    text: '<?php echo number_format($projectlisting[$projectid]["time_used"], 0, '.', ','); ?>%',
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
                                        ['Time Taken', <?php echo $projectlisting[$projectid]["time_used"]; ?> ],
                                        {
                                            name: '',
                                            y: <?php echo (100 - $projectlisting[$projectid]["time_used"]); ?>,
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
                                    text: '<?php echo number_format($projectlisting[$projectid]["activities_completed"], 0, '.', ','); ?>%',
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
                                        ['Time Taken', <?php echo $projectlisting[$projectid]["activities_completed"]; ?> ],
                                        {
                                            name: '',
                                            y: <?php echo (100 - $projectlisting[$projectid]["activities_completed"]); ?>,
                                            dataLabels: {
                                                enabled: false
                                            }
                                        }
                                    ]
                                }]
                            });
                        </script>
                    </div>



                    <table class="projectmanager">
                        <tbody>
                            <tr>
                                <td>Project Manager:</td>
                                <td><strong><?php echo $projectlisting[$projectid]["manager"]; ?></strong></td>
                            </tr>
                            <tr>
                                <td>Subprogramme:</td>
                                <td><strong><?php echo $projectlisting[$projectid]["subprogramme"]; ?></strong></td>
                            </tr>
                            <tr>
                                <td>Planned Timeline:</td>
                                <td><strong><?php echo $projectlisting[$projectid]["startdate"]; ?></strong><strong>-</strong><strong><?php echo $projectlisting[$projectid]["enddate"]; ?></strong></td>
                            </tr>
                        </tbody>
                    </table>

                    <p class="summarytext projectmanager"> </p>
                    <p class="summarytext projectmanager"> </p>
                    <p class="summarytext">
                        <?php
                        $summary = $projectlisting[$projectid]["summary"];
                        if (strlen($summary) == 0) {
                            echo 'No summary information.';
                        } else if (strlen($summary) > 0 && strlen($summary) <= 690) {
                            echo $summary;
                        } else {
                            echo substr($summary, 0, 690).'...';
                        }
                        ?>  
                    </p>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="sectiontitle">Project Budget</h5>
                        </div>
                        <div class="col-md-6"><p class="quote text-right noborder">Financial data as at: <strong><?php echo $projectlisting[$projectid]["refresh_date"]; ?></strong></p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm budgetclass">
                            <!--Budget classes table here
                            <hr/>-->
                            <thead>
                                <tr>
                                    <th></th>
                                    <th class="text-left">Budget Class</th>
                                    <th class="text-right">Budget</th>
                                    <th class="text-center">Commitment</th>
                                    <th class="text-center">Actual</th>
                                    <th class="text-center">Total<br/>Consumed</th>
                                    <th class="text-center">Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $budgetbalance = 0;
                                //$budgetclass_keys = array_keys($$projectlisting[$projectid]["budgetclass"]["names"]);

                                for ($i=0;$i<count($projectlisting[$projectid]["budgetclass"]["names"]);$i++) {
                                    echo '<tr>';
                                    echo '<td class="text-right">'.($i+1).'.</td>';
                                    echo '<td>'.$projectlisting[$projectid]["budgetclass"]["names"][$i].'</td>';
                                    echo '<td class="text-right">'. number_format($projectlisting[$projectid]["budgetclass"]["amounts"][$i],0,'.',',').'</td>';
                                    if ($projectlisting[$projectid]["budgetclass"]["obligated"][$i] < 0) {
                                        echo '<td class="text-right red">('. number_format(abs($projectlisting[$projectid]["budgetclass"]["obligated"][$i]),0,'.',',').')</td>';
                                    } else {
                                        echo '<td class="text-right">'. number_format($projectlisting[$projectid]["budgetclass"]["obligated"][$i],0,'.',',').'</td>';
                                    }
                                    echo '<td class="text-right">'. number_format($projectlisting[$projectid]["budgetclass"]["spent"][$i],0,'.',',').'</td>';
                                    echo '<td class="text-right">'. number_format($projectlisting[$projectid]["budgetclass"]["expenditure"][$i],0,'.',',').'</td>';
                                    if ($projectlisting[$projectid]["budgetclass"]["balance"][$i] < 0) {
                                        echo '<td class="text-right red">('. number_format(abs($projectlisting[$projectid]["budgetclass"]["balance"][$i]),0,'.',',').')</td>';
                                    } else {
                                        echo '<td class="text-right">'. number_format($projectlisting[$projectid]["budgetclass"]["balance"][$i],0,'.',',').'</td>';
                                    }
                                    echo '</tr>';
                                    //$budgetbalance += $projectlisting[$projectid]["budgetclass"]["balance"][$i];
                                }
                                /* Totals */
                                echo '<tr class="total">';
                                echo '<td>&nbsp;</td>';
                                echo '<td>Total</td>';
                                echo '<td class="text-right">'.number_format(array_sum($projectlisting[$projectid]["budgetclass"]["amounts"]),0,'.',',').'</td>';
                                if (array_sum($projectlisting[$projectid]["budgetclass"]["obligated"]) < 0) {
                                    echo '<td class="text-right red">('.number_format(abs(array_sum($projectlisting[$projectid]["budgetclass"]["obligated"])),0,'.',',').')</td>';
                                } else {
                                    echo '<td class="text-right">'.number_format(array_sum($projectlisting[$projectid]["budgetclass"]["obligated"]),0,'.',',').'</td>';
                                }echo '<td class="text-right">'.number_format(array_sum($projectlisting[$projectid]["budgetclass"]["spent"]),0,'.',',').'</td>';
                                echo '<td class="text-right">'.number_format(array_sum($projectlisting[$projectid]["budgetclass"]["expenditure"]),0,'.',',').'</td>';
                                if (array_sum($projectlisting[$projectid]["budgetclass"]["balance"]) < 0) {
                                    echo '<td class="text-right red">('.number_format(abs(array_sum($projectlisting[$projectid]["budgetclass"]["balance"])),0,'.',',').')</td>';
                                } else {
                                    echo '<td class="text-right">'.number_format(array_sum($projectlisting[$projectid]["budgetclass"]["balance"]),0,'.',',').'</td>';
                                }
                                
                                /*if ($budgetbalance < 0) {
                                    echo '<td class="text-right red">('.number_format(abs($budgetbalance),0,'.',',').')</td>';
                                } else {
                                    echo '<td class="text-right">'.number_format($budgetbalance,0,'.',',').'</td>';
                                }*/

                                
                                echo '</tr>';
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <table class="budgetclass_footer">
                                <tbody>
                                    <tr>
                                        <td>Coding block:</td>
                                        <td><?php echo $projectlisting[$projectid]["coding_block"];?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-8">
                            <table class="budgetclass_footer">
                                <tbody>
                                    <tr>
                                        <td width="60px">Grant keys:</td>
                                        <td>
                                            <?php 
                                            $grantcodes = '';
                                            foreach(array_unique($projectlisting[$projectid]["budgetclass"]["grants"]) as $value) { 
                                                $grantcodes .= $value.", "; 
                                            }
                                            echo rtrim($grantcodes, ', ');
                                            ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
                <p class="quote hidden">Do the difficult things while they are easy and do the great things while they are small. — LAO TZU</p>
            </div>
            <!--<div class="pagebreak"></div>-->
            <div class="row reportbody section2">
                <h2 class="sectiontitle">Annex 1: Outputs &amp; Activites</h2>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm activitytable">
                        <thead>
                            <tr>
                                <th class="center">Activity #</th>
                                <th class="left" width="400px">Activity Title</th>
                                <th class="center">Start Date</th>
                                <th class="center">End Date</th>
                                <th class="center" width="100px">Elapsed</th>
                                <th class="center">Responsible Staff</th>
                                <th class="center">Responsible Office</th>
                                <th class="center">Responsible Branch</th>
                                <th class="center">Status</th>
                                <th class="center">Activity Tracking</th>
                                <th class="center">Funded</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i=0;$i<count($projectlisting[$projectid]["outputs_activities"]); $i++) {
                                //echo "output ".($i+1)."<br/>";
                                echo '<tr class="output">';
                                echo '<td colspan=11>Output '.$projectlisting[$projectid]["outputs_activities"][$i]["id"].' - '.$projectlisting[$projectid]["outputs_activities"][$i]["title"].' <span>$ '. number_format($projectlisting[$projectid]["outputs_activities"][$i]["fundamount"],0,'.',',').'</span></td>';
                                echo '</tr>';

                                for ($j=0;$j<count($projectlisting[$projectid]["outputs_activities"][$i]["activities"]);$j++) {
                                    echo '<tr class="activity">';
                                    echo '<td class="right">'.$projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["id"].'</td>';
                                    echo '<td class="left">'.$projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["title"].'</td>';
                                    echo '<td class="center">'.$projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["startdate"].'</td>';
                                    echo '<td class="center">'.$projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["enddate"].'</td>';

                                    $elapsed = $projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["elapsed"];
                                    $duration = $projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["duration"];
                                    if ($elapsed != 0 && $duration != 0) {
                                        $elapsedtime = number_format(($elapsed*100/max($duration,1) ),0,'.',',');
                                        if ($elapsedtime >= 0 && $elapsedtime <= 100) {
                                            echo '<td class="center"><div class="progress-bar"><span class="progress-bar-fill green" style="width: '.$elapsedtime.'%;">'.$elapsedtime.'%</span></div></td>';
                                        } else {
                                            echo '<td class="center"><div class="progress-bar"><span class="progress-bar-fill red" style="width: '.min($elapsedtime,100).'%;">'.$elapsedtime.'%</span></div></td>';
                                        }
                                    } else {
                                        $elapsedtime = 'N/A';
                                        echo '<td class="center"><div class="progress-bar"><span class="progress-bar-fill gray" style="width:100%;">'.$elapsedtime.'</span></div></td>';
                                    }
                                    echo '<td class="center">'.$projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["staff"].'</td>';
                                    echo '<td class="center">'.$projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["office"].'</td>';
                                    echo '<td class="center">'.$projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["branch"].'</td>';
                                    if ($projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["status"] == 'In Progress') {
                                        $statuscolor = '#ffc107 !important'; // yellow
                                    } else if ($projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["status"] == 'Completed') {
                                        $statuscolor = '#28a745 !important'; //green
                                    } else {
                                        $statuscolor = '#dc3545 !important'; //red
                                    }
                                    echo '<td class="center" style="font-weight: bold; color:'.$statuscolor.'">'.$projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["status"].'</td>';
                                    if ($projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["trackingtext"] == 'PM To Watch') {
                                        $trackingcolor = '#ffc107 !important'; // yellow
                                    } else if ($projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["trackingtext"] == 'Completed') {
                                        $trackingcolor = '#28a745 !important'; //green
                                    } else {
                                        $trackingcolor = '#dc3545 !important'; //red
                                    }
                                    echo '<td class="center" style="font-weight: bold; color:'.$trackingcolor.'">'.$projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["trackingtext"].'</td>';
                                    $fundtext = ($projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["fundamount"] > 0) ? number_format($projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["fundamount"],0,'.',',') : '- No -';
                                    echo '<td class="right">'.$fundtext.'</td>';
                                    echo '</tr>';
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
        $(document).ready(function() {
            $(".projectlisting").select2({
                placeholder: "Select a project",
                allowClear: false
            });
        });


        /*function jsp(){
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
        }*/
    </script>
</body>
</html>