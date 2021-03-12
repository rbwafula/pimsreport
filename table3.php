<?php
$month = date('M', strtotime('last month')).' '.date("Y");
$office = array('Europe', 'Economy', 'Disasters and Conflicts', 'Latin America', 'Asia Pacific', 'Law', 'Communication', 'Ecosystems', 'Science', 'Africa', 'West Asia');
$officeid = (isset($_GET['office'])) ? $_GET['office'] : 0;
$division = $office[$officeid];
include_once 'dynamic_algo.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Report</title>
	<!-- Vendor CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    
    <!-- Vendor JS -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
</head>
<body>
	<div class="container-fluid printlandscape">
		<div id="toprint" class="toprint">
			<table style="font-family:roboto !important;">
                <tr>
                    <td style="position: relative;width: 33.333333%;max-width:33.333333%;">
                        <img style="max-width: 100%" class="logo" src="assets/images/pimslogo.png">
                    </td>
                    <td style="position: relative;width: 50%;max-width:50%; text-align:center;">
                        <h1 style="font-size:2cm;font-family:Roboto;letter-spacing:0;color: #333;font-weight: bold;"><?php $processed_divisiondata[$division]["entity"]; ?>Test</h1>
                        <h6 style="font-size:1cm;font-family:Roboto;letter-spacing: 0;color: #707070;padding-top: 0cm;font-weight: 400;margin-top: 5px;">Programme Delivery Report</h6>
                    </td>
                    <td style="position: relative;width: 16.666667%;max-width:16.666667%; text-align:center;">
                        <p style="font-size:0.8cm;font-family:Roboto;letter-spacing: 0;color: #707070;font-weight:bold;margin-bottom: 0.2cm;padding-right: 30px;" class="reportdate"><?php date('M', strtotime('last month')).' '.date("Y")?></p>
                        <p style="right:1cm"><img src="assets/images/red.png " style="vertical-align:middle; height:1.2cm;"></p>
                        <p style="font-size:0.5cm;font-family:Roboto;letter-spacing: 0;color: #707070;font-weight:normal;" class="healthratingdesc">Project Portfolio Rating</p>
                    </td>
                </tr>
            </table>
            <hr style="color: #707070; height: 0.05cm;" />
		</div>
	</div>
</body>
</html>