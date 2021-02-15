<?php
$month = Date("M") . ' ' . Date("Y");
include_once 'proj_algo.php';
$projectid = (isset($_GET['id'])) ? strtoupper($_GET['id']) : strtoupper(key($projectlisting));
$filename = 'pimsreport - '.$projectid.'.pdf';
$header = '<!DOCTYPE html>
<html>
<head>
    <title>'.$projectlisting[$projectid]["id"].' | PIMS+ Report</title>
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
	        	<img src="assets/images/'.strtolower(str_replace(' ', '_', $projectid)).'.png" style="">
	        </div>';

$annex1table = '';
for ($i=0;$i<count($projectlisting[$projectid]["outputs_activities"]); $i++) {
    $annex1table .= '<tr class="output">';
    $annex1table .= '<td colspan=11>Output '.$projectlisting[$projectid]["outputs_activities"][$i]["id"].' - '.$projectlisting[$projectid]["outputs_activities"][$i]["title"].' - <span style="font-weight:bold;">$'. number_format($projectlisting[$projectid]["outputs_activities"][$i]["fundamount"],0,'.',',').'</span></td>';
    $annex1table .= '</tr>';

    for ($j=0;$j<count($projectlisting[$projectid]["outputs_activities"][$i]["activities"]);$j++) {
        $annex1table .= '<tr class="activity">';
        $annex1table .= '<td class="right">'.$projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["id"].'</td>';
        $annex1table .= '<td class="left">'.$projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["title"].'</td>';
        $annex1table .= '<td class="center">'.$projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["startdate"].'</td>';
        $annex1table .= '<td class="center">'.$projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["enddate"].'</td>';

        $elapsed = $projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["elapsed"];
        $duration = $projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["duration"];
        if ($elapsed != 0 && $duration != 0) {
            $elapsedtime = number_format(($elapsed*100/max($duration,1) ),0,'.',',');
            if ($elapsedtime >= 0 && $elapsedtime <= 100) {
                $annex1table .= '<td class="center"><div class="progress-bar"><span class="progress-bar-fill green" style="width: '.$elapsedtime.'%;">'.$elapsedtime.'%</span></div></td>';
            } else {
                $annex1table .= '<td class="center"><div class="progress-bar"><span class="progress-bar-fill red" style="width: '.min($elapsedtime,100).'%;">'.$elapsedtime.'%</span></div></td>';
            }
        } else {
            $elapsedtime = 'N/A';
            $annex1table .= '<td class="center"><div class="progress-bar"><span class="progress-bar-fill gray" style="width:100%;">'.$elapsedtime.'</span></div></td>';
        }
        $annex1table .= '<td class="center">'.$projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["staff"].'</td>';
        $annex1table .= '<td class="center">'.$projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["office"].'</td>';
        $annex1table .= '<td class="center">'.$projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["branch"].'</td>';
        if ($projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["status"] == 'In Progress') {
            $statuscolor = '#ffc107 !important'; // yellow
        } else if ($projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["status"] == 'Completed') {
            $statuscolor = '#28a745 !important'; //green
        } else {
            $statuscolor = '#dc3545 !important'; //red
        }
        $annex1table .= '<td class="center" style="font-weight: bold; color:'.$statuscolor.'">'.$projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["status"].'</td>';
        if ($projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["trackingtext"] == 'PM To Watch') {
            $trackingcolor = '#ffc107 !important'; // yellow
        } else if ($projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["trackingtext"] == 'Completed') {
            $trackingcolor = '#28a745 !important'; //green
        } else {
            $trackingcolor = '#dc3545 !important'; //red
        }
        $annex1table .= '<td class="center" style="font-weight: bold; color:'.$trackingcolor.'">'.$projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["trackingtext"].'</td>';
        $fundtext = ($projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["fundamount"] > 0) ? number_format($projectlisting[$projectid]["outputs_activities"][$i]["activities"][$j]["fundamount"],0,'.',',') : '- No -';
        $annex1table .= '<td class="right">'.$fundtext.'</td>';
        $annex1table .= '</tr>';
    }
}

$annex1 = '<div class="row reportbody section2">
                <h2 class="sectiontitle">Annex 1: Outputs &amp; Activites</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm activitytable">
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
                        <tbody>'.$annex1table.'
                        </tbody>
                    </table>
                </div>
            </div>';


