<?php
$month = Date("M") . ' ' . Date("Y");
$office = array('Europe', 'Economy', 'Disasters and Conflicts', 'Latin America', 'Asia Pacific', 'Law', 'Communication', 'Ecosystems', 'Science', 'Africa', 'West Asia');
$division = $office[1];
if (isset($_GET['office'])) {
    $division = $office[$_GET['office']];
}
include_once 'dynamic_algo.php';

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

$pageheader = '<div class="row reportbody section1" style="width:100%;">
	        	<img src="assets/images/'.strtolower(str_replace(' ', '_', $division)).'.png" alt="Dashboard 1 Missing" style="width:100%;">
	        </div>';
$pageheader .= '<div class="row reportbody section1" style="width:100%;">
                <img src="assets/images/'.strtolower(str_replace(' ', '_', $division)).'2.png" alt="Dashboard 2 Missing" style="width:100%;">
            </div>';

$annex1table = '';
for ($i = 0; $i < count($processed_divisiondata[$division]["projectlisting"]); $i++) {
    $annex1table .= '<tr>';
    $annex1table .= '<td class="right">' . ($i + 1) . '.</td>';
    $annex1table .= '<td class="left">' . $processed_divisiondata[$division]["projectlisting"][$i]['branch'] . '</td>';
    $annex1table .= '<td class="left">' . $processed_divisiondata[$division]["projectlisting"][$i]['project_id'] . '</td>';
    $annex1table .= '<td class="left">' . $processed_divisiondata[$division]["projectlisting"][$i]['project_title'] . '</td>';
    $annex1table .= '<td class="center">SP ' . $processed_divisiondata[$division]["projectlisting"][$i]['sp_number'] . '</td>';

    if ($processed_divisiondata[$division]["projectlisting"][$i]['months_remaining'] < 0) {
        $annex1table .= '<td class="center" style="color:#dc3545; font-weight: 500;">' . abs($processed_divisiondata[$division]["projectlisting"][$i]['months_remaining']) . '</td>';
    } else if ($processed_divisiondata[$division]["projectlisting"][$i]['months_remaining'] == 'No Enddate') {
        $annex1table .= '<td class="center" style="color:#dc3545; font-weight: 500;">No end date</td>';
    } else {
        $annex1table .= '<td class="center" style="font-weight:500; color:green">&nbsp;</td>';
    }
    $annex1table .= '<td class="left">' . $processed_divisiondata[$division]["projectlisting"][$i]['project_manager'] . '</td>';
    $annex1table .= '<td class="right">' . number_format($processed_divisiondata[$division]["projectlisting"][$i]['budget'], 0, '.', ',') . '</td>';
    $annex1table .= '<td class="center"><img src="assets/images/'.gethealthimage($processed_divisiondata[$division]["projectlisting"][$i]['system_rating']).' " style="vertical-align:middle; height:12px;"></td>';
    $annex1table .= '<td class="center"><img src="assets/images/'.gethealthimage($processed_divisiondata[$division]["projectlisting"][$i]['management_rating']).' " style="vertical-align:middle; height:12px;"></td>';
    $annex1table .= '<td class="center"><img src="assets/images/'.gethealthimage($processed_divisiondata[$division]["projectlisting"][$i]['final_rating']).' " style="vertical-align:middle; height:12px;"></td>';
    $annex1table .= '<td class="center">' . $processed_divisiondata[$division]["projectlisting"][$i]['project_rank'] . '</td>';
    $annex1table .= '<td class="center">' . $processed_divisiondata[$division]["projectlisting"][$i]['outputs'] . '</td>';
    if ($processed_divisiondata[$division]["projectlisting"][$i]['completed_activities'] != '' && $processed_divisiondata[$division]["projectlisting"][$i]['total_activities'] != '') {
        $annex1table .= '<td class="center">' . $processed_divisiondata[$division]["projectlisting"][$i]['completed_activities'] . ' / ' . $processed_divisiondata[$division]["projectlisting"][$i]['total_activities'] . ' </td>';
    } else {
        $annex1table .= '<td class="center"> - </td>';
    }
    $annex1table .= '</tr>';
}



$annex1 = '<div class="row reportbody section2">
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
                        <tbody>'.$annex1table.'
                        </tbody>
                    </table>
                </div>
            </div>';

