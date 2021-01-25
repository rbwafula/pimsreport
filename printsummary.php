<?php
$month = Date("M") . ' ' . Date("Y");
$division = ucwords('unep');
if (isset($_GET['office'])) {
    $division = ucwords($_GET['office']);
}
include_once 'totals_algo.php';

$filename = 'pimsreport - '.$division.'.pdf';

$header = '<!DOCTYPE html>
<html>
<head>
	<title>'.$division.' Report</title>
	<!-- Vendor CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    
    <!-- Vendor JS -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
</head>
<body>
	<!--mpdf
	<htmlpagefooter name="myfooter">
		<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">Page {PAGENO} of {nb}</div>
	</htmlpagefooter>
	<sethtmlpagefooter name="myfooter" value="on" />
	mpdf-->
	<div class="container-fluid printlandscape">
		<div id="toprint" class="toprint">';

/*$pageheader = '<div class="row reportheader">
	            <div class="col-md-4 logo">
	                <img class="logo" src="assets/images/pimslogo.png">
	            </div>
	            <div class="col-md-4 title">
	                <h1> '.$processed_divisiondata[$division]["entity"].'</h1>
	                <h6>Programme Delivery Report</h6>
	            </div>
	            <div class="col-md-4 health">
	                <p class="reportdate">Jan 2021</p>
	                <p class="healthrating_box" style="background-color:<?php echo $processed_divisiondata[$division]["healthcolor"]; ?>;">&nbsp;</p>
	                <p class="healthratingdesc">Project Portfolio Rating</p>
	            </div>
	        </div>';*/

$pageheader = '<div class="row reportbody section1">
	        	<img src="assets/images/'.strtolower(str_replace(' ', '_', $division)).'.png" style="">
	        </div>';

$annex1table = '';

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
    $annex1table .= '<tr>';
    $annex1table .= '<td class="right">'.($i + 1).'.</td>';
    $annex1table .= '<td class="left">'.$processed_divisiondata[$division]["divisionlisting_office"][$i]['office'].'</td>';
    $annex1table .= '<td class="right">$ '.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['consumable']/1000000,1,'.',',').' M</td>';
    $annex1table .= '<td class="right">$ '.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['consumed']/1000000,1,'.',',').' M</td>';
    $annex1table .= '<td class="right">$ '.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['balance']/1000000,1,'.',',').' M</td>';
    $annex1table .= '<td class="right">$ '.number_format(($processed_divisiondata[$division]["divisionlisting_office"][$i]['consumable']/$processed_divisiondata[$division]["divisionlisting_office"][$i]['filled_posts'])/1000000,1,'.',',').' M</td>';
    $annex1table .= '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['total_posts'],0,'.',',').'</td>';
    $annex1table .= '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['filled_posts'],0,'.',',').'</td>';
    $annex1table .= '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['vacant_posts'],0,'.',',').'</td>';
    $annex1table .= '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['percentage_vacancy'],0,'.',',').'%</td>';
    $annex1table .= '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['total_projects'],0,'.',',').'</td>';
    $annex1table .= '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['expired_projects'],0,'.',',').'</td>';
    $annex1table .= '<td class="center">'.number_format(($processed_divisiondata[$division]["divisionlisting_office"][$i]['expired_projects']*100/$processed_divisiondata[$division]["divisionlisting_office"][$i]['total_projects']),0,'.',',').'%</td>';
    $annex1table .= '<td class="center">'.number_format(abs($processed_divisiondata[$division]["divisionlisting_office"][$i]['average_months_past_due']),0,'.',',').'</td>';
    $annex1table .= '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['red_projects'],0,'.',',').'</td>';
    $annex1table .= '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['yellow_projects'],0,'.',',').'</td>';
    $annex1table .= '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['green_projects'],0,'.',',').'</td>';
    $annex1table .= '<td class="center"><img src="assets/images/'.gethealthimage($processed_divisiondata[$division]["divisionlisting_office"][$i]['final_rating']).' " style="vertical-align:middle; height:12px;"></td>';
    $annex1table .= '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['reporting_compliance'],0,'.',',').'%</td>';
    $annex1table .= '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['total_outputs'],0,'.',',').'</td>';
    $annex1table .= '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['completed_activities'],0,'.',',').' / '.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['total_activities'],0,'.',',').'</td>';
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