$annex2table = '';

for ($i=0; $i < count($projectlisting[$projectid]["budgetclass"]["grants"]); $i++) {
    $annex2table .= '<tr>';
    $annex2table .= '<td class="center">'.$projectlisting[$projectid]["budgetclass"]["grants_fund"][$i].'</td>';
    $annex2table .= '<td class="center">'.$projectlisting[$projectid]["budgetclass"]["grants"][$i].'</td>';
    $annex2table .= '<td class="center">'.$projectlisting[$projectid]["budgetclass"]["grants_from"][$i].'</td>';
    $annex2table .= '<td class="center">'.$projectlisting[$projectid]["budgetclass"]["grants_to"][$i].'</td>';
    $annex2table .= '<td class="center">'.$projectlisting[$projectid]["budgetclass"]["grants_expired"][$i].'</td>';
    $annex2table .= '<td class="right" style="border-right:1px solid #333">'.number_format($projectlisting[$projectid]["budgetclass"]["grants_amount"][$i], 0, '.', ',').'</td>';
    $annex2table .= '<td class="right">'.number_format($projectlisting[$projectid]["budgetclass"]["grants_consumable_budget"][$i], 0, '.', ',').'</td>';
    $annex2table .= '<td class="right">'.number_format($projectlisting[$projectid]["budgetclass"]["grants_precommitment"][$i], 0, '.', ',').'</td>';
    $annex2table .= '<td class="right">'.number_format($projectlisting[$projectid]["budgetclass"]["grants_commitment"][$i], 0, '.', ',').'</td>';
    $annex2table .= '<td class="right">'.number_format($projectlisting[$projectid]["budgetclass"]["grants_actual"][$i], 0, '.', ',').'</td>';
    
    $annex2table .= '<td class="right">'.number_format($projectlisting[$projectid]["budgetclass"]["grants_consumed_budget"][$i], 0, '.', ',').'</td>';
    //echo '<td>'..'</td>';
    $annex2table .= '</tr>';
}
$annex2table .= '<tr class="total">';
$annex2table .= '<td></td>';
$annex2table .= '<td class="center">Total</td>';
$annex2table .= '<td></td>';
$annex2table .= '<td></td>';
$annex2table .= '<td></td>';
$annex2table .= '<td class="right" style="border-right:1px solid #333">'.number_format(array_sum($projectlisting[$projectid]["budgetclass"]["grants_amount"]), 0, '.', ',').'</td>';
$annex2table .= '<td class="right">'.number_format(array_sum($projectlisting[$projectid]["budgetclass"]["grants_consumable_budget"]), 0, '.', ',').'</td>';
$annex2table .= '<td class="right">'.number_format(array_sum($projectlisting[$projectid]["budgetclass"]["grants_precommitment"]), 0, '.', ',').'</td>';
$annex2table .= '<td class="right">'.number_format(array_sum($projectlisting[$projectid]["budgetclass"]["grants_commitment"]), 0, '.', ',').'</td>';
$annex2table .= '<td class="right">'.number_format(array_sum($projectlisting[$projectid]["budgetclass"]["grants_actual"]), 0, '.', ',').'</td>';
$annex2table .= '<td class="right">'.number_format(array_sum($projectlisting[$projectid]["budgetclass"]["grants_consumed_budget"]), 0, '.', ',').'</td>';
$annex2table .= '</tr>';

$annex2 = '<div class="row reportbody section2">
                <h2 class="sectiontitle">Annex 1: Outputs &amp; Activites</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm activitytable">
                        <thead>
                            <tr>
                                <th class="center">Fund</th>
                                <th class="center" width="300px">Grant / Donor</th>
                                <th class="center">From</th>
                                <th class="center">To</th>
                                <th class="center">Expired</th>
                                <th class="right">Grant Amount</th>
                                <th class="right">Consumable Budget</th>
                                <th class="right">Precommitment</th>
                                <th class="right">Commitment</th>
                                <th class="right">Actual</th>
                                <th class="right">Consumed Budget</th>
                            </tr>
                        </thead>
                        <tbody>'.$annex2table.'
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
$mpdf->WriteHTML($pageheader);
$mpdf->AddPage();
$mpdf->WriteHTML($header);
$mpdf->WriteHTML($annex1);
$mpdf->AddPage();
$mpdf->WriteHTML($annex2);
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