$annex2table = '';
$j = 0;
for ($i = 0; $i < count($processed_divisiondata[$division]["stafflisting"]); $i++) {
    if ($processed_divisiondata[$division]["stafflisting"][$i]['position_status'] == 'VACANT') {
        $annex2table .= '<tr>';
        $annex2table .= '<td>' . ($j + 1) . '.</td>';
        $annex2table .= '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['grade'] . '</td>';
        $annex2table .= '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['position_title'] . '</td>';
        $annex2table .= '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['position_number'] . '</td>';
        $annex2table .= '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['duty_station'] . '</td>';
        $annex2table .= '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['category'] . '</td>';
        $annex2table .= '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['org_code'] . '</td>';
        $annex2table .= '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['org_unit_description'] . '</td>';
        $annex2table .= '</tr>';
        $j++;
    }
}

$annex2 = '<div class="row reportbody section3">
                <h2 class="sectiontitle">Annex 2: Vacant Positions Table</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th class="left">Grade</th>
                                <th class="left">Position Title</th>
                                <th class="left">Position Number</th>
                                <th class="left">Duty Station</th>
                                <th class="left">Fund</th>
                                <th class="left">Org Code</th>
                                <th class="left">Org Unit</th>
                            </tr>
                        </thead>
                        <tbody>'.$annex2table.'
                        </tbody>
                    </table>
                </div>
            </div>';

$annex3table = '';
$j = 0;
foreach ($processed_divisiondata[$division]["stafflisting"] as $key => $value) {
    if ($value["position_status"] == "FILLED") {
        $annex3table .= '<tr>';
        $annex3table .= '<td class="text-right">'.($j+1).'.</td>';
        $annex3table .= '<td class="text-center">'.$value["grade"].'</td>';
        $annex3table .= '<td class="text-left">'.$value["position_title"].'</td>';
        $annex3table .= '<td class="text-center">'.$value["position_number"].'</td>';
        $annex3table .= '<td class="text-left">'.$value["duty_station"].'</td>';
        $annex3table .= '<td class="text-left">'.$value["staff_name"].'</td>';
        $annex3table .= '<td class="text-center">'.$value["category"].'</td>';
        $annex3table .= '<td class="text-center">'.$value["contract_type"].'</td>';
        if ($value["stage"] != "" && $value["stage"] != null) {
            $annex3table .= '<td class="text-center">'.$value["stage"].'</td>';
        } else {
            $annex3table .= '<td class="text-center">-N/A-</td>';
        }
        if ($value["mandatory_training"] != "" && $value["mandatory_training"] != null) {
            $annex3table .= '<td class="text-center">'.$value["mandatory_training"].' / 9</td>';
        } else {
            $annex3table .= '<td class="text-center">0 / 9</td>'; 
        }
        if ($value["contract_expiry"] <= date("Y-m-d", strtotime("+6 month")) ) {
            $annex3table .= '<td class="text-center text-red">'.$value["contract_expiry"].'</td>';
        } else {
            $annex3table .= '<td class="text-center">'.$value["contract_expiry"].'</td>';
        }
        if ($value["retirement_date"] <= date("Y-m-d", strtotime("+24 month")) ) {
            $annex3table .= '<td class="text-center text-red">'.$value["retirement_date"].'</td>';
        } else {
            $annex3table .= '<td class="text-center">'.$value["retirement_date"].'</td>';
        }
        $annex3table .= '</tr>';
        $j++;
    }
}

$annex3 = '<div class="row reportbody section3">
                <h2 class="sectiontitle">Annex 3: Encumbered Positions Table</h2>
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
                        <tbody>'.$annex3table.'
                        </tbody>
                    </table>
                </div>
            </div>';

$annex4table = '';
$j = 0;
foreach ($processed_divisiondata[$division]["consultants_data"] as $key => $value) {
    if ($value["expired"] == "NO") {
        $annex4table .= '<tr>';
        $annex4table .= '<td class="text-right">'.($j + 1).'.</td>';
        $annex4table .= '<td class="text-left">'.$value["names"].'</td>';
        $annex4table .= '<td class="text-center">'.$value["startdate"].'</td>';
        $annex4table .= '<td class="text-center">'.$value["enddate"].'</td>';
        //$annex4table .= '<td class="text-center">'.checknotdefined($value["contract_type"]).'</td>';
        $annex4table .= '<td class="text-right">'.number_format($value["duration"],0,".",",").' days</td>';
        $annex4table .= '<td class="text-center">'.$value["morethan11months"].'</td>';
        $j++;
    }
}

$annex4 = '<div class="row reportbody section3">
                <h2 class="sectiontitle">Annex 4: Consultants</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
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
                        <tbody>'.$annex4table.'
                        </tbody>
                    </table>
                </div>
            </div>';

