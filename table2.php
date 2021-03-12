<?php
$month = date('M', strtotime('last month')).' '.date("Y");
$office = array('Europe', 'Economy', 'Disasters and Conflicts', 'Latin America', 'Asia Pacific', 'Law', 'Communication', 'Ecosystems', 'Science', 'Africa', 'West Asia');
$officeid = (isset($_GET['office'])) ? $_GET['office'] : 0;
$division = $office[$officeid];
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

$pageheader = '
            <table style="font-family:roboto !important;">
                <tr>
                    <td style="position: relative;width: 33.333333%;max-width:33.333333%;">
                        <img style="max-width: 100%" class="logo" src="assets/images/pimslogo.png">
                    </td>
                    <td style="position: relative;width: 50%;max-width:50%; text-align:center;">
                        <h1 style="font-size:2cm;font-family:Roboto;letter-spacing:0;color: #333;font-weight: bold;">'.$processed_divisiondata[$division]["entity"].'</h1>
                        <h6 style="font-size:1cm;font-family:Roboto;letter-spacing: 0;color: #707070;padding-top: 0cm;font-weight: 400;margin-top: 5px;">Programme Delivery Report</h6>
                    </td>
                    <td style="position: relative;width: 16.666667%;max-width:16.666667%; text-align:center;">
                        <p style="font-size:0.8cm;font-family:Roboto;letter-spacing: 0;color: #707070;font-weight:bold;margin-bottom: 0.2cm;padding-right: 30px;" class="reportdate">'.date('M', strtotime('last month')).' '.date("Y").'</p>
                        <p style="right:1cm"><img src="assets/images/'.gethealthimage($processed_divisiondata[$division]["projectlisting"][$i]['healthrating']).' " style="vertical-align:middle; height:1.2cm;"></p>
                        <p style="font-size:0.5cm;font-family:Roboto;letter-spacing: 0;color: #707070;font-weight:normal;" class="healthratingdesc">Project Portfolio Rating</p>
                    </td>
                </tr>
            </table>
            <hr style="color: #707070; height: 0.05cm;" />
            <table style="font-family:Roboto;color: #707070;line-height: 1.375;">
                <tr>
                    <td width="33.333333%" style="background-color:#f6f6f6;width: 33.333333%;text-align:left;padding:0.4cm 0.2cm;vertical-align:top">
                        <p style="font-size:0.5cm;font-weight:bold;text-decoration:underline;">Summary</p>
                        <table style="padding-top:0.2cm;font-family:Roboto;width:100%;">
                            <tr style="padding-bottom:0; margin-bottom: 0;">
                                <td width="16.666667%" style="text-align:center;color:#0077b6;">
                                    <p style="font-weight:bold;font-size:0.45cm;">'.number_format($processed_divisiondata[$division]["totalprojects"], 0, '.', ',').'</p>
                                </td>
                                <td width="16.666667%" style="text-align:center;color:#17a2b8;">
                                    <p style="font-weight:bold;font-size:0.45cm;">'.number_format($processed_divisiondata[$division]["totaloutputs"], 0, '.', ',').'</p>
                                </td>
                                <td width="16.666667%" style="text-align:center;color:#688753;">
                                    <p style="font-weight:bold;font-size:0.45cm;">'.number_format($processed_divisiondata[$division]["totalactivities"], 0, '.', ',').'</p>
                                </td>
                                <td width="16.666667%" style="text-align:center;color:#dc3545;">
                                    <p style="font-weight:bold;font-size:0.45cm;">'.number_format($processed_divisiondata[$division]["pastdueprojects"], 0, '.', ',').'</p>
                                </td>
                                <td width="16.666667%" style="text-align:center;color:#dc3545;">
                                    <p style="font-weight:bold;font-size:0.45cm;">'.number_format(abs($processed_divisiondata[$division]["avgmonthspastdue"]), 0, '.', ',').'</p>
                                </td>
                                <td width="16.666667%" style="text-align:center;color:#dc3545;">
                                    <p style="font-weight:bold;font-size:0.45cm;">'.number_format($processed_divisiondata[$division]["reportedprojectspct"], 0).'%</p>
                                </td>
                            </tr>
                            <tr style="padding-top:0; margin-top: 0;">
                                <td width="16.666667%" style="text-align:center;color:#0077b6;">
                                    <p style="font-weight:bold;font-size:0.3cm; line-height:1.375;">Total<br/>Projects</p>
                                </td>
                                <td width="16.666667%" style="text-align:center;color:#17a2b8;">
                                    <p style="font-weight:bold;font-size:0.3cm; line-height:1.375;">Total<br/>Outputs</p>
                                </td>
                                <td width="16.666667%" style="text-align:center;color:#688753;">
                                    <p style="font-weight:bold;font-size:0.3cm; line-height:1.375;">Total<br/>Activities</p>
                                </td>
                                <td width="16.666667%" style="text-align:center;color:#dc3545;">
                                    <p style="font-weight:bold;font-size:0.3cm; line-height:1.375;">Expired<br/>Projects</p>
                                </td>
                                <td width="16.666667%" style="text-align:center;color:#dc3545;">
                                    <p style="font-weight:bold;font-size:0.3cm; line-height:1.375;">Avg Months<br/>Past Due</p>
                                </td>
                                <td width="16.666667%" style="text-align:center;color:#dc3545;">
                                    <p style="font-weight:bold;font-size:0.3cm; line-height:1.375;">Reporting<br/>Compliance</p>
                                </td>
                            </tr>
                        </table>

                        <p style="font-weight:normal;font-size:0.4cm;text-align:justify;" class="summarytext">The dashboard captured financial data of <strong>'.$processed_divisiondata[$division]["totalprojects"].' projects</strong> for the '.$division.' Office. The overall budget recorded for this portfolio as of 2020 was <strong>(USD. '.number_format($processed_divisiondata[$division]["consumablebudget"], 0, '.', ',').')</strong>, capturing a rolling total of the cash received over time.</p>


                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </td>
                    <td width="33.333333%" style="width: 33.333333%;text-align:left;padding:0.4cm 0.2cm;vertical-align:top">
                        <p style="font-size:0.5cm;font-family:Roboto;font-weight:bold;text-decoration:underline;">Portfolio Statistics</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </td>
                    <td width="33.333333%" style="width: 33.333333%;text-align:left;padding:0.4cm 0.2cm;vertical-align:top">
                        <p style="font-size:0.5cm;font-family:Roboto;font-weight:bold;text-decoration:underline;">Human Resource</p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </td>
                </tr>
            </table>




            
            <div class="row reportbody section1">
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
for ($i = 0; $i < count($processed_divisiondata[$division]["stafflisting"]); $i++) {
    if ($processed_divisiondata[$division]["stafflisting"][$i]['position_status'] == 'FILLED') {
        $annex3table .= '<tr>';
        $annex3table .= '<td>' . ($j + 1) . '.</td>';
        $annex3table .= '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['grade'] . '</td>';
        $annex3table .= '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['position_title'] . '</td>';
        $annex3table .= '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['position_number'] . '</td>';
        $annex3table .= '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['duty_station'] . '</td>';
        //$annex3table .= '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['fund'] . '</td>';
        $annex3table .= '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['staff_name'] . '</td>';
        $annex3table .= '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['org_code'] . '</td>';
        $annex3table .= '<td>' . $processed_divisiondata[$division]["stafflisting"][$i]['org_unit_description'] . '</td>';
        $annex3table .= '</tr>';
        $j++;
    }
}

$annex3 = '<div class="row reportbody section3">
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
                        <tbody>'.$annex3table.'
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
	'margin_footer' => 10,
    'roboto'
]);

$mpdf->SetProtection(array('print'));
$mpdf->SetTitle("pimsreport");
$mpdf->SetAuthor("UNEP - PIMS+");
$mpdf->SetDisplayMode('fullpage');
$mpdf->SetFont('roboto');
$mpdf->Bookmark('Summary');
$mpdf->WriteHTML($pageheader);
$mpdf->AddPage();
$mpdf->WriteHTML($header);
$mpdf->Bookmark('Annex 1: Projects Table');
$mpdf->WriteHTML($annex1);
$mpdf->AddPage();
$mpdf->Bookmark('Annex 2: Vacant Positions');
$mpdf->WriteHTML($annex2);
$mpdf->AddPage();
$mpdf->Bookmark('Annex 3: Filled Positions');
$mpdf->WriteHTML($annex3);
$mpdf->WriteHTML($footer);
//$mpdf->Output($filename, 'I');
$mpdf->Output();
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