$annex1table .= '<tr style="font-style:italic;background-color: #f6f6f6;" class="">';
$annex1table .= '<td class="right">&nbsp;</td>';
$annex1table .= '<td style="font-weight:bold;" class="left">Office Summary</td>';
$annex1table .= '<td style="font-weight:bold;" class="right">$ '.number_format($office_totalconsumable/1000000,1,'.',',').' M</td>';
$annex1table .= '<td style="font-weight:bold;" class="right">$ '.number_format($office_totalconsumed/1000000,1,'.',',').' M</td>';
$annex1table .= '<td style="font-weight:bold;" class="right">$ '.number_format($office_totalbalance/1000000,1,'.',',').' M</td>';
$annex1table .= '<td style="font-weight:bold;" class="right">$ '.number_format(($office_totalconsumable/$office_totalfilledposts)/1000000,1,'.',',').' M</td>';
$annex1table .= '<td style="font-weight:bold;" class="center">'.number_format($office_totalposts,0,'.',',').'</td>';
$annex1table .= '<td style="font-weight:bold;" class="center">'.number_format($office_totalfilledposts,0,'.',',').'</td>';
$annex1table .= '<td style="font-weight:bold;" class="center">'.number_format($office_totalvacantposts,0,'.',',').'</td>';
$annex1table .= '<td style="font-weight:bold;" class="center">'.number_format(($office_totalvacancy/$office_count),0,'.',',').'%</td>';
$annex1table .= '<td style="font-weight:bold;" class="center">'.number_format($office_totalprojects,0,'.',',').'</td>';
$annex1table .= '<td style="font-weight:bold;" class="center">'.number_format($office_totalexpired,0,'.',',').'</td>';
$annex1table .= '<td style="font-weight:bold;" class="center">'.number_format(($office_totalexpired*100/$office_totalprojects),0,'.',',').'%</td>';
$annex1table .= '<td style="font-weight:bold;" class="center">'.number_format(abs($processed_divisiondata[$division]["avgmonthspastdue_division"]), 0, '.', ',').'</td>';
$annex1table .= '<td style="font-weight:bold;" class="center">'.number_format($office_totalredprojects,0,'.',',').'</td>';
$annex1table .= '<td style="font-weight:bold;" class="center">'.number_format($office_totalyellowprojects,0,'.',',').'</td>';
$annex1table .= '<td style="font-weight:bold;" class="center">'.number_format($office_totalgreenprojects,0,'.',',').'</td>';

$annex1table .= '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['total_health'],0,'.',',').'</td>';