$annex5table = '';
array_multisort(array_column($processed_divisiondata[$division]["grantsdata"], 'grantenddate'), SORT_ASC,$processed_divisiondata[$division]["grantsdata"]);
$j = 0;
$expired_totalamount = 0;
$negative_totalamount = 0;
$sixmonthexpiry_totalamount = 0;
$expired_count = 0;
$negative_count = 0;
$sixmonthexpiry_count = 0;


foreach ($processed_divisiondata[$division]["grantsdata"] as $key => $value) {
    if (number_format($value["grantamount"],0,".",",") != "0") {
        $annex5table .= '<tr>';
        $annex5table .= '<td class="text-right">'.($j + 1).'.</td>';
        $annex5table .= '<td>'.$value["grantkey"].'</td>';
        if ($value["grantamount"] < 0) {
            $annex5table .= '<td class="text-right text-red">'.number_format($value["grantamount"],0,".",",").'</td>';
        } else {
            $annex5table .= '<td class="text-right">'.number_format($value["grantamount"],0,".",",").'</td>';
        }
        $annex5table .= '<td class="text-center">'.$value["grantstartdate"].'</td>';
        $annex5table .= '<td class="text-center">'.$value["grantenddate"].'</td>';

        $elapsed = floor(getdaysbetween($value["grantstartdate"],min(date("Y-m-d",time()),$value["grantenddate"])));
        $duration = ceil(getdaysbetween($value["grantstartdate"],$value["grantenddate"]));
        if ($elapsed != 0 && $duration != 0) {
            $elapsedtime = number_format(($elapsed*100/max($duration,1) ),0,'.',',');
            if ($elapsedtime >= 0 && $elapsedtime < 100) {
                $annex5table .= '<td class="text-center"><div class="progress-bar"><span class="progress-bar-fill green" style="width: '.$elapsedtime.'%;">'.$elapsedtime.'%</span></div></td>';
            } else if ($elapsedtime >= 100) {
                $annex5table .= '<td class="text-center"><div class="progress-bar"><span class="progress-bar-fill red" style="width: 100%;">'.$elapsedtime.'%</span></div></td>';
            } else {
                $elapsedtime = 'N/A';
                $annex5table .= '<td class="text-center"><div class="progress-bar"><span class="progress-bar-fill gray" style="width:100%;">'.$elapsedtime.'</span></div></td>';
            }
        } else {
            $elapsedtime = 'N/A';
            $annex5table .= '<td class="text-center"><div class="progress-bar"><span class="progress-bar-fill gray" style="width:100%;">'.$elapsedtime.'</span></div></td>';
        }

        $annex5table .= '<td class="text-center">'.$value["grantexpired"].'</td>';
        $annex5table .= '<td class="text-center">'.$value["grantaging"].'</td>';
        $j++;

        /*if ($value["grantexpired"] == "YES") {
            $expired_totalamount += $value["grantamount"];
            $expired_count++;
        }
        if ($value["grantamount"] < 0) {
            $negative_totalamount += $value["grantamount"];
            $negative_count++;
        }
        if ($value["grantenddate"] > date("Y-m-d", strtotime("now")) && $value["grantenddate"] <= date("Y-m-d", strtotime("+6 month"))) {
            $sixmonthexpiry_totalamount = $value["grantamount"];
            $sixmonthexpiry_count++;
        }*/
    }
}

$annex5 = '<div class="row reportbody section3">
                <h2 class="sectiontitle">Annex 5: Umoja Grants Data</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th class="text-left" style="width: 30%;">Keys</th>
                                <th class="text-right">Amounts</th>
                                <th class="text-center">Start Date</th>
                                <th class="text-center">End Date</th>
                                <th class="text-center">Elapsed</th>
                                <th class="text-center">Expiration</th>
                                <th class="text-center">Months Remaining</th>
                            </tr>
                        </thead>
                        <tbody>'.$annex5table.'
                        </tbody>
                    </table>
                </div>
            </div>';

$annex6table = '';
array_multisort(array_column($processed_divisiondata[$division]["risks_data"], 'year'), SORT_ASC,$processed_divisiondata[$division]["risks_data"]);
$j = 0;
foreach ($processed_divisiondata[$division]["risks_data"] as $key => $value) {
    if ($value["year"] == date("Y", strtotime("now"))) {
        $annex6table .= '<tr>';
        $annex6table .= '<td class="text-right">'.($j + 1).'.</td>';
        $annex6table .= '<td class="text-left">'.$value["riskname"].'</td>';
        $annex6table .= '<td class="text-center">'.$value["projectcount"].'</td>';
        $annex6table .= '<td class="text-center">'.$value["year"].'</td>';
        $annex6table .= '</tr>';
        $j++;
    }
}

