<?php
$month = Date("M") . ' ' . Date("Y");
$division = ucwords('Africa');
if( isset($_GET['office']) ) {
     $division = ucwords($_GET['office']);
}
include_once('dynamic_algo.php');

$reportheader = '
<html>
<head>
	<style>
	body {
        font-family: sans-serif;
        font-size: 10pt;
    }
    p {
        margin: 0pt;
    }
    table.items {
        border: 0.1mm solid #000000;
    }
    td {
        vertical-align: top;
    }
    .items td {
        border-left: 0.1mm solid #000000;
        border-right: 0.1mm solid #000000;
    }
    table thead th, table thead td {
        background-color: #EEEEEE;
        text-align: center;
        border: 0.1mm solid #000000;
        font-variant: small-caps;
    }
    .items td.blanktotal {
        background-color: #EEEEEE;
        border: 0.1mm solid #000000;
        background-color: #FFFFFF;
        border: 0mm none #000000;
        border-top: 0.1mm solid #000000;
        border-right: 0.1mm solid #000000;
    }
    .items td.totals {
        text-align: right;
        border: 0.1mm solid #000000;
    }
    .items td.cost {
        text-align: "." center;
    }
    .hidden {
        display: none !important;
    }

    .healthrating_box {
    	width: 1cm;
    	height: 1cm;
    	border-radius: 30%;
    	margin-right: 30px;
    }
    .body.left {
		background-color: #f6f6f6;
		font-family: 
	}
	.body.middle {
		
	}
	.body.right {
		
	}


    </style>
</head>

<body>
    <!--mpdf
    <htmlpageheader name="myheader">
        <!--<table width="100%">
            <tr>
                <td width="50%" style="color:#0000BB;">
                    <span style="font-weight: bold; font-size: 14pt;">Acme Trading Co.</span><br />123 Anystreet<br />Your City<br />GD12 4LP<br /><span style="font-family:dejavusanscondensed;">&#9742;</span> 01777 123 567
                </td>
                <td width="50%" style="text-align: right;">Invoice No.<br />
                    <span style="font-weight: bold; font-size: 12pt;">0012345</span>
                </td>
            </tr>
        </table>-->
    </htmlpageheader>
    <htmlpagefooter name="myfooter">
        <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: right; padding-top: 3mm; ">Page {PAGENO} of {nb}</div>
    </htmlpagefooter>
    <sethtmlpageheader name="myheader" value="on" show-this-page="1" />
    <sethtmlpagefooter name="myfooter" value="on" />
    mpdf-->
	<!-- Content Here -->';

$dashboardpage = '';
$dashboardpage .= '<div class="header" style="display: -ms-flexbox;display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap; border-bottom: 0.1cm solid #707070; margin-bottom: 0.2cm;">';

$dashboardpage .= '	<table class="header" width="100%" style="border-collapse: collapse; " cellpadding="0">
						<tr>
							<td width="33%">
								<table>
									<tr>
										<td>
											<img src="assets/images/pimslogo.png" style="max-width: 33%">
										</td>
									</tr>
									<tr>
										<td>'.$processed_divisiondata[$division]["reportedprojectspct"].'%</td>
									</tr>
									<tr>
										<td>
											<p style="margin: 0;font-size: 0.3cm;color: #17a2b8;">Compliance Reporting</p>
										</td>
									</tr>
								</table>
							</td>
							<td width="33%" align="center">
								<table>
									<tr>
										<td>
											<h1 style="margin: 0;font-weight: 500;font-size: 1.2cm;color: #333;letter-spacing: 0; text-align: center;">
                                        		'.$processed_divisiondata[$division]["entity"].'
                                    		</h1>
                                    	</td>
									</tr>
									<tr>
										<td>
											<h6 style="margin: 0;letter-spacing: 0;color: #707070;padding-top: 0cm;font-size: 0.4cm;font-weight: 400; margin-top:0.15cm; text-align: center;">
		                                        Programme Delivery Report
		                                    </h6>
										</td>
									</tr>
								</table>
							</td>
							<td width="33%" align="right">
								<table>
									<tr>
										<td align="right">
											<p class="healthrating_box" style="margin: 0;font-size: 0.35cm;font-weight: 400; margin-bottom: 0.2cm; margin-right: 25px;">
		                                        Jan 2021
		                                    </p>
										</td>
									</tr>
									<tr>
										<td>
											<div class="healthrating_box" style="border-radius: 30%;width: 1cm;height: 1cm;float: right;background-color:red; margin-top: 0cm; margin-right:30px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		                                    </div>
		                                </td>
									</tr>
									<tr>
										<td>
											<p style="margin: 0;font-size: 0.3cm;color: #17a2b8;">Project Portfolio Rating</p>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>';