$annex1table .= '<td style="font-weight:bold;" class="center">'.number_format(($office_totalreportingcompliance/$office_count),0,'.',',').'%</td>';
$annex1table .= '<td style="font-weight:bold;" class="center">'.number_format($office_totaloutputs,0,'.',',').'</td>';
$annex1table .= '<td style="font-weight:bold;" class="center">'.number_format($office_completedactivities,0,'.',',').' / '.number_format($office_totalactivities,0,'.',',').'</td>';
$annex1table .= '</tr>';

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
    $annex1table .= '<tr>';
    $annex1table .= '<td class="right">'.($i + $counterlast + 2).'.</td>';
    $annex1table .= '<td class="left">'.$processed_divisiondata[$division]["divisionlisting_region"][$i]['office'].'</td>';
    $annex1table .= '<td class="right">$ '.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['consumable']/1000000,1,'.',',').' M</td>';
    $annex1table .= '<td class="right">$ '.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['consumed']/1000000,1,'.',',').' M</td>';
    $annex1table .= '<td class="right">$ '.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['balance']/1000000,1,'.',',').' M</td>';
    $annex1table .= '<td class="right">$ '.number_format(($processed_divisiondata[$division]["divisionlisting_region"][$i]['consumable']/$processed_divisiondata[$division]["divisionlisting_region"][$i]['filled_posts'])/1000000,1,'.',',').' M</td>';
    $annex1table .= '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['total_posts'],0,'.',',').'</td>';
    $annex1table .= '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['filled_posts'],0,'.',',').'</td>';
    $annex1table .= '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['vacant_posts'],0,'.',',').'</td>';
    $annex1table .= '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['percentage_vacancy'],0,'.',',').'%</td>';
    $annex1table .= '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['total_projects'],0,'.',',').'</td>';
    $annex1table .= '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['expired_projects'],0,'.',',').'</td>';
    $annex1table .= '<td class="center">'.number_format(($processed_divisiondata[$division]["divisionlisting_region"][$i]['expired_projects']*100/$processed_divisiondata[$division]["divisionlisting_region"][$i]['total_projects']),0,'.',',').'%</td>';
    $annex1table .= '<td class="center">'.number_format(abs($processed_divisiondata[$division]["divisionlisting_region"][$i]['average_months_past_due']),0,'.',',').'</td>';
    $annex1table .= '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['red_projects'],0,'.',',').'</td>';
    $annex1table .= '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['yellow_projects'],0,'.',',').'</td>';
    $annex1table .= '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['green_projects'],0,'.',',').'</td>';
    $annex1table .= '<td class="center"><img src="assets/images/'.gethealthimage($processed_divisiondata[$division]["divisionlisting_region"][$i]['final_rating']).' " style="vertical-align:middle; height:12px;"></td>';
    $annex1table .= '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['reporting_compliance'],0,'.',',').'%</td>';
    $annex1table .= '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['total_outputs'],0,'.',',').'</td>';
    $annex1table .= '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['completed_activities'],0,'.',',').' / '.number_format($processed_divisiondata[$division]["divisionlisting_region"][$i]['total_activities'],0,'.',',').'</td>';
    $annex1table .= '</tr>';

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

$annex1table .= '<tr style="font-style:italic; font-weight:500;" class="summary">';
$annex1table .= '<td class="right">&nbsp;</td>';
$annex1table .= '<td class="left">Regional Summary</td>';
$annex1table .= '<td class="right">$ '.number_format($region_totalconsumable/1000000,1,'.',',').' M</td>';
$annex1table .= '<td class="right">$ '.number_format($region_totalconsumed/1000000,1,'.',',').' M</td>';
$annex1table .= '<td class="right">$ '.number_format($region_totalbalance/1000000,1,'.',',').' M</td>';
$annex1table .= '<td class="right">$ '.number_format(($region_totalconsumable/$region_totalfilledposts)/1000000,1,'.',',').' M</td>';
$annex1table .= '<td class="center">'.number_format($region_totalposts,0,'.',',').'</td>';
$annex1table .= '<td class="center">'.number_format($region_totalfilledposts,0,'.',',').'</td>';
$annex1table .= '<td class="center">'.number_format($region_totalvacantposts,0,'.',',').'</td>';
$annex1table .= '<td class="center">'.number_format(($region_totalvacancy/$region_count),0,'.',',').'%</td>';
$annex1table .= '<td class="center">'.number_format($region_totalprojects,0,'.',',').'</td>';
$annex1table .= '<td class="center">'.number_format($region_totalexpired,0,'.',',').'</td>';
$annex1table .= '<td class="center">'.number_format(($region_totalexpired*100/$region_totalprojects),0,'.',',').'%</td>';
$annex1table .= '<td class="center">'.number_format(abs($processed_divisiondata[$division]["avgmonthspastdue_region"]), 0, '.', ',').'</td>';
$annex1table .= '<td class="center">'.number_format($region_totalredprojects,0,'.',',').'</td>';
$annex1table .= '<td class="center">'.number_format($region_totalyellowprojects,0,'.',',').'</td>';
$annex1table .= '<td class="center">'.number_format($region_totalgreenprojects,0,'.',',').'</td>';