if (empty($processed_divisiondata[$division]["risks_data"])) {
    $annex6 = '<div class="row reportbody section3">
                <h2 class="sectiontitle">Annex 6: Project Risks</h2>
                <div class="table-responsive">
                    <p><b>Nothing to report</b></p>
                </div>
            </div>';

    echo "<p><b>Nothing to report</b></p>";
} else {
    $annex6 = '<div class="row reportbody section3">
                <h2 class="sectiontitle">Annex 6: Project Risks</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th class="text-left">Risk Name</th>
                                <th class="text-center">Number of Projects</th>
                                <th class="text-center">Year</th>
                            </tr>
                        </thead>
                        <tbody>'.$annex6table.'
                        </tbody>
                    </table>
                </div>
            </div>';
}




$annex7table = '';
array_multisort(array_column($processed_divisiondata[$division]["boa_data"], 'year'), SORT_ASC,$processed_divisiondata[$division]["boa_data"]);
$j = 0;
foreach ($processed_divisiondata[$division]["boa_data"] as $key => $value) {
    if ($value["year"] == $value["year"]/* date("Y", strtotime("now")) */) {
        $annex7table .= '<tr>';
        $annex7table .= '<td class="text-right">'.($j + 1).'.</td>';
        $annex7table .= '<td class="text-left" style="max-width: 300px;">'.$value["summaryrecommendation"].'</td>';
        $annex7table .= '<td class="text-left" style="max-width: 70px;">'.$value["reportreference"].'</td>';
        $annex7table .= '<td class="text-center">'.$value["priority"].'</td>';
        $annex7table .= '<td class="text-center">'.$value["year"].'</td>';
        $annex7table .= '<td class="text-center">'.$value["targetdate"].'</td>';


        $elapsed = floor(getdaysbetween($value["year"]."/01/01",min(date("Y-m-d",time()),$value["targetdate"])));
        $duration = ceil(getdaysbetween($value["year"]."/01/01",$value["targetdate"]));
        if ($elapsed != 0 && $duration != 0) {
            $elapsedtime = number_format(($elapsed*100/max($duration,1) ),0,'.',',');
            if ($elapsedtime >= 0 && $elapsedtime < 100) {
                $annex7table .= '<td class="center"><div class="progress-bar"><span class="progress-bar-fill green" style="width: '.$elapsedtime.'%;">'.$elapsedtime.'%</span></div></td>';
            } else if ($elapsedtime >= 100) {
                $annex7table .= '<td class="center"><div class="progress-bar"><span class="progress-bar-fill red" style="width: 100%;">'.$elapsedtime.'%</span></div></td>';
            } else {
                $elapsedtime = 'N/A';
                $annex7table .= '<td class="center"><div class="progress-bar"><span class="progress-bar-fill gray" style="width:100%;">'.$elapsedtime.'</span></div></td>';
            }
        } else {
            $elapsedtime = 'N/A';
            $annex7table .= '<td class="center"><div class="progress-bar"><span class="progress-bar-fill gray" style="width:100%;">'.$elapsedtime.'</span></div></td>';
        }
        $annex7table .= '<td class="text-center">'.$value["category"].'</td>';
        $annex7table .= '</tr>';
        $j++;
    }
}


if (empty($processed_divisiondata[$division]["boa_data"])) {
    $annex7 = '<div class="row reportbody section3">
                <h2 class="sectiontitle">Annex 7: Board of Auditors</h2>
                <div class="table-responsive">
                    <p><b>Nothing to report</b></p>
                </div>
            </div>';

    echo "<p><b>Nothing to report</b></p>";
} else {
    $annex7 = '<div class="row reportbody section3">
                    <h2 class="sectiontitle">Annex 7: Board of Auditors</h2>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th class="text-left">Recommendation</th>
                                    <th class="text-left">Reference</th>
                                    <th class="text-center">Priority</th>
                                    <th class="text-center">Audit Year</th>
                                    <th class="text-center">Target Date</th>
                                    <th class="text-center" style="width: 100px">Elapsed</th>
                                    <th class="text-center">Category</th>
                                </tr>
                            </thead>
                            <tbody>'.$annex7table.'
                            </tbody>
                        </table>
                    </div>
                </div>';
}