$dashboardpage .= '</div>'; // end of header
$dashboardpage .= '<div class="body" style="display: -ms-flexbox;display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap; border-bottom: 0.1cm solid #707070; margin-bottom: 0.5cm; padding: 0.2cm 0 0.2cm">';

$dashboardpage .= 	'<table width="100%" style="table-layout: fixed;">
						<tr>
							<td class="body left" width="33%" align="left">
								<h5 style="margin: 0.2cm 0.4cm;font-size: 0.45cm;font-weight: 500;color: #333;">Summary</h5>
								<p style="margin: 0.2cm 0.4cm 0.4cm;text-align: justify;font-size: 0.33cm;font-weight: 300;line-height: 0.5cm;">The dashboard captured financial data of <strong>'.$processed_divisiondata[$division]["totalprojects"].' projects</strong> for the '.$division.' Office. The overall budget recorded for this portfolio as of 2020 was <strong>(USD. '.number_format($processed_divisiondata[$division]["consumablebudget"], 0, '.', ',').')</strong>, capturing a rolling total of the cash received over time.</p>
							</td>
							<td class="body middle" width="33%" align="left">
								
							</td>
							<td class="body right" width="33%" align="left">
								
							</td>
						</tr>
					</table>';
$dashboardpage .= '</div>'; // end of body





$annex1_tablecontent = '';
$annex1_tablecontent .= '<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">';
$annex1_tablecontent .= '<thead>';
$annex1_tablecontent .= '<tr>';
$annex1_tablecontent .= '<th>Project ID</th>';
$annex1_tablecontent .= '<th>Project Title</th>';
$annex1_tablecontent .= '<th>Subprogramme</th>';
$annex1_tablecontent .= '<th>Budget</th>';
$annex1_tablecontent .= '<th>System Rating</th>';
$annex1_tablecontent .= '<th>Management Rating</th>';
$annex1_tablecontent .= '<th>Reported</th>';
$annex1_tablecontent .= '<th>Project Manager</th>';
$annex1_tablecontent .= '<th>Outputs</th>';
$annex1_tablecontent .= '<th>Completed Activities</th>';
$annex1_tablecontent .= '<th>Total Activities</th>';
$annex1_tablecontent .= '</tr>';
$annex1_tablecontent .= '</thead>';
$annex1_tablecontent .= '<tbody>';
for($i=0; $i < count($processed_divisiondata[$division]["projectlisting"]); $i++ ) {
    $annex1_tablecontent .= '<tr>';
    $annex1_tablecontent .= '<td>'.$processed_divisiondata[$division]["projectlisting"][$i]['project_id'].'</td>';
    $annex1_tablecontent .= '<td>'.$processed_divisiondata[$division]["projectlisting"][$i]['project_title'].'</td>';
    $annex1_tablecontent .= '<td>'.$processed_divisiondata[$division]["projectlisting"][$i]['subprogramme'].'</td>';
    $annex1_tablecontent .= '<td>'.number_format($processed_divisiondata[$division]["projectlisting"][$i]['budget'],2,'.',',') .'</td>';
    $annex1_tablecontent .= '<td>'.$processed_divisiondata[$division]["projectlisting"][$i]['system_rating'].'</td>';
    $annex1_tablecontent .= '<td>'.$processed_divisiondata[$division]["projectlisting"][$i]['management_rating'].'</td>';
    $annex1_tablecontent .= '<td>'.$processed_divisiondata[$division]["projectlisting"][$i]['reported'].'</td>';
    $annex1_tablecontent .= '<td>'.$processed_divisiondata[$division]["projectlisting"][$i]['project_manager'].'</td>';
    $annex1_tablecontent .= '<td>'.$processed_divisiondata[$division]["projectlisting"][$i]['outputs'].'</td>';
    $annex1_tablecontent .= '<td>'.$processed_divisiondata[$division]["projectlisting"][$i]['completed_activities'].'</td>';
    $annex1_tablecontent .= '<td>'.$processed_divisiondata[$division]["projectlisting"][$i]['total_activities'].'</td>';
    $annex1_tablecontent .= '</tr>';
}
$annex1_tablecontent .= '</tbody>';
$annex1_tablecontent .= '</table>';