$annex1table .= '<td class="center">'.number_format($processed_divisiondata[$division]["divisionlisting_office"][$i]['final_rating'],0,'.',',').'</td>';

$annex1table .= '<td class="center">'.number_format(($region_totalreportingcompliance/$region_count),0,'.',',').'%</td>';
$annex1table .= '<td class="center">'.number_format($region_totaloutputs,0,'.',',').'</td>';
$annex1table .= '<td class="center">'.number_format($region_completedactivities,0,'.',',').' / '.number_format($region_totalactivities,0,'.',',').'</td>';
$annex1table .= '</tr>';

$annex1table .= '<tr style="font-style:italic; font-weight:500;" class="summarytotal">';
$annex1table .= '<td style="border:0px solid red;" class="right">&nbsp;</td>';
$annex1table .= '<td style="font-weight:500;" class="left">Total UNEP Summary</td>';
$annex1table .= '<td class="right">$ '.number_format(($office_totalconsumable+$region_totalconsumable)/1000000,1,'.',',').' M</td>';
$annex1table .= '<td class="right">$ '.number_format(($office_totalconsumed+$region_totalconsumed)/1000000,1,'.',',').' M</td>';
$annex1table .= '<td class="right">$ '.number_format(($office_totalbalance+$region_totalbalance)/1000000,1,'.',',').' M</td>';
$annex1table .= '<td class="right">$ '.number_format((($office_totalconsumable+$region_totalconsumable) / ($office_totalfilledposts+$region_totalfilledposts))/1000000,1,'.',',').' M</td>';
$annex1table .= '<td class="center">'.number_format(($office_totalposts+$region_totalposts),0,'.',',').'</td>';
$annex1table .= '<td class="center">'.number_format(($office_totalfilledposts+$region_totalfilledposts),0,'.',',').'</td>';
$annex1table .= '<td class="center">'.number_format(($office_totalvacantposts+$region_totalvacantposts),0,'.',',').'</td>';
$annex1table .= '<td class="center">'.number_format(( (($office_totalvacancy/$office_count) + ($region_totalvacancy/$region_count)) / 2),0,'.',',').'%</td>';
$annex1table .= '<td class="center">'.number_format(($office_totalprojects+$region_totalprojects),0,'.',',').'</td>';
$annex1table .= '<td class="center">'.number_format(($office_totalexpired+$region_totalexpired),0,'.',',').'</td>';
$annex1table .= '<td class="center">'.number_format((($office_totalexpired+$region_totalexpired)*100/($office_totalprojects+$region_totalprojects)),0,'.',',').'%</td>';
$annex1table .= '<td class="center">'.number_format(abs($processed_divisiondata[$division]["avgmonthspastdue"]), 0, '.', ',').'</td>';
$annex1table .= '<td class="center">'.number_format(($office_totalredprojects+$region_totalredprojects),0,'.',',').'</td>';
$annex1table .= '<td class="center">'.number_format(($office_totalyellowprojects+$region_totalyellowprojects),0,'.',',').'</td>';
$annex1table .= '<td class="center">'.number_format(($office_totalgreenprojects+$region_totalgreenprojects),0,'.',',').'</td>';

$annex1table .= '<td class="center">'.number_format($processed_divisiondata[$division]["healthrating"],0,'.',',').'</td>';


$annex1table .= '<td class="center">'.number_format(((($office_totalreportingcompliance/$office_count)+($region_totalreportingcompliance/$region_count))/2),0,'.',',').'%</td>';
$annex1table .= '<td class="center">'.number_format(($office_totaloutputs+$region_totaloutputs),0,'.',',').'</td>';
$annex1table .= '<td class="center">'.number_format(($office_completedactivities+$region_completedactivities),0,'.',',').' / '.number_format(($office_totalactivities+$region_totalactivities),0,'.',',').'</td>';
$annex1table .= '</tr>';