$annex8table = '';
array_multisort(array_column($processed_divisiondata[$division]["oios_data"], 'issue_date'), SORT_ASC,$processed_divisiondata[$division]["oios_data"]);
$j = 0;
foreach ($processed_divisiondata[$division]["oios_data"] as $key => $value) {
    $annex8table .= '<tr>';
    $annex8table .= '<td class="text-right">'.($j + 1).'.</td>';
    $annex8table .= '<td class="text-left" style="max-width: 300px;">'.ltrim(stristr($value["recommendation"], '. '), '. ').'</td>';
    $annex8table .= '<td class="text-left">'.$value["projectcode"].'</td>';
    $annex8table .= '<td class="text-center">'.$value["recommendation_update"].'</td>';
    $annex8table .= '<td class="text-center">'.$value["issue_date"].'</td>';
    $annex8table .= '<td class="text-center">'.$value["implementation_date"].'</td>';
    $elapsed = floor(getdaysbetween($value["issue_date"],min(date("Y-m-d",time()),$value["implementation_date"])));
    $duration = ceil(getdaysbetween($value["issue_date"],$value["implementation_date"]));
    if ($elapsed != 0 && $duration != 0) {
        $elapsedtime = number_format(($elapsed*100/max($duration,1) ),0,'.',',');
        if ($elapsedtime >= 0 && $elapsedtime < 100) {
            $annex8table .= '<td class="center"><div class="progress-bar"><span class="progress-bar-fill green" style="width: '.$elapsedtime.'%;">'.$elapsedtime.'%</span></div></td>';
        } else if ($elapsedtime >= 100) {
            $annex8table .= '<td class="center"><div class="progress-bar"><span class="progress-bar-fill red" style="width: 100%;">'.$elapsedtime.'%</span></div></td>';
        } else {
            $elapsedtime = 'N/A';
            $annex8table .= '<td class="center"><div class="progress-bar"><span class="progress-bar-fill gray" style="width:100%;">'.$elapsedtime.'</span></div></td>';
        }
    } else {
        $elapsedtime = 'N/A';
        $annex8table .= '<td class="center"><div class="progress-bar"><span class="progress-bar-fill gray" style="width:100%;">'.$elapsedtime.'</span></div></td>';
    }
    $annex8table .= '<td class="text-center">'.$value["category"].'</td>';
    $annex8table .= '</tr>';
    $j++;
}



if (empty($processed_divisiondata[$division]["oios_data"])) {
    $annex8 = '<div class="row reportbody section3">
                <h2 class="sectiontitle">Annex 8: OIOS</h2>
                <div class="table-responsive">
                    <p><b>Nothing to report</b></p>
                </div>
            </div>';

    echo "<p><b>Nothing to report</b></p>";
} else {
    $annex8 = '<div class="row reportbody section3">
                <h2 class="sectiontitle">Annex 8: OIOS</h2>
                <div class="table-responsive">
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
                        <tbody>'.$annex8table.'
                        </tbody>
                    </table>
                </div>
            </div>';
}


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
//$mpdf->Bookmark('Summary');
$mpdf->WriteHTML($pageheader);
$mpdf->AddPage();
$mpdf->WriteHTML($header);
//$mpdf->Bookmark('Annex 1: Projects Table');
$mpdf->WriteHTML($annex1);
$mpdf->AddPage();
//$mpdf->Bookmark('Annex 2: Vacant Positions');
$mpdf->WriteHTML($annex2);
$mpdf->AddPage();
//$mpdf->Bookmark('Annex 3: Filled Positions');
$mpdf->WriteHTML($annex3);
$mpdf->AddPage();
//$mpdf->Bookmark('Annex 4: Consultants');
$mpdf->WriteHTML($annex4);
$mpdf->AddPage();
//$mpdf->Bookmark('Annex 5: Umoja Grants Data');
$mpdf->WriteHTML($annex5);
$mpdf->AddPage();
//$mpdf->Bookmark('Annex 6: Project Risks');
$mpdf->WriteHTML($annex6);
$mpdf->AddPage();
//$mpdf->Bookmark('Annex 5: Umoja Grants Data');
$mpdf->WriteHTML($annex7);
$mpdf->AddPage();
//$mpdf->Bookmark('Annex 5: Umoja Grants Data');
$mpdf->WriteHTML($annex8);
$mpdf->WriteHTML($footer);
$mpdf->Output($filename, 'I');
exit;
?>