$annex2_tablecontent = '';
$annex2_tablecontent .= '<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">';
$annex2_tablecontent .= '<thead>';
$annex2_tablecontent .= '<tr>';
$annex2_tablecontent .= '<th>#</th>';
$annex2_tablecontent .= '<th>Grade</th>';
$annex2_tablecontent .= '<th>Position Title</th>';
$annex2_tablecontent .= '<th>Position Number</th>';
$annex2_tablecontent .= '<th>Duty Station</th>';
$annex2_tablecontent .= '<th>Filled</th>';
$annex2_tablecontent .= '<th>Staff Name</th>';
$annex2_tablecontent .= '<th>Org Code</th>';
$annex2_tablecontent .= '<th>Org Unit</th>';
$annex2_tablecontent .= '</tr>';
$annex2_tablecontent .= '</thead>';
$annex2_tablecontent .= '<tbody>';
for($i=0; $i < count($processed_divisiondata[$division]["stafflisting"]); $i++ ) {
    $annex2_tablecontent .= '<tr>';
    $annex2_tablecontent .= '<td>'.($i+1).'</td>';
    $annex2_tablecontent .= '<td>'.$processed_divisiondata[$division]["stafflisting"][$i]['grade'].'</td>';
    $annex2_tablecontent .= '<td>'.$processed_divisiondata[$division]["stafflisting"][$i]['position_title'].'</td>';
    $annex2_tablecontent .= '<td>'.$processed_divisiondata[$division]["stafflisting"][$i]['position_number'].'</td>';
    $annex2_tablecontent .= '<td>'.$processed_divisiondata[$division]["stafflisting"][$i]['duty_station'].'</td>';
    $annex2_tablecontent .= '<td>'.$processed_divisiondata[$division]["stafflisting"][$i]['filled'].'</td>';
    $annex2_tablecontent .= '<td>'.$processed_divisiondata[$division]["stafflisting"][$i]['staff_name'].'</td>';
    $annex2_tablecontent .= '<td>'.$processed_divisiondata[$division]["stafflisting"][$i]['org_code'].'</td>';
    $annex2_tablecontent .= '<td>'.$processed_divisiondata[$division]["stafflisting"][$i]['org_unit_description'].'</td>';
}
$annex2_tablecontent .= '</tbody>';
$annex2_tablecontent .= '</table>';



$reportfooter = '
    <!-- End of Content -->
    <div style="text-align: center; font-style: italic;">Payment terms: payment due in 30 days</div>
</body>

</html>
';


$path = (getenv('MPDF_ROOT')) ? getenv('MPDF_ROOT') : __DIR__;
require_once $path . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf([
	'margin_left' => 15,
	'margin_right' => 15,
	'margin_top' => 10,
	'margin_bottom' => 15,
	'margin_header' => 10,
	'margin_footer' => 10,
	'mode' => 'utf-8',
	'orientation' => 'L',
	'tempDir' => __DIR__ . '/files'

]);

$mpdf->SetProtection(array('print'));
$mpdf->SetTitle("PIMS+ Division Report");
$mpdf->SetAuthor("PIMS+ | UNEP");
$mpdf->SetDisplayMode('fullpage');

$mpdf->WriteHTML($reportheader);
$mpdf->WriteHTML($dashboardpage);
$mpdf->AddPage();
$mpdf->WriteHTML($annex1_tablecontent);
$mpdf->AddPage();
$mpdf->WriteHTML($annex2_tablecontent);
$mpdf->WriteHTML($reportfooter);

$mpdf->Output('PIMS+ Monthly Division Report.pdf', 'I');