$annex1 = '<div class="row reportbody section2">
                <h2 class="sectiontitle">Annex 1: Projects Table</h2>
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
                                <th class="center">Filled<br/>Posts</th>
                                <th class="center">Vacant<br/>Posts</th>
                                <th class="center">%<br/>Vacancy</th>
                                <th class="center">Total<br/>Projects</th>
                                <th class="center">Expired<br/>Projects</th>
                                <th class="center">% of Expired<br/>Projects</th>
                                <th class="center">Avg.<br/>Months<br/>Past Due</th>
                                <th class="center">Red<br/>Projects</th>
                                <th class="center">Yellow<br/>Projects</th>
                                <th class="center">Green<br/>Projects</th>
                                <th class="center">Final<br/>Rating</th>
                                <th class="center">Reporting<br/>Compliance</th>
                                <th class="center">Total<br/>Outputs</th>
                                <th class="center">Completed<br/>Activities</th>
                            </tr>
                        </thead>
                        <tbody>'.$annex1table.'
                        </tbody>
                    </table>
                </div>
            </div>';

$footer = '</div><!-- End of .toprint -->
    </div><!-- End of .container-fluid -->
</body>
</html>';

/* Print to mPDF */
require_once __DIR__ . '/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf([
	'mode' => 'utf-8',
	'orientation' => 'L',
	'tempDir' => __DIR__ . '/files',
	'margin_left' => 10,
	'margin_right' => 10,
	'margin_top' => 20,
	'margin_bottom' => 20,
	'margin_header' => 10,
	'margin_footer' => 10
]);

$mpdf->SetProtection(array('print'));
$mpdf->SetTitle("pimsreport");
$mpdf->SetAuthor("UNEP - PIMS+");
$mpdf->SetDisplayMode('fullpage');
$mpdf->Bookmark('Summary');
$mpdf->WriteHTML($pageheader);
$mpdf->AddPage();
$mpdf->WriteHTML($header);
$mpdf->Bookmark('Annex 1: Projects Table');
$mpdf->WriteHTML($annex1);
/*$mpdf->AddPage();
$mpdf->Bookmark('Annex 2: Vacant Positions');
$mpdf->WriteHTML($annex2);
$mpdf->AddPage();
$mpdf->Bookmark('Annex 3: Filled Positions');
$mpdf->WriteHTML($annex3);*/
$mpdf->WriteHTML($footer);
//$mpdf->Output();
$mpdf->Output($filename, 'I');
exit;
?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo strtoupper($division); ?> Report</title>
	<!-- Vendor CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <!--<link rel="stylesheet" href="assets/css/highcharts.css">-->

    <!-- Vendor JS -->
    <!--<script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/solid-gauge.js"></script>-->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
    <!--<script src="assets/js/main.js"></script>-->

    <!-- HTML TO PDF LIB LOADED -->
    <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
</head>
<body>
	<div class="container-fluid printlandscape">
		<div id="toprint" class="toprint">
			<div class="row reportheader">
                <div class="col-md-4 logo">
                    <img class="logo" src="assets/images/pimslogo.png">
                </div>
                <div class="col-md-4 title">
                    <h1><?php echo $processed_divisiondata[$division]["entity"]; ?></h1>
                    <h6>Programme Delivery Report</h6>
                </div>
                <div class="col-md-4 health">
                    <p class="reportdate">Jan 2021</p>
                    <p class="healthrating_box" style="background-color:<?php echo $processed_divisiondata[$division]["healthcolor"]; ?>;">&nbsp;</p>
                    <p class="healthratingdesc">Project Portfolio Rating</p>
                </div>
            </div>

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
                <h2 class="sectiontitle">Annex 3: Filled Positions Table</h2>
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
		</div>
	</div>
</body>
</html>