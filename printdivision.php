<?php
$month = Date("M") . ' ' . Date("Y");
$office = array('Europe', 'Economy', 'Disasters and Conflicts', 'Latin America', 'Asia Pacific', 'Law', 'Communication', 'Ecosystems', 'Science', 'Africa', 'West Asia');
$division = $office[1];
if (isset($_GET['office'])) {
    $division = $office[$_GET['office']];
}
include_once 'dynamic_algo.php';
$filename = 'pimsreport - ' . $division . '.pdf';

$header = '<!DOCTYPE html>
<html>
<head>
	<title>' . $division . ' Report</title>
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


$dash ='
<div class="container-fluid printlandscape">
        <div class="row noprint hidden" data-html2canvas-ignore="true">
            <main role="main" class="col-md-12 ml-sm-auto col-lg-12 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Division Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="javascript:void(0);">Share</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print();return false;">Export to PDF</button>
                            <!-- TRIGGER FOR THE HTML TO PDF FUNCTION -->
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="jsp();"> PDF</button>
                        </div>
                        <!--<button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                            <span data-feather="calendar"></span> This week
                        </button>-->
                    </div>
                </div>
            </main>
        </div>

        <div id="toprint" class="toprint">
            <div class="row reportheader">
                <div class="col-md-4 logo">
                    <img class="logo" src="assets/images/pimslogo.png">
                </div>
                <div class="col-md-5 title">
                    <h1>Law</h1>
                    <h6>Programme Delivery Report</h6>
                </div>
                <div class="col-md-3 health">
                    <p class="reportdate">Jan 2021</p>
                    <p class="healthrating_box" style="background-color:#dc3545 !important;">&nbsp;</p>
                    <p class="healthratingdesc">Project Portfolio Rating</p>
                </div>
            </div>

            <div class="row reportbody section1">
                <div class="col-md-4 summary">
                    <h5 class="sectiontitle">Summary</h5>
                    <div class="row summarystatistics">
                        <div class="col metric1">
                            <p class="metricvalue">
                                379                            </p>
                            <p class="metricdesc">Total<br>Projects</p>
                        </div>
                        <div class="col metric2">
                            <p class="metricvalue">
                                517                            </p>
                            <p class="metricdesc">Total<br>Outputs</p>
                        </div>
                        <div class="col metric3">
                            <p class="metricvalue">
                                1,698                            </p>
                            <p class="metricdesc">Total<br>Activities</p>
                        </div>
                        <div class="col metric4">
                            <p class="metricvalue">
                                214                            </p>
                            <p class="metricdesc">Expired<br>Projects</p>
                        </div>
                        <div class="col metric4">
                            <p class="metricvalue">
                                3                            </p>
                            <p class="metricdesc">Avg Months<br>Past Due</p>
                        </div>
                                                <div class="col metric4">
                            <p class="metricvalue">
                                6%
                            </p>
                            <p class="metricdesc">Reporting<br>Compliance</p>
                        </div>
                    </div>
                    <p class="summarytext">The dashboard captured financial data of <strong>379 projects</strong> for the Law Office. The overall budget recorded for this portfolio as of 2020 was <strong>(USD. 114,864,544)</strong>, capturing a rolling total of the cash received over time.</p>
                    <div class="row chartrender">
                        <div class="col-md-12 budgetsize">
                            <div id="budgetsize_chart" data-highcharts-chart="0" style="overflow: hidden;"><div id="highcharts-4fszs9b-0" dir="ltr" class="highcharts-container " style="position: relative; overflow: hidden; width: 227px; height: 200px; text-align: left; line-height: normal; z-index: 0; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); user-select: none;"><svg version="1.1" class="highcharts-root" style="font-family:&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, Arial, Helvetica, sans-serif;font-size:12px;" xmlns="http://www.w3.org/2000/svg" width="227" height="200" viewBox="0 0 227 200"><desc>Created with Highcharts 8.2.2</desc><defs><clipPath id="highcharts-4fszs9b-1-"><rect x="0" y="0" width="178" height="117" fill="none"></rect></clipPath></defs><rect fill="transparent" class="highcharts-background" x="0" y="0" width="227" height="200" rx="0" ry="0"></rect><rect fill="none" class="highcharts-plot-background" x="39" y="45" width="178" height="117"></rect><g class="highcharts-pane-group" data-z-index="0"></g><g class="highcharts-grid highcharts-xaxis-grid" data-z-index="1"><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 97.5 45 L 97.5 162" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 157.5 45 L 157.5 162" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 216.5 45 L 216.5 162" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 38.5 45 L 38.5 162" opacity="1"></path></g><g class="highcharts-grid highcharts-yaxis-grid" data-z-index="1"><path fill="none" stroke="#e6e6e6" stroke-width="1" data-z-index="1" class="highcharts-grid-line" d="M 39 162.5 L 217 162.5" opacity="1"></path><path fill="none" stroke="#e6e6e6" stroke-width="1" data-z-index="1" class="highcharts-grid-line" d="M 39 104.5 L 217 104.5" opacity="1"></path><path fill="none" stroke="#e6e6e6" stroke-width="1" data-z-index="1" class="highcharts-grid-line" d="M 39 44.5 L 217 44.5" opacity="1"></path></g><rect fill="none" class="highcharts-plot-border" data-z-index="1" x="39" y="45" width="178" height="117"></rect><g class="highcharts-axis highcharts-xaxis" data-z-index="2"><path fill="none" class="highcharts-axis-line" stroke="#ccd6eb" stroke-width="1" data-z-index="7" d="M 39 162.5 L 217 162.5"></path></g><g class="highcharts-axis highcharts-yaxis" data-z-index="2"><path fill="none" class="highcharts-axis-line" data-z-index="7" d="M 39 45 L 39 162"></path></g><g class="highcharts-series-group" data-z-index="3"><g class="highcharts-series highcharts-series-0 highcharts-column-series highcharts-tracker" data-z-index="0.1" opacity="1" transform="translate(39,45) scale(1 1)" clip-path="url(#highcharts-4fszs9b-1-)"><rect x="12" y="33" width="36" height="85" fill="#dc3545" opacity="1" class="highcharts-point highcharts-color-0"></rect><rect x="71" y="115" width="36" height="3" fill="#ffc107" opacity="1" class="highcharts-point highcharts-color-1"></rect><rect x="131" y="117" width="36" height="1" fill="#28a745" opacity="1" class="highcharts-point highcharts-color-2"></rect></g><g class="highcharts-markers highcharts-series-0 highcharts-column-series" data-z-index="0.1" opacity="1" transform="translate(39,45) scale(1 1)" clip-path="none"></g></g><text x="10" text-anchor="start" class="highcharts-title" data-z-index="4" style="color:#707070;font-size:10px;font-weight:900;text-transform:none;text-decoration:underline;fill:#707070;" y="10"><tspan>Figure 1: Projects by Rating</tspan></text><text x="114" text-anchor="middle" class="highcharts-subtitle" data-z-index="4" style="color:#666666;fill:#666666;" y="39"></text><text x="10" text-anchor="start" class="highcharts-caption" data-z-index="4" style="color:#666666;fill:#666666;" y="197"></text><g class="highcharts-data-labels highcharts-series-0 highcharts-column-series highcharts-tracker" data-z-index="6" opacity="1" transform="translate(39,45) scale(1 1)"><g class="highcharts-label highcharts-data-label highcharts-data-label-color-0" data-z-index="1" transform="translate(14,9)"><text x="5" data-z-index="1" y="16" style="color:#000000;font-size:11px;font-weight:bold;fill:#000000;"><tspan x="5" y="16" class="highcharts-text-outline" fill="#FFFFFF" stroke="#FFFFFF" stroke-width="2px" stroke-linejoin="round" style="">363</tspan><tspan x="5" y="16">363</tspan></text></g><g class="highcharts-label highcharts-data-label highcharts-data-label-color-1" data-z-index="1" transform="translate(77,91)"><text x="5" data-z-index="1" y="16" style="color:#000000;font-size:11px;font-weight:bold;fill:#000000;"><tspan x="5" y="16" class="highcharts-text-outline" fill="#FFFFFF" stroke="#FFFFFF" stroke-width="2px" stroke-linejoin="round" style="">13</tspan><tspan x="5" y="16">13</tspan></text></g><g class="highcharts-label highcharts-data-label highcharts-data-label-color-2" data-z-index="1" transform="translate(140,93)"><text x="5" data-z-index="1" y="16" style="color:#000000;font-size:11px;font-weight:bold;fill:#000000;"><tspan x="5" y="16" class="highcharts-text-outline" fill="#FFFFFF" stroke="#FFFFFF" stroke-width="2px" stroke-linejoin="round" style="">3</tspan><tspan x="5" y="16">3</tspan></text></g></g><g class="highcharts-legend" data-z-index="7"><rect fill="none" class="highcharts-legend-box" rx="0" ry="0" x="0" y="0" width="8" height="8" visibility="hidden"></rect><g data-z-index="1"><g></g></g></g><g class="highcharts-axis-labels highcharts-xaxis-labels" data-z-index="7"><text x="68.66666666666633" style="color:#666666;cursor:default;font-size:0.25cm;font-weight:700;fill:#666666;" text-anchor="middle" transform="translate(0,0)" y="182" opacity="1">Red</text><text x="128.00000000000335" style="color:#666666;cursor:default;font-size:0.25cm;font-weight:700;fill:#666666;" text-anchor="middle" transform="translate(0,0)" y="182" opacity="1">Yellow</text><text x="187.33333333333334" style="color:#666666;cursor:default;font-size:0.25cm;font-weight:700;fill:#666666;" text-anchor="middle" transform="translate(0,0)" y="182" opacity="1">Green</text></g><g class="highcharts-axis-labels highcharts-yaxis-labels" data-z-index="7"><text x="24" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="end" transform="translate(0,0)" y="164" opacity="1">0</text><text x="24" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="end" transform="translate(0,0)" y="106" opacity="1">250</text><text x="24" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="end" transform="translate(0,0)" y="47" opacity="1">500</text></g><text x="217" class="highcharts-credits" text-anchor="end" data-z-index="8" style="cursor:pointer;color:#999999;font-size:9px;fill:#999999;" y="195"></text></svg></div></div>
                            <script type="text/javascript">
                               
                            </script>
                        </div>
                    </div>

                    <div class="row chartrender">
                        <div class="col-md-12 budgetutilization">
                            <div id="budgetutilization_chart" data-highcharts-chart="1" style="overflow: hidden;"><div id="highcharts-4fszs9b-5" dir="ltr" class="highcharts-container " style="position: relative; overflow: hidden; width: 227px; height: 200px; text-align: left; line-height: normal; z-index: 0; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); user-select: none;"><svg version="1.1" class="highcharts-root" style="font-family:&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, Arial, Helvetica, sans-serif;font-size:12px;" xmlns="http://www.w3.org/2000/svg" width="227" height="200" viewBox="0 0 227 200"><desc>Created with Highcharts 8.2.2</desc><defs><clipPath id="highcharts-4fszs9b-6-"><rect x="0" y="0" width="178" height="98" fill="none"></rect></clipPath></defs><rect fill="transparent" class="highcharts-background" x="0" y="0" width="227" height="200" rx="0" ry="0"></rect><rect fill="none" class="highcharts-plot-background" x="39" y="58" width="178" height="98"></rect><g class="highcharts-pane-group" data-z-index="0"></g><g class="highcharts-grid highcharts-xaxis-grid" data-z-index="1"><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 97.5 58 L 97.5 156" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 157.5 58 L 157.5 156" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 216.5 58 L 216.5 156" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 38.5 58 L 38.5 156" opacity="1"></path></g><g class="highcharts-grid highcharts-yaxis-grid" data-z-index="1"><path fill="none" stroke="#e6e6e6" stroke-width="1" data-z-index="1" class="highcharts-grid-line" d="M 39 156.5 L 217 156.5" opacity="1"></path><path fill="none" stroke="#e6e6e6" stroke-width="1" data-z-index="1" class="highcharts-grid-line" d="M 39 107.5 L 217 107.5" opacity="1"></path><path fill="none" stroke="#e6e6e6" stroke-width="1" data-z-index="1" class="highcharts-grid-line" d="M 39 57.5 L 217 57.5" opacity="1"></path></g><rect fill="none" class="highcharts-plot-border" data-z-index="1" x="39" y="58" width="178" height="98"></rect><g class="highcharts-axis highcharts-xaxis" data-z-index="2"><path fill="none" class="highcharts-axis-line" stroke="#ccd6eb" stroke-width="1" data-z-index="7" d="M 39 156.5 L 217 156.5"></path></g><g class="highcharts-axis highcharts-yaxis" data-z-index="2"><path fill="none" class="highcharts-axis-line" data-z-index="7" d="M 39 58 L 39 156"></path></g><g class="highcharts-series-group" data-z-index="3"><g class="highcharts-series highcharts-series-0 highcharts-column-series highcharts-color-0 highcharts-tracker" data-z-index="0.1" opacity="1" transform="translate(39,58) scale(1 1)" clip-path="url(#highcharts-4fszs9b-6-)"><rect x="12" y="43" width="36" height="56" fill="#17a2b8" opacity="1" class="highcharts-point highcharts-color-0"></rect><rect x="71" y="67" width="36" height="32" fill="#17a2b8" opacity="1" class="highcharts-point highcharts-color-0"></rect><rect x="131" y="74" width="36" height="25" fill="#17a2b8" opacity="1" class="highcharts-point highcharts-color-0"></rect></g><g class="highcharts-markers highcharts-series-0 highcharts-column-series highcharts-color-0" data-z-index="0.1" opacity="1" transform="translate(39,58) scale(1 1)" clip-path="none"></g></g><text x="10" text-anchor="start" class="highcharts-title" data-z-index="4" style="color:#707070;font-size:10px;font-weight:900;text-transform:none;text-decoration:underline;fill:#707070;" y="10"><tspan>Figure 2: Budget Utilization</tspan><tspan dy="13" x="10">(USD M)</tspan></text><text x="114" text-anchor="middle" class="highcharts-subtitle" data-z-index="4" style="color:#666666;fill:#666666;" y="52"></text><text x="10" text-anchor="start" class="highcharts-caption" data-z-index="4" style="color:#666666;fill:#666666;" y="197"></text><g class="highcharts-data-labels highcharts-series-0 highcharts-column-series highcharts-color-0 highcharts-tracker" data-z-index="6" opacity="1" transform="translate(39,58) scale(1 1)"><g class="highcharts-label highcharts-data-label highcharts-data-label-color-0" data-z-index="1" transform="translate(-5,19)"><text x="5" data-z-index="1" y="16" style="color:#000000;font-size:11px;font-weight:bold;fill:#000000;"><tspan x="5" y="16" class="highcharts-text-outline" fill="#FFFFFF" stroke="#FFFFFF" stroke-width="2px" stroke-linejoin="round" style="">$ 114.86M</tspan><tspan x="5" y="16">$ 114.86M</tspan></text></g><g class="highcharts-label highcharts-data-label highcharts-data-label-color-0" data-z-index="1" transform="translate(57,43)"><text x="5" data-z-index="1" y="16" style="color:#000000;font-size:11px;font-weight:bold;fill:#000000;"><tspan x="5" y="16" class="highcharts-text-outline" fill="#FFFFFF" stroke="#FFFFFF" stroke-width="2px" stroke-linejoin="round" style="">$ 64.59M</tspan><tspan x="5" y="16">$ 64.59M</tspan></text></g><g class="highcharts-label highcharts-data-label highcharts-data-label-color-0" data-z-index="1" transform="translate(117,50)"><text x="5" data-z-index="1" y="16" style="color:#000000;font-size:11px;font-weight:bold;fill:#000000;"><tspan x="5" y="16" class="highcharts-text-outline" fill="#FFFFFF" stroke="#FFFFFF" stroke-width="2px" stroke-linejoin="round">$ 50.28M</tspan><tspan x="5" y="16">$ 50.28M</tspan></text></g></g><g class="highcharts-legend" data-z-index="7"><rect fill="none" class="highcharts-legend-box" rx="0" ry="0" x="0" y="0" width="8" height="8" visibility="hidden"></rect><g data-z-index="1"><g></g></g></g><g class="highcharts-axis-labels highcharts-xaxis-labels" data-z-index="7"><text x="68.66666666666633" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="middle" transform="translate(0,0)" y="176" opacity="1"><tspan>Consumable</tspan><tspan x="68.66666666666633" dy="10">Budget</tspan></text><text x="128.00000000000335" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="middle" transform="translate(0,0)" y="176" opacity="1"><tspan>Consumed</tspan><tspan x="128.00000000000335" dy="10">Budget</tspan></text><text x="187.33333333333334" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="middle" transform="translate(0,0)" y="176" opacity="1"><tspan>Budget</tspan><tspan x="187.33333333333334" dy="10">Balance</tspan></text></g><g class="highcharts-axis-labels highcharts-yaxis-labels" data-z-index="7"><text x="24" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="end" transform="translate(0,0)" y="158" opacity="1">0</text><text x="24" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="end" transform="translate(0,0)" y="109" opacity="1">100</text><text x="24" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="end" transform="translate(0,0)" y="60" opacity="1">200</text></g><text x="217" class="highcharts-credits" text-anchor="end" data-z-index="8" style="cursor:pointer;color:#999999;font-size:9px;fill:#999999;" y="195"></text></svg></div></div>
                            <script type="text/javascript">
                               
                            </script>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 portfolio">
                    <h5 class="sectiontitle">Portfolio Statistics</h5>
                    <div class="row portfoliostatistics">
                        <div class="col-md-4 metric1">
                            <div id="budgetutilized_chart" data-highcharts-chart="2" style="overflow: hidden;"><div id="highcharts-4fszs9b-10" dir="ltr" class="highcharts-container " style="position: relative; overflow: hidden; width: 75px; height: 130px; text-align: left; line-height: normal; z-index: 0; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); user-select: none;"><svg version="1.1" class="highcharts-root" style="font-family:&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, Arial, Helvetica, sans-serif;font-size:12px;" xmlns="http://www.w3.org/2000/svg" width="75" height="130" viewBox="0 0 75 130"><desc>Created with Highcharts 8.2.2</desc><defs><clipPath id="highcharts-4fszs9b-13-"><rect x="0" y="0" width="75" height="140" fill="none"></rect></clipPath></defs><rect fill="rgba(0,0,0,0)" class="highcharts-background" x="0" y="0" width="75" height="130" rx="0" ry="0"></rect><rect fill="none" class="highcharts-plot-background" x="0" y="0" width="75" height="140"></rect><g class="highcharts-pane-group" data-z-index="0"></g><rect fill="none" class="highcharts-plot-border" data-z-index="1" x="0" y="0" width="75" height="140"></rect><g class="highcharts-series-group" data-z-index="3"><g class="highcharts-series highcharts-series-0 highcharts-pie-series highcharts-tracker" data-z-index="0.1" opacity="1" transform="translate(0,0) scale(1 1)"><path fill="#0077b6" d="M 10.000002281552565 120.01120202597089 A 27.5 27.5 0 0 1 42.82308474009401 93.0201043580636 L 41.22615931806581 101.11407305064452 A 19.25 19.25 0 0 0 18.250001597086793 120.00784141817962 Z" transform="translate(0,0)" stroke="#ffffff" stroke-width="1" opacity="1" stroke-linejoin="round" class="highcharts-point highcharts-color-0"></path><path fill="#ccc" d="M 42.85006196969715 93.02544093186322 A 27.5 27.5 0 0 1 64.99998625000114 119.97250000458334 L 56.749990375000806 119.98075000320833 A 19.25 19.25 0 0 0 41.245043378788004 101.11780865230426 Z" transform="translate(0,0)" stroke="#ffffff" stroke-width="1" opacity="1" stroke-linejoin="round" class="highcharts-point highcharts-color-1"></path></g><g class="highcharts-markers highcharts-series-0 highcharts-pie-series" data-z-index="0.1" opacity="1" transform="translate(0,0) scale(1 1)"></g></g><text x="38" text-anchor="middle" class="highcharts-title" data-z-index="4" style="color:#0077b6;font-size:18px;font-weight:500;fill:#0077b6;" y="117"><tspan>56%</tspan></text><text x="38" text-anchor="middle" class="highcharts-subtitle" data-z-index="4" style="color:#666666;fill:#666666;" y="14"></text><text x="0" text-anchor="start" class="highcharts-caption" data-z-index="4" style="color:#666666;fill:#666666;" y="142"></text><g class="highcharts-data-labels highcharts-series-0 highcharts-pie-series highcharts-tracker" data-z-index="6" opacity="1" transform="translate(0,0) scale(1 1)"></g><g class="highcharts-legend" data-z-index="7"><rect fill="none" class="highcharts-legend-box" rx="0" ry="0" x="0" y="0" width="8" height="8" visibility="hidden"></rect><g data-z-index="1"><g></g></g></g></svg></div></div>
                            <div class="desc">Budget Spent</div>
                        </div>
                        <div class="col-md-4 metric2">
                            <div id="timetaken_chart" data-highcharts-chart="3" style="overflow: hidden;"><div id="highcharts-4fszs9b-14" dir="ltr" class="highcharts-container " style="position: relative; overflow: hidden; width: 75px; height: 130px; text-align: left; line-height: normal; z-index: 0; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); user-select: none;"><svg version="1.1" class="highcharts-root" style="font-family:&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, Arial, Helvetica, sans-serif;font-size:12px;" xmlns="http://www.w3.org/2000/svg" width="75" height="130" viewBox="0 0 75 130"><desc>Created with Highcharts 8.2.2</desc><defs><clipPath id="highcharts-4fszs9b-17-"><rect x="0" y="0" width="75" height="140" fill="none"></rect></clipPath></defs><rect fill="rgba(0,0,0,0)" class="highcharts-background" x="0" y="0" width="75" height="130" rx="0" ry="0"></rect><rect fill="none" class="highcharts-plot-background" x="0" y="0" width="75" height="140"></rect><g class="highcharts-pane-group" data-z-index="0"></g><rect fill="none" class="highcharts-plot-border" data-z-index="1" x="0" y="0" width="75" height="140"></rect><g class="highcharts-series-group" data-z-index="3"><g class="highcharts-series highcharts-series-0 highcharts-pie-series highcharts-tracker" data-z-index="0.1" opacity="1" transform="translate(0,0) scale(1 1)"><path fill="#d59442" d="M 10.000003650484103 120.01792324155342 A 44 44 0 0 1 93.79031194380411 101.21886384121663 L 92.88598667235402 101.64570784482535 A 43 43 0 0 0 11.000003567518554 120.01751589515447 Z" class="highcharts-halo highcharts-color-0" data-z-index="-1" fill-opacity="0.25" visibility="hidden"></path><path fill="#d59442" d="M 10.000002281552565 120.01120202597089 A 27.5 27.5 0 0 1 62.36894496487757 108.26178990076039 L 54.9082614754143 111.78325293053229 A 19.25 19.25 0 0 0 18.250001597086793 120.00784141817962 Z" transform="translate(0,0)" stroke="#ffffff" stroke-width="1" opacity="1" stroke-linejoin="round" class="highcharts-point highcharts-color-0"></path><path fill="#ccc" d="M 62.380670738549 108.28666471068502 A 27.5 27.5 0 0 1 64.99998625000114 119.97250000458334 L 56.749990375000806 119.98075000320833 A 19.25 19.25 0 0 0 54.91646951698429 111.80066529747951 Z" transform="translate(0,0)" stroke="#ffffff" stroke-width="1" opacity="1" stroke-linejoin="round" class="highcharts-point highcharts-color-1"></path></g><g class="highcharts-markers highcharts-series-0 highcharts-pie-series" data-z-index="0.1" opacity="1" transform="translate(0,0) scale(1 1)"></g></g><text x="38" text-anchor="middle" class="highcharts-title" data-z-index="4" style="color:#d59442;font-size:18px;font-weight:500;fill:#d59442;" y="117"><tspan>86%</tspan></text><text x="38" text-anchor="middle" class="highcharts-subtitle" data-z-index="4" style="color:#666666;fill:#666666;" y="14"></text><text x="0" text-anchor="start" class="highcharts-caption" data-z-index="4" style="color:#666666;fill:#666666;" y="142"></text><g class="highcharts-data-labels highcharts-series-0 highcharts-pie-series highcharts-tracker" data-z-index="6" opacity="1" transform="translate(0,0) scale(1 1)"></g><g class="highcharts-legend" data-z-index="7"><rect fill="none" class="highcharts-legend-box" rx="0" ry="0" x="0" y="0" width="8" height="8" visibility="hidden"></rect><g data-z-index="1"><g></g></g></g></svg></div></div>
                            <div class="desc">Time Used</div>
                        </div>
                        <div class="col-md-4 metric3">
                            <div id="activitiescompleted_chart" data-highcharts-chart="4" style="overflow: hidden;"><div id="highcharts-4fszs9b-18" dir="ltr" class="highcharts-container " style="position: relative; overflow: hidden; width: 75px; height: 130px; text-align: left; line-height: normal; z-index: 0; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); user-select: none;"><svg version="1.1" class="highcharts-root" style="font-family:&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, Arial, Helvetica, sans-serif;font-size:12px;" xmlns="http://www.w3.org/2000/svg" width="75" height="130" viewBox="0 0 75 130"><desc>Created with Highcharts 8.2.2</desc><defs><clipPath id="highcharts-4fszs9b-21-"><rect x="0" y="0" width="75" height="140" fill="none"></rect></clipPath></defs><rect fill="rgba(0,0,0,0)" class="highcharts-background" x="0" y="0" width="75" height="130" rx="0" ry="0"></rect><rect fill="none" class="highcharts-plot-background" x="0" y="0" width="75" height="140"></rect><g class="highcharts-pane-group" data-z-index="0"></g><rect fill="none" class="highcharts-plot-border" data-z-index="1" x="0" y="0" width="75" height="140"></rect><g class="highcharts-series-group" data-z-index="3"><g class="highcharts-series highcharts-series-0 highcharts-pie-series highcharts-tracker" data-z-index="0.1" opacity="1" transform="translate(0,0) scale(1 1)"><path fill="#ccc" d="M 14.802781861654637 100.01055052746652 A 44 44 0 0 1 97.99997800000183 119.95600000733333 L 96.99997850000179 119.95700000716667 A 43 43 0 0 0 15.693627728435217 100.46485619729683 Z" class="highcharts-halo highcharts-color-1" data-z-index="-1" fill-opacity="0.25" visibility="hidden"></path><path fill="#688753" d="M 10.000002281552565 120.01120202597089 A 27.5 27.5 0 0 1 12.989257508825698 107.53109858362244 L 20.34248025617799 111.2717690085357 A 19.25 19.25 0 0 0 18.250001597086793 120.00784141817962 Z" transform="translate(0,0)" stroke="#ffffff" stroke-width="1" opacity="1" stroke-linejoin="round" class="highcharts-point highcharts-color-0"></path><path fill="#ccc" d="M 13.001738663534148 107.50659407966657 A 27.5 27.5 0 0 1 64.99998625000114 119.97250000458334 L 56.749990375000806 119.98075000320833 A 19.25 19.25 0 0 0 20.351217064473904 111.2546158557666 Z" transform="translate(0,0)" stroke="#ffffff" stroke-width="1" opacity="1" stroke-linejoin="round" class="highcharts-point highcharts-color-1"></path></g><g class="highcharts-markers highcharts-series-0 highcharts-pie-series" data-z-index="0.1" opacity="1" transform="translate(0,0) scale(1 1)"></g></g><text x="38" text-anchor="middle" class="highcharts-title" data-z-index="4" style="color:#688753;font-size:18px;font-weight:500;fill:#688753;" y="117"><tspan>15%</tspan></text><text x="38" text-anchor="middle" class="highcharts-subtitle" data-z-index="4" style="color:#666666;fill:#666666;" y="14"></text><text x="0" text-anchor="start" class="highcharts-caption" data-z-index="4" style="color:#666666;fill:#666666;" y="142"></text><g class="highcharts-data-labels highcharts-series-0 highcharts-pie-series highcharts-tracker" data-z-index="6" opacity="1" transform="translate(0,0) scale(1 1)"></g><g class="highcharts-legend" data-z-index="7"><rect fill="none" class="highcharts-legend-box" rx="0" ry="0" x="0" y="0" width="8" height="8" visibility="hidden"></rect><g data-z-index="1"><g></g></g></g></svg></div></div>
                            <div class="desc">Activities Completed</div>
                        </div>
                        <script type="text/javascript">
                            
                        </script>
                    </div>

                    <div class="row chartrender">
                        <div class="col-md-12 groupingbyage">
                            <div id="groupingbyage_chart" data-highcharts-chart="5" style="overflow: hidden;"><div id="highcharts-4fszs9b-22" dir="ltr" class="highcharts-container " style="position: relative; overflow: hidden; width: 227px; height: 200px; text-align: left; line-height: normal; z-index: 0; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); user-select: none;"><svg version="1.1" class="highcharts-root" style="font-family:&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, Arial, Helvetica, sans-serif;font-size:12px;" xmlns="http://www.w3.org/2000/svg" width="227" height="200" viewBox="0 0 227 200"><desc>Created with Highcharts 8.2.2</desc><defs><clipPath id="highcharts-4fszs9b-23-"><rect x="0" y="0" width="121" height="166" fill="none"></rect></clipPath></defs><rect fill="transparent" class="highcharts-background" x="0" y="0" width="227" height="200" rx="0" ry="0"></rect><rect fill="none" class="highcharts-plot-background" x="51" y="45" width="166" height="121"></rect><g class="highcharts-pane-group" data-z-index="0"></g><g class="highcharts-grid highcharts-xaxis-grid" data-z-index="1"><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 51 75.5 L 217 75.5" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 51 106.5 L 217 106.5" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 51 136.5 L 217 136.5" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 51 166.5 L 217 166.5" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 51 45.5 L 217 45.5" opacity="1"></path></g><g class="highcharts-grid highcharts-yaxis-grid" data-z-index="1"><path fill="none" stroke="#e6e6e6" stroke-width="1" data-z-index="1" class="highcharts-grid-line" d="M 50.5 45 L 50.5 166" opacity="1"></path><path fill="none" stroke="#e6e6e6" stroke-width="1" data-z-index="1" class="highcharts-grid-line" d="M 105.5 45 L 105.5 166" opacity="1"></path><path fill="none" stroke="#e6e6e6" stroke-width="1" data-z-index="1" class="highcharts-grid-line" d="M 161.5 45 L 161.5 166" opacity="1"></path><path fill="none" stroke="#e6e6e6" stroke-width="1" data-z-index="1" class="highcharts-grid-line" d="M 217.5 45 L 217.5 166" opacity="1"></path></g><rect fill="none" class="highcharts-plot-border" data-z-index="1" x="51" y="45" width="166" height="121"></rect><g class="highcharts-axis highcharts-xaxis" data-z-index="2"><path fill="none" class="highcharts-axis-line" stroke="#ccd6eb" stroke-width="1" data-z-index="7" d="M 50.5 45 L 50.5 166"></path></g><g class="highcharts-axis highcharts-yaxis" data-z-index="2"><path fill="none" class="highcharts-axis-line" data-z-index="7" d="M 51 166 L 217 166"></path></g><path fill="none" class="highcharts-crosshair highcharts-crosshair-category undefined" data-z-index="2" stroke="rgba(204,214,235,0.25)" stroke-width="30.25" style="pointer-events:none;" visibility="hidden" d="M 51 90.5 L 217 90.5"></path><g class="highcharts-series-group" data-z-index="3"><g class="highcharts-series highcharts-series-0 highcharts-bar-series highcharts-tracker" data-z-index="0.1" opacity="1" transform="translate(217,166) rotate(90) scale(-1,1) scale(1 1)" clip-path="url(#highcharts-4fszs9b-23-)" width="166" height="121"><rect x="97" y="129" width="19" height="38" fill="#4e90e0" opacity="1" class="highcharts-point"></rect><rect x="67" y="28" width="19" height="139" fill="rgb(78,144,224)" opacity="1" class="highcharts-point"></rect><rect x="36" y="136" width="19" height="31" fill="#4e90e0" opacity="1" class="highcharts-point"></rect><rect x="6" y="166" width="19" height="1" fill="#4e90e0" opacity="1" class="highcharts-point"></rect></g><g class="highcharts-markers highcharts-series-0 highcharts-bar-series" data-z-index="0.1" opacity="1" transform="translate(217,166) rotate(90) scale(-1,1) scale(1 1)" clip-path="none"></g></g><text x="10" text-anchor="start" class="highcharts-title" data-z-index="4" style="color:#707070;font-size:10px;font-weight:900;text-transform:none;text-decoration:underline;fill:#707070;" y="10"><tspan>Figure 3: Projects Age Category</tspan></text><text x="114" text-anchor="middle" class="highcharts-subtitle" data-z-index="4" style="color:#666666;fill:#666666;" y="39"></text><text x="10" text-anchor="start" class="highcharts-caption" data-z-index="4" style="color:#666666;fill:#666666;" y="197"></text><g class="highcharts-data-labels highcharts-series-0 highcharts-bar-series highcharts-tracker" data-z-index="6" opacity="1" transform="translate(51,45) scale(1 1)"><g class="highcharts-label highcharts-data-label highcharts-data-label-color-undefined" data-z-index="1" transform="translate(37,3)"><text x="5" data-z-index="1" y="16" style="color:#000000;font-size:11px;font-weight:bold;fill:#000000;"><tspan x="5" y="16" class="highcharts-text-outline" fill="#FFFFFF" stroke="#FFFFFF" stroke-width="2px" stroke-linejoin="round" style="">69</tspan><tspan x="5" y="16">69</tspan></text></g><g class="highcharts-label highcharts-data-label highcharts-data-label-color-undefined" data-z-index="1" transform="translate(138,33)"><text x="5" data-z-index="1" y="16" style="color:#000000;font-size:11px;font-weight:bold;fill:#000000;"><tspan x="5" y="16" class="highcharts-text-outline" fill="#FFFFFF" stroke="#FFFFFF" stroke-width="2px" stroke-linejoin="round" style="">252</tspan><tspan x="5" y="16">252</tspan></text></g><g class="highcharts-label highcharts-data-label highcharts-data-label-color-undefined" data-z-index="1" transform="translate(30,64)"><text x="5" data-z-index="1" y="16" style="color:#000000;font-size:11px;font-weight:bold;fill:#000000;"><tspan x="5" y="16" class="highcharts-text-outline" fill="#FFFFFF" stroke="#FFFFFF" stroke-width="2px" stroke-linejoin="round">56</tspan><tspan x="5" y="16">56</tspan></text></g><g class="highcharts-label highcharts-data-label highcharts-data-label-color-undefined" data-z-index="1" transform="translate(0,94)"><text x="5" data-z-index="1" y="16" style="color:#000000;font-size:11px;font-weight:bold;fill:#000000;"><tspan x="5" y="16" class="highcharts-text-outline" fill="#FFFFFF" stroke="#FFFFFF" stroke-width="2px" stroke-linejoin="round" style="">2</tspan><tspan x="5" y="16">2</tspan></text></g></g><g class="highcharts-legend" data-z-index="7"><rect fill="none" class="highcharts-legend-box" rx="0" ry="0" x="0" y="0" width="8" height="8" visibility="hidden"></rect><g data-z-index="1"><g></g></g></g><g class="highcharts-axis-labels highcharts-xaxis-labels" data-z-index="7"><text x="36" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="end" transform="translate(0,0)" y="66" opacity="1"><tspan>0-2 Y</tspan></text><text x="36" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="end" transform="translate(0,0)" y="97" opacity="1"><tspan>2-5 Y</tspan></text><text x="36" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="end" transform="translate(0,0)" y="127" opacity="1"><tspan>5-10 Y</tspan></text><text x="36" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="end" transform="translate(0,0)" y="157" opacity="1"><tspan>10+ Y</tspan></text></g><g class="highcharts-axis-labels highcharts-yaxis-labels" data-z-index="7"><text x="51" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="middle" transform="translate(0,0)" y="182" opacity="1">0</text><text x="106.33333333333" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="middle" transform="translate(0,0)" y="182" opacity="1">100</text><text x="161.66666666667" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="middle" transform="translate(0,0)" y="182" opacity="1">200</text><text x="209.828125" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="middle" transform="translate(0,0)" y="182" opacity="1">300</text></g><text x="217" class="highcharts-credits" text-anchor="end" data-z-index="8" style="cursor:pointer;color:#999999;font-size:9px;fill:#999999;" y="195"></text></svg></div></div>
                            <script type="text/javascript">
                               
                            </script>
                        </div>
                    </div>

                    <div class="row chartrender">
                        <div class="col-md-12 projectsbysubprogramme">
                            <div id="projectsbysubprogramme_chart" data-highcharts-chart="6" style="overflow: hidden;"><div id="highcharts-4fszs9b-28" dir="ltr" class="highcharts-container " style="position: relative; overflow: hidden; width: 227px; height: 250px; text-align: left; line-height: normal; z-index: 0; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); user-select: none;"><svg version="1.1" class="highcharts-root" style="font-family:&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, Arial, Helvetica, sans-serif;font-size:12px;" xmlns="http://www.w3.org/2000/svg" width="227" height="250" viewBox="0 0 227 250"><desc>Created with Highcharts 8.2.2</desc><defs><clipPath id="highcharts-4fszs9b-29-"><rect x="0" y="0" width="178" height="154" fill="none"></rect></clipPath></defs><rect fill="transparent" class="highcharts-background" x="0" y="0" width="227" height="250" rx="0" ry="0"></rect><rect fill="none" class="highcharts-plot-background" x="39" y="58" width="178" height="154"></rect><g class="highcharts-pane-group" data-z-index="0"></g><g class="highcharts-grid highcharts-xaxis-grid" data-z-index="1"><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 97.5 58 L 97.5 212" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 157.5 58 L 157.5 212" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 216.5 58 L 216.5 212" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 38.5 58 L 38.5 212" opacity="1"></path></g><g class="highcharts-grid highcharts-yaxis-grid" data-z-index="1"><path fill="none" stroke="#e6e6e6" stroke-width="1" data-z-index="1" class="highcharts-grid-line" d="M 39 212.5 L 217 212.5" opacity="1"></path><path fill="none" stroke="#e6e6e6" stroke-width="1" data-z-index="1" class="highcharts-grid-line" d="M 39 135.5 L 217 135.5" opacity="1"></path><path fill="none" stroke="#e6e6e6" stroke-width="1" data-z-index="1" class="highcharts-grid-line" d="M 39 57.5 L 217 57.5" opacity="1"></path></g><rect fill="none" class="highcharts-plot-border" data-z-index="1" x="39" y="58" width="178" height="154"></rect><g class="highcharts-axis highcharts-xaxis" data-z-index="2"><path fill="none" class="highcharts-axis-line" stroke="#ccd6eb" stroke-width="1" data-z-index="7" d="M 39 212.5 L 217 212.5"></path></g><g class="highcharts-axis highcharts-yaxis" data-z-index="2"><path fill="none" class="highcharts-axis-line" data-z-index="7" d="M 39 58 L 39 212"></path></g><g class="highcharts-series-group" data-z-index="3"><g class="highcharts-series highcharts-series-0 highcharts-column-series highcharts-color-0 highcharts-tracker" data-z-index="0.1" opacity="1" transform="translate(39,58) scale(1 1)" clip-path="url(#highcharts-4fszs9b-29-)"><rect x="12" y="154" width="36" height="1" fill="#0077b6" opacity="1" class="highcharts-point highcharts-color-0"></rect><rect x="71" y="153" width="36" height="2" fill="#0077b6" opacity="1" class="highcharts-point highcharts-color-0"></rect><rect x="131" y="12" width="36" height="143" fill="#0077b6" opacity="1" class="highcharts-point highcharts-color-0"></rect></g><g class="highcharts-markers highcharts-series-0 highcharts-column-series highcharts-color-0" data-z-index="0.1" opacity="1" transform="translate(39,58) scale(1 1)" clip-path="none"></g></g><text x="10" text-anchor="start" class="highcharts-title" data-z-index="4" style="color:#707070;font-size:10px;font-weight:900;text-transform:none;text-decoration:underline;fill:#707070;" y="10"><tspan>Figure 4: Projects by Sub-</tspan><tspan dy="13" x="10">Programme</tspan></text><text x="114" text-anchor="middle" class="highcharts-subtitle" data-z-index="4" style="color:#666666;fill:#666666;" y="52"></text><text x="10" text-anchor="start" class="highcharts-caption" data-z-index="4" style="color:#666666;fill:#666666;" y="247"></text><g class="highcharts-data-labels highcharts-series-0 highcharts-column-series highcharts-color-0 highcharts-tracker" data-z-index="6" opacity="1" transform="translate(39,58) scale(1 1)"><g class="highcharts-label highcharts-data-label highcharts-data-label-color-0" data-z-index="1" transform="translate(21,130)"><text x="5" data-z-index="1" y="16" style="color:#000000;font-size:11px;font-weight:bold;fill:#000000;"><tspan x="5" y="16" class="highcharts-text-outline" fill="#FFFFFF" stroke="#FFFFFF" stroke-width="2px" stroke-linejoin="round" style="">2</tspan><tspan x="5" y="16">2</tspan></text></g><g class="highcharts-label highcharts-data-label highcharts-data-label-color-0" data-z-index="1" transform="translate(80,129)"><text x="5" data-z-index="1" y="16" style="color:#000000;font-size:11px;font-weight:bold;fill:#000000;"><tspan x="5" y="16" class="highcharts-text-outline" fill="#FFFFFF" stroke="#FFFFFF" stroke-width="2px" stroke-linejoin="round">6</tspan><tspan x="5" y="16">6</tspan></text></g><g class="highcharts-label highcharts-data-label highcharts-data-label-color-0" data-z-index="1" transform="translate(133,12)"><text x="5" data-z-index="1" y="16" style="color:#FFFFFF;font-size:11px;font-weight:bold;fill:#FFFFFF;"><tspan x="5" y="16" class="highcharts-text-outline" fill="#000000" stroke="#000000" stroke-width="2px" stroke-linejoin="round">371</tspan><tspan x="5" y="16">371</tspan></text></g></g><g class="highcharts-legend" data-z-index="7"><rect fill="none" class="highcharts-legend-box" rx="0" ry="0" x="0" y="0" width="8" height="8" visibility="hidden"></rect><g data-z-index="1"><g></g></g></g><g class="highcharts-axis-labels highcharts-xaxis-labels" data-z-index="7"><text x="68.66666666666633" style="color:#666666;cursor:default;font-size:0.25cm;font-weight:700;fill:#666666;" text-anchor="middle" transform="translate(0,0)" y="232" opacity="1"><tspan>SP 3</tspan></text><text x="128.00000000000335" style="color:#666666;cursor:default;font-size:0.25cm;font-weight:700;fill:#666666;" text-anchor="middle" transform="translate(0,0)" y="232" opacity="1"><tspan>SP 4</tspan></text><text x="187.33333333333334" style="color:#666666;cursor:default;font-size:0.25cm;font-weight:700;fill:#666666;" text-anchor="middle" transform="translate(0,0)" y="232" opacity="1"><tspan>SP 5</tspan></text></g><g class="highcharts-axis-labels highcharts-yaxis-labels" data-z-index="7"><text x="24" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="end" transform="translate(0,0)" y="214" opacity="1">0</text><text x="24" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="end" transform="translate(0,0)" y="137" opacity="1">200</text><text x="24" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="end" transform="translate(0,0)" y="60" opacity="1">400</text></g><text x="217" class="highcharts-credits" text-anchor="end" data-z-index="8" style="cursor:pointer;color:#999999;font-size:9px;fill:#999999;" y="245"></text></svg></div></div>
                            <script type="text/javascript">
                                
                            </script>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 humanresource">
                    <h5 class="sectiontitle">Human Resource</h5>
                    <div class="row chartrender">
                        <div class="col-md-12 hrfilled">
                            <div class="row hrstatistics">
                                                                <div class="col metric1">
                                    <p class="metricvalue">
                                        90                                    </p>
                                    <p class="metricdesc">Total Posts</p>
                                </div>
                                <div class="col metric3">
                                    <p class="metricvalue">
                                        30                                    </p>
                                    <p class="metricdesc">Vacant Posts</p>
                                </div>
                                <div class="col metric2">
                                    <p class="metricvalue">
                                        60                                    </p>
                                    <p class="metricdesc">Filled Posts</p>
                                </div>
                                <div class="col metric4">
                                    <p class="metricvalue">
                                        68%
                                    </p>
                                    <p class="metricdesc">Female</p>
                                </div>
                                <div class="col metric5">
                                    <p class="metricvalue">
                                        32%
                                    </p>
                                    <p class="metricdesc">Male</p>
                                </div>
                            </div>
                            <div id="hrfilled_chart" data-highcharts-chart="7" style="overflow: hidden;"><div id="highcharts-4fszs9b-33" dir="ltr" class="highcharts-container " style="position: relative; overflow: hidden; width: 227px; height: 250px; text-align: left; line-height: normal; z-index: 0; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); user-select: none;"><svg version="1.1" class="highcharts-root" style="font-family:&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, Arial, Helvetica, sans-serif;font-size:12px;" xmlns="http://www.w3.org/2000/svg" width="227" height="250" viewBox="0 0 227 250"><desc>Created with Highcharts 8.2.2</desc><defs><clipPath id="highcharts-4fszs9b-34-"><rect x="0" y="0" width="126" height="177" fill="none"></rect></clipPath></defs><rect fill="transparent" class="highcharts-background" x="0" y="0" width="227" height="250" rx="0" ry="0"></rect><rect fill="none" class="highcharts-plot-background" x="40" y="45" width="177" height="126"></rect><g class="highcharts-pane-group" data-z-index="0"></g><g class="highcharts-grid highcharts-xaxis-grid" data-z-index="1"><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 40 63.5 L 217 63.5" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 40 81.5 L 217 81.5" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 40 99.5 L 217 99.5" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 40 117.5 L 217 117.5" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 40 135.5 L 217 135.5" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 40 153.5 L 217 153.5" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 40 171.5 L 217 171.5" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 40 45.5 L 217 45.5" opacity="1"></path></g><g class="highcharts-grid highcharts-yaxis-grid" data-z-index="1"><path fill="none" stroke="#e6e6e6" stroke-width="1" data-z-index="1" class="highcharts-grid-line" d="M 39.5 45 L 39.5 171" opacity="1"></path><path fill="none" stroke="#e6e6e6" stroke-width="1" data-z-index="1" class="highcharts-grid-line" d="M 98.5 45 L 98.5 171" opacity="1"></path><path fill="none" stroke="#e6e6e6" stroke-width="1" data-z-index="1" class="highcharts-grid-line" d="M 157.5 45 L 157.5 171" opacity="1"></path><path fill="none" stroke="#e6e6e6" stroke-width="1" data-z-index="1" class="highcharts-grid-line" d="M 217.5 45 L 217.5 171" opacity="1"></path></g><rect fill="none" class="highcharts-plot-border" data-z-index="1" x="40" y="45" width="177" height="126"></rect><g class="highcharts-axis highcharts-xaxis" data-z-index="2"><path fill="none" class="highcharts-axis-line" stroke="#ccd6eb" stroke-width="1" data-z-index="7" d="M 39.5 45 L 39.5 171"></path></g><g class="highcharts-axis highcharts-yaxis" data-z-index="2"><path fill="none" class="highcharts-axis-line" data-z-index="7" d="M 40 171 L 217 171"></path></g><g class="highcharts-series-group" data-z-index="3"><g class="highcharts-series highcharts-series-0 highcharts-bar-series highcharts-color-0 highcharts-tracker" data-z-index="0.1" opacity="1" transform="translate(217,171) rotate(90) scale(-1,1) scale(1 1)" clip-path="url(#highcharts-4fszs9b-34-)" width="177" height="126"><rect x="112" y="175" width="10" height="0" fill="rgb(220,53,69,0.6)" opacity="1" class="highcharts-point highcharts-color-0"></rect><rect x="94" y="163" width="10" height="12" fill="rgb(220,53,69,0.6)" opacity="1" class="highcharts-point highcharts-color-0"></rect><rect x="76" y="157" width="10" height="9" fill="rgb(220,53,69,0.6)" opacity="1" class="highcharts-point highcharts-color-0"></rect><rect x="58" y="125" width="10" height="15" fill="rgb(220,53,69,0.6)" opacity="1" class="highcharts-point highcharts-color-0"></rect><rect x="40" y="149" width="10" height="11" fill="rgb(220,53,69,0.6)" opacity="1" class="highcharts-point highcharts-color-0"></rect><rect x="22" y="149" width="10" height="17" fill="rgb(220,53,69,0.6)" opacity="1" class="highcharts-point highcharts-color-0"></rect><rect x="4" y="63" width="10" height="24" fill="rgb(220,53,69,0.6)" opacity="1" class="highcharts-point highcharts-color-0"></rect></g><g class="highcharts-markers highcharts-series-0 highcharts-bar-series highcharts-color-0" data-z-index="0.1" opacity="1" transform="translate(217,171) rotate(90) scale(-1,1) scale(1 1)" clip-path="none"></g><g class="highcharts-series highcharts-series-1 highcharts-bar-series highcharts-color-1 highcharts-tracker" data-z-index="0.1" opacity="1" transform="translate(217,171) rotate(90) scale(-1,1) scale(1 1)" clip-path="url(#highcharts-4fszs9b-34-)" width="177" height="126"><rect x="112" y="175" width="10" height="3" fill="rgb(104,135,83,0.6)" opacity="1" class="highcharts-point highcharts-color-1"></rect><rect x="94" y="175" width="10" height="3" fill="rgb(104,135,83,0.6)" opacity="1" class="highcharts-point highcharts-color-1"></rect><rect x="76" y="166" width="10" height="12" fill="rgb(104,135,83,0.6)" opacity="1" class="highcharts-point highcharts-color-1"></rect><rect x="58" y="140" width="10" height="38" fill="rgb(104,135,83,0.6)" opacity="1" class="highcharts-point highcharts-color-1"></rect><rect x="40" y="160" width="10" height="18" fill="rgb(104,135,83,0.6)" opacity="1" class="highcharts-point highcharts-color-1"></rect><rect x="22" y="166" width="10" height="12" fill="rgb(104,135,83,0.6)" opacity="1" class="highcharts-point highcharts-color-1"></rect><rect x="4" y="87" width="10" height="91" fill="rgb(104,135,83,0.6)" opacity="1" class="highcharts-point highcharts-color-1"></rect></g><g class="highcharts-markers highcharts-series-1 highcharts-bar-series highcharts-color-1" data-z-index="0.1" opacity="1" transform="translate(217,171) rotate(90) scale(-1,1) scale(1 1)" clip-path="none"></g></g><text x="10" text-anchor="start" class="highcharts-title" data-z-index="4" style="color:#707070;font-size:10px;font-weight:900;text-transform:none;text-decoration:underline;fill:#707070;" y="10"><tspan>Figure 5: Post Occupancy</tspan></text><text x="114" text-anchor="middle" class="highcharts-subtitle" data-z-index="4" style="color:#666666;fill:#666666;" y="39"></text><text x="10" text-anchor="start" class="highcharts-caption" data-z-index="4" style="color:#666666;fill:#666666;" y="247"></text><g class="highcharts-legend" data-z-index="7" transform="translate(38,205)"><rect fill="none" class="highcharts-legend-box" rx="0" ry="0" x="0" y="0" width="151" height="30" visibility="visible"></rect><g data-z-index="1"><g><g class="highcharts-legend-item highcharts-bar-series highcharts-color-1 highcharts-series-1" data-z-index="1" transform="translate(8,3)"><text x="21" style="color:#333333;cursor:pointer;font-size:12px;font-weight:bold;fill:#333333;" text-anchor="start" data-z-index="2" y="15"><tspan>Filled</tspan></text><rect x="2" y="4" width="12" height="12" fill="rgb(104,135,83,0.6)" rx="6" ry="6" class="highcharts-point" data-z-index="3"></rect></g><g class="highcharts-legend-item highcharts-bar-series highcharts-color-0 highcharts-series-0" data-z-index="1" transform="translate(81.53125,3)"><text x="21" y="15" style="color:#333333;cursor:pointer;font-size:12px;font-weight:bold;fill:#333333;" text-anchor="start" data-z-index="2"><tspan>Vacant</tspan></text><rect x="2" y="4" width="12" height="12" fill="rgb(220,53,69,0.6)" rx="6" ry="6" class="highcharts-point" data-z-index="3"></rect></g></g></g></g><g class="highcharts-axis-labels highcharts-xaxis-labels" data-z-index="7"><text x="25" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="end" transform="translate(0,0)" y="60" opacity="1">D-2</text><text x="25" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="end" transform="translate(0,0)" y="78" opacity="1">D-1</text><text x="25" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="end" transform="translate(0,0)" y="96" opacity="1">P-5</text><text x="25" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="end" transform="translate(0,0)" y="114" opacity="1">P-4</text><text x="25" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="end" transform="translate(0,0)" y="132" opacity="1">P-3</text><text x="25" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="end" transform="translate(0,0)" y="150" opacity="1">P-2</text><text x="25" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="end" transform="translate(0,0)" y="168" opacity="1">GS</text></g><g class="highcharts-axis-labels highcharts-yaxis-labels" data-z-index="7"><text x="40" style="color:#666666;cursor:default;font-size:11px;fill:#666666;" text-anchor="middle" transform="translate(0,0)" y="190" opacity="1">0</text><text x="99" style="color:#666666;cursor:default;font-size:11px;fill:#666666;" text-anchor="middle" transform="translate(0,0)" y="190" opacity="1">20</text><text x="158" style="color:#666666;cursor:default;font-size:11px;fill:#666666;" text-anchor="middle" transform="translate(0,0)" y="190" opacity="1">40</text><text x="210.0390625" style="color:#666666;cursor:default;font-size:11px;fill:#666666;" text-anchor="middle" transform="translate(0,0)" y="190" opacity="1">60</text></g><text x="217" class="highcharts-credits" text-anchor="end" data-z-index="8" style="cursor:pointer;color:#999999;font-size:9px;fill:#999999;" y="245"></text><g class="highcharts-label highcharts-tooltip highcharts-color-0" style="white-space:nowrap;pointer-events:none;" data-z-index="8" transform="translate(73,-9999)" opacity="0" visibility="hidden"><path fill="none" class="highcharts-label-box highcharts-tooltip-box highcharts-shadow" d="M 3.5 0.5 L 81.5 0.5 C 84.5 0.5 84.5 0.5 84.5 3.5 L 84.5 44.5 C 84.5 47.5 84.5 47.5 81.5 47.5 L 3.5 47.5 C 0.5 47.5 0.5 47.5 0.5 44.5 L 0.5 30 L -5.5 24 L 0.5 18 L 0.5 3.5 C 0.5 0.5 0.5 0.5 3.5 0.5" stroke="#000000" stroke-opacity="0.049999999999999996" stroke-width="5" transform="translate(1, 1)"></path><path fill="none" class="highcharts-label-box highcharts-tooltip-box highcharts-shadow" d="M 3.5 0.5 L 81.5 0.5 C 84.5 0.5 84.5 0.5 84.5 3.5 L 84.5 44.5 C 84.5 47.5 84.5 47.5 81.5 47.5 L 3.5 47.5 C 0.5 47.5 0.5 47.5 0.5 44.5 L 0.5 30 L -5.5 24 L 0.5 18 L 0.5 3.5 C 0.5 0.5 0.5 0.5 3.5 0.5" stroke="#000000" stroke-opacity="0.09999999999999999" stroke-width="3" transform="translate(1, 1)"></path><path fill="none" class="highcharts-label-box highcharts-tooltip-box highcharts-shadow" d="M 3.5 0.5 L 81.5 0.5 C 84.5 0.5 84.5 0.5 84.5 3.5 L 84.5 44.5 C 84.5 47.5 84.5 47.5 81.5 47.5 L 3.5 47.5 C 0.5 47.5 0.5 47.5 0.5 44.5 L 0.5 30 L -5.5 24 L 0.5 18 L 0.5 3.5 C 0.5 0.5 0.5 0.5 3.5 0.5" stroke="#000000" stroke-opacity="0.15" stroke-width="1" transform="translate(1, 1)"></path><path fill="rgba(247,247,247,0.85)" class="highcharts-label-box highcharts-tooltip-box" d="M 3.5 0.5 L 81.5 0.5 C 84.5 0.5 84.5 0.5 84.5 3.5 L 84.5 44.5 C 84.5 47.5 84.5 47.5 81.5 47.5 L 3.5 47.5 C 0.5 47.5 0.5 47.5 0.5 44.5 L 0.5 30 L -5.5 24 L 0.5 18 L 0.5 3.5 C 0.5 0.5 0.5 0.5 3.5 0.5" stroke="rgb(220,53,69,0.6)" stroke-width="1"></path><text x="8" data-z-index="1" y="20" style="color:#333333;cursor:default;font-size:12px;fill:#333333;"><tspan style="font-size: 10px">D-1</tspan><tspan style="fill:rgb(220,53,69,0.6)" x="8" dy="15">●</tspan><tspan dx="0"> Vacant: </tspan><tspan style="font-weight:bold" dx="0">4</tspan></text></g></svg></div></div>
                            <script type="text/javascript">
                                
                            </script>
                        </div>
                    </div>

                    <div class="row chartrender">
                        <div class="col-md-12 hrgender">
                            <div id="hrgender_chart" data-highcharts-chart="8" style="overflow: hidden;"><div id="highcharts-4fszs9b-49" dir="ltr" class="highcharts-container " style="position: relative; overflow: hidden; width: 227px; height: 250px; text-align: left; line-height: normal; z-index: 0; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); user-select: none;"><svg version="1.1" class="highcharts-root" style="font-family:&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, Arial, Helvetica, sans-serif;font-size:12px;" xmlns="http://www.w3.org/2000/svg" width="227" height="250" viewBox="0 0 227 250"><desc>Created with Highcharts 8.2.2</desc><defs><clipPath id="highcharts-4fszs9b-50-"><rect x="0" y="0" width="126" height="147" fill="none"></rect></clipPath></defs><rect fill="transparent" class="highcharts-background" x="0" y="0" width="227" height="250" rx="0" ry="0"></rect><rect fill="none" class="highcharts-plot-background" x="40" y="45" width="147" height="126"></rect><g class="highcharts-pane-group" data-z-index="0"></g><g class="highcharts-grid highcharts-xaxis-grid" data-z-index="1"><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 40 63.5 L 187 63.5" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 40 81.5 L 187 81.5" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 40 99.5 L 187 99.5" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 40 117.5 L 187 117.5" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 40 135.5 L 187 135.5" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 40 153.5 L 187 153.5" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 40 171.5 L 187 171.5" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 40 45.5 L 187 45.5" opacity="1"></path></g><g class="highcharts-grid highcharts-xaxis-grid" data-z-index="1"><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 40 63.5 L 187 63.5" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 40 81.5 L 187 81.5" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 40 99.5 L 187 99.5" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 40 117.5 L 187 117.5" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 40 135.5 L 187 135.5" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 40 153.5 L 187 153.5" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 40 171.5 L 187 171.5" opacity="1"></path><path fill="none" data-z-index="1" class="highcharts-grid-line" d="M 40 45.5 L 187 45.5" opacity="1"></path></g><g class="highcharts-grid highcharts-yaxis-grid" data-z-index="1"><path fill="none" stroke="#e6e6e6" stroke-width="1" data-z-index="1" class="highcharts-grid-line" d="M 39.5 45 L 39.5 171" opacity="1"></path><path fill="none" stroke="#e6e6e6" stroke-width="1" data-z-index="1" class="highcharts-grid-line" d="M 113.5 45 L 113.5 171" opacity="1"></path><path fill="none" stroke="#e6e6e6" stroke-width="1" data-z-index="1" class="highcharts-grid-line" d="M 187.5 45 L 187.5 171" opacity="1"></path></g><rect fill="none" class="highcharts-plot-border" data-z-index="1" x="40" y="45" width="147" height="126"></rect><g class="highcharts-axis highcharts-xaxis" data-z-index="2"><path fill="none" class="highcharts-axis-line" stroke="#ccd6eb" stroke-width="1" data-z-index="7" d="M 39.5 45 L 39.5 171"></path></g><g class="highcharts-axis highcharts-xaxis" data-z-index="2"><path fill="none" class="highcharts-axis-line" stroke="#ccd6eb" stroke-width="1" data-z-index="7" d="M 187.5 45 L 187.5 171"></path></g><g class="highcharts-axis highcharts-yaxis" data-z-index="2"><path fill="none" class="highcharts-axis-line" data-z-index="7" d="M 40 171 L 187 171"></path></g><g class="highcharts-series-group" data-z-index="3"><g class="highcharts-series highcharts-series-0 highcharts-bar-series highcharts-color-0 highcharts-tracker" data-z-index="0.1" opacity="1" transform="translate(187,171) rotate(90) scale(-1,1) scale(1 1)" clip-path="url(#highcharts-4fszs9b-50-)" width="147" height="126"><rect x="112.5" y="0.5" width="9" height="0" fill="#17a2b8" stroke="#ffffff" stroke-width="1" opacity="1" class="highcharts-point highcharts-color-0"></rect><rect x="94.5" y="0.5" width="9" height="0" fill="#17a2b8" stroke="#ffffff" stroke-width="1" opacity="1" class="highcharts-point highcharts-color-0"></rect><rect x="76.5" y="74.5" width="9" height="36" fill="#17a2b8" stroke="#ffffff" stroke-width="1" opacity="1" class="highcharts-point highcharts-negative highcharts-color-0"></rect><rect x="58.5" y="74.5" width="9" height="39" fill="#17a2b8" stroke="#ffffff" stroke-width="1" opacity="1" class="highcharts-point highcharts-negative highcharts-color-0"></rect><rect x="40.5" y="74.5" width="9" height="36" fill="#17a2b8" stroke="#ffffff" stroke-width="1" opacity="1" class="highcharts-point highcharts-negative highcharts-color-0"></rect><rect x="22.5" y="74.5" width="9" height="36" fill="#17a2b8" stroke="#ffffff" stroke-width="1" opacity="1" class="highcharts-point highcharts-negative highcharts-color-0"></rect><rect x="4.5" y="74.5" width="9" height="64" fill="#17a2b8" stroke="#ffffff" stroke-width="1" opacity="1" class="highcharts-point highcharts-negative highcharts-color-0"></rect></g><g class="highcharts-markers highcharts-series-0 highcharts-bar-series highcharts-color-0" data-z-index="0.1" opacity="1" transform="translate(187,171) rotate(90) scale(-1,1) scale(1 1)" clip-path="none"></g><g class="highcharts-series highcharts-series-1 highcharts-bar-series highcharts-color-1 highcharts-tracker" data-z-index="0.1" opacity="1" transform="translate(187,171) rotate(90) scale(-1,1) scale(1 1)" clip-path="url(#highcharts-4fszs9b-50-)" width="147" height="126"><rect x="112.5" y="-0.5" width="9" height="75" fill="#d59442" stroke="#ffffff" stroke-width="1" opacity="1" class="highcharts-point highcharts-color-1"></rect><rect x="94.5" y="-0.5" width="9" height="75" fill="#d59442" stroke="#ffffff" stroke-width="1" opacity="1" class="highcharts-point highcharts-color-1"></rect><rect x="76.5" y="37.5" width="9" height="37" fill="#d59442" stroke="#ffffff" stroke-width="1" opacity="1" class="highcharts-point highcharts-color-1"></rect><rect x="58.5" y="40.5" width="9" height="34" fill="#d59442" stroke="#ffffff" stroke-width="1" opacity="1" class="highcharts-point highcharts-color-1"></rect><rect x="40.5" y="37.5" width="9" height="37" fill="#d59442" stroke="#ffffff" stroke-width="1" opacity="1" class="highcharts-point highcharts-color-1"></rect><rect x="22.5" y="37.5" width="9" height="37" fill="#d59442" stroke="#ffffff" stroke-width="1" opacity="1" class="highcharts-point highcharts-color-1"></rect><rect x="4.5" y="64.5" width="9" height="10" fill="#d59442" stroke="#ffffff" stroke-width="1" opacity="1" class="highcharts-point highcharts-color-1"></rect></g><g class="highcharts-markers highcharts-series-1 highcharts-bar-series highcharts-color-1" data-z-index="0.1" opacity="1" transform="translate(187,171) rotate(90) scale(-1,1) scale(1 1)" clip-path="none"></g></g><text x="10" text-anchor="start" class="highcharts-title" data-z-index="4" style="color:#707070;font-size:10px;font-weight:900;text-transform:none;text-decoration:underline;fill:#707070;" y="10"><tspan>Figure 6: Gender Balance</tspan></text><text x="114" text-anchor="middle" class="highcharts-subtitle" data-z-index="4" style="color:#666666;fill:#666666;" y="39"></text><text x="10" text-anchor="start" class="highcharts-caption" data-z-index="4" style="color:#666666;fill:#666666;" y="247"></text><g class="highcharts-legend" data-z-index="7" transform="translate(39,205)"><rect fill="none" class="highcharts-legend-box" rx="0" ry="0" x="0" y="0" width="149" height="30" visibility="visible"></rect><g data-z-index="1"><g><g class="highcharts-legend-item highcharts-bar-series highcharts-color-0 highcharts-series-0" data-z-index="1" transform="translate(8,3)"><text x="21" style="color:#333333;cursor:pointer;font-size:12px;font-weight:bold;fill:#333333;" text-anchor="start" data-z-index="2" y="15"><tspan>Female</tspan></text><rect x="2" y="4" width="12" height="12" fill="#17a2b8" rx="6" ry="6" class="highcharts-point" data-z-index="3"></rect></g><g class="highcharts-legend-item highcharts-bar-series highcharts-color-1 highcharts-series-1" data-z-index="1" transform="translate(91.953125,3)"><text x="21" y="15" style="color:#333333;cursor:pointer;font-size:12px;font-weight:bold;fill:#333333;" text-anchor="start" data-z-index="2"><tspan>Male</tspan></text><rect x="2" y="4" width="12" height="12" fill="#d59442" rx="6" ry="6" class="highcharts-point" data-z-index="3"></rect></g></g></g></g><g class="highcharts-axis-labels highcharts-xaxis-labels" data-z-index="7"><text x="25" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="end" transform="translate(0,0)" y="60" opacity="1">D-2</text><text x="25" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="end" transform="translate(0,0)" y="78" opacity="1">D-1</text><text x="25" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="end" transform="translate(0,0)" y="96" opacity="1">P-5</text><text x="25" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="end" transform="translate(0,0)" y="114" opacity="1">P-4</text><text x="25" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="end" transform="translate(0,0)" y="132" opacity="1">P-3</text><text x="25" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="end" transform="translate(0,0)" y="150" opacity="1">P-2</text><text x="25" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="end" transform="translate(0,0)" y="168" opacity="1">GS</text></g><g class="highcharts-axis-labels highcharts-xaxis-labels" data-z-index="7"><text x="202" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="start" transform="translate(0,0)" y="60" opacity="1">D-2</text><text x="202" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="start" transform="translate(0,0)" y="78" opacity="1">D-1</text><text x="202" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="start" transform="translate(0,0)" y="96" opacity="1">P-5</text><text x="202" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="start" transform="translate(0,0)" y="114" opacity="1">P-4</text><text x="202" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="start" transform="translate(0,0)" y="132" opacity="1">P-3</text><text x="202" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="start" transform="translate(0,0)" y="150" opacity="1">P-2</text><text x="202" style="color:#666666;cursor:default;font-size:0.2cm;fill:#666666;" text-anchor="start" transform="translate(0,0)" y="168" opacity="1">GS</text></g><g class="highcharts-axis-labels highcharts-yaxis-labels" data-z-index="7"><text x="40" style="color:#666666;cursor:default;font-size:11px;fill:#666666;" text-anchor="middle" transform="translate(0,0)" y="190" opacity="1">100%</text><text x="113.5" style="color:#666666;cursor:default;font-size:11px;fill:#666666;" text-anchor="middle" transform="translate(0,0)" y="190" opacity="1">0%</text><text x="187" style="color:#666666;cursor:default;font-size:11px;fill:#666666;" text-anchor="middle" transform="translate(0,0)" y="190" opacity="1">100%</text></g><text x="217" class="highcharts-credits" text-anchor="end" data-z-index="8" style="cursor:pointer;color:#999999;font-size:9px;fill:#999999;" y="245"></text></svg></div></div>
                            <script type="text/javascript">
                                
                            </script>
                        </div>
                    </div>
                </div>
                <p class="quote">Do the difficult things while they are easy and do the great things while they are small. — LAO TZU</p>
            </div>
            <!--<div class="pagebreak"></div>-->
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
                                <th class="center">Sub<br>Programme</th>
                                <th class="center">Months<br>Past Due</th>
                                <th class="left">Project<br>Manager</th>
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
                            <tr><td class="right">1.</td><td class="left">Environmental Conventions and Governance Branch</td>
                            <td class="left">01988</td><td class="left"> Environmental Treaties Programme – realizing synergies for biodiversity</td><td class="center">SP 4</td>
                            <td class="center" style="font-weight:500; color:green">&nbsp;</td>
                            <td class="left">diane.klaimi@un.org</td><td class="right">580,894</td>
                            <td><p class="projectlistinghealth" style="background-color:#28a745 !important">&nbsp;</p></td>
                            <td><p class="projectlistinghealth" style="background-color:#28a745 !important">&nbsp;</p></td>
                            <td><p class="projectlistinghealth" style="background-color:#28a745 !important">&nbsp;</p></td>
                            <td class="center">1</td><td class="center">5</td><td class="center">32 / 42 </td></tr><tr><td class="right">2.</td>
                            <td class="left">Environmental Conventions and Governance Branch</td><td class="left">GEF-5172</td>
                            <td class="left">Global support for the Entry into force of the Nagoya protocol on Acess and Benefit sharing </td>
                            <td class="center">SP 3</td><td class="center" style="color:#dc3545; font-weight: 500;">2</td><td class="left">emmanuel.adonsou@un.org</td>
                            <td class="right">279,244</td><td><p class="projectlistinghealth" style="background-color:#dc3545 !important">&nbsp;</p></td>
                            <td><p class="projectlistinghealth" style="background-color:#dc3545 !important">&nbsp;</p></td>
                            <td><p class="projectlistinghealth" style="background-color:#dc3545 !important">&nbsp;</p></td>
                            <td class="center">N/A</td><td class="center"></td><td class="center"> - </td></tr>
                            <tr><td class="right">3.</td><td class="left">Environmental Conventions and Governance Branch</td>
                            <td class="left">GEF-5454</td>
                            <td class="left">Ratification and Implementation of the Nagoya Protocol for the member countries of the Central African Forests Commission (COMIFAC)</td>
                            <td class="center">SP 4</td><td class="center" style="color:#dc3545; font-weight: 500;">31</td>
                            <td class="left">emmanuel.adonsou@un.org</td><td class="right">2,394,639</td>
                            <td><p class="projectlistinghealth" style="background-color:#dc3545 !important">&nbsp;</p></td>
                            <td><p class="projectlistinghealth" style="background-color:#28a745 !important">&nbsp;</p></td>
                            <td><p class="projectlistinghealth" style="background-color:#ffc107 !important">&nbsp;</p></td>
                            <td class="center">9</td><td class="center">8</td><td class="center">9 / 28 </td></tr><tr>
                            <td class="right">4.</td><td class="left">Environmental Conventions and Governance Branch</td>
                            <td class="left">GEF-5882</td><td class="left">Gabon - Implementation of National Strategy and Action Plan on Access to Genetic Resources and The Fair and Equitable Sharing of Benefits Accruing From Their Utilization</td>
                            <td class="center">SP 3</td><td class="center" style="color:#dc3545; font-weight: 500;">7</td>
                            <td class="left">emmanuel.adonsou@un.org</td><td class="right">813,200</td>
                            <td><p class="projectlistinghealth" style="background-color:#dc3545 !important">&nbsp;</p></td>
                            <td><p class="projectlistinghealth" style="background-color:#dc3545 !important">&nbsp;</p></td>
                            <td><p class="projectlistinghealth" style="background-color:#dc3545 !important">&nbsp;</p></td>
                            <td class="center">N/A</td><td class="center"></td><td class="center"> - </td></tr><tr><td class="right">5.</td>
                            <td class="left">Environmental Conventions and Governance Branch</td><td class="left">GEF-5688</td>
                            <td class="left">UNEP GEF Project for Sustainable Capacity Building for Effective Participation in the BCH</td>
                            <td class="center">SP 4</td><td class="center" style="color:#dc3545; font-weight: 500;">4</td><td class="left">rami.abdel-malik@un.org</td>
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
                            <tr><td>1.</td><td>D-1</td><td>D1 7562 DEPUTY DIRECTOR, PROGRAMME</td><td>30600601</td><td>Nairobi</td><td>EF</td><td>UNEP ODED DELC ODD</td><td>Office of the Deputy Director</td></tr><tr><td>2.</td><td>D-1</td><td>D1 1112 PRINCIPAL PROGRAMME MANAGEMENT O</td><td>30601055</td><td>Paris</td><td></td><td>UNEP ODED DELC OA</td><td>Ozone Action</td></tr><tr><td>3.</td><td>D-1</td><td>D1 5139 PRINCIPAL LEGAL OFFICER</td><td>30606085</td><td>Nairobi</td><td>XB</td><td>UNEP ODED DELC</td><td>Division of Environmental Law and Conventions</td></tr><tr><td>4.</td><td>D-1</td><td>D1 2583 PRINCIPAL COORDINATION OFFICER</td><td>30605149</td><td>Nairobi</td><td></td><td>UNEP ODED DELC</td><td>Division of Environmental Law and Conventions</td></tr><tr><td>5.</td><td>P-5</td><td>P5 6291 SENIOR PROGRAMME MANAGEMENT OFFI</td><td>30601221</td><td>Nairobi</td><td>RB</td><td>UNEP ODED DELC ODD IGU</td><td>International Governance Unit</td></tr><tr><td>6.</td><td>P-5</td><td>P5 6291 SENIOR PROGRAMME MANAGEMENT OFFI</td><td>31035134</td><td>Nairobi</td><td></td><td>UNEP ODED DELC ODD PDMU</td><td>Programme Delivery and Management Unit</td></tr><tr><td>7.</td><td>P-5</td><td>P5 6291 SENIOR PROGRAMME MANAGEMENT OFFI</td><td>30602589</td><td>Nairobi</td><td>EF</td><td>UNEP ODED DELC ODD PDMU</td><td>Programme Delivery and Management Unit</td></tr><tr><td>8.</td><td>P-4</td><td>P4 5283 PROGRAMME MANAGEMENT OFFICER</td><td>31005834</td><td>Nairobi</td><td></td><td>UNEP ODED DELC ODD MSU</td><td>MEAs Support and Cooperation Unit</td></tr><tr><td>9.</td><td>P-4</td><td>P4 5283 PROGRAMME MANAGEMENT OFFICER</td><td>30602817</td><td>Nairobi</td><td></td><td>UNEP ODED DELC ODD IGU</td><td>International Governance Unit</td></tr><tr><td>10.</td><td>P-4</td><td>P4 5283 PROGRAMME MANAGEMENT OFFICER</td><td>31014707</td><td>Nairobi</td><td></td><td>UNEP ODED DELC ODD MSU</td><td>MEAs Support and Cooperation Unit</td></tr><tr><td>11.</td><td>P-4</td><td>P4 3983 INFORMATION MANAGEMENT OFFICER</td><td>30605198</td><td>Nairobi</td><td></td><td>UNEP ODED DELC ODD PDMU</td><td>Programme Delivery and Management Unit</td></tr><tr><td>12.</td><td>P-4</td><td>P4 5283 PROGRAMME MANAGEMENT OFFICER</td><td>30607240</td><td>Nairobi</td><td></td><td>UNEP ODED DELC ODD</td><td>Office of the Deputy Director</td></tr><tr><td>13.</td><td>P-3</td><td>P3 4426 LEGAL OFFICER</td><td>30605177</td><td>Nairobi</td><td>EF</td><td>UNEP ODED DELC NLU</td><td>National Environmental Law Unit</td></tr><tr><td>14.</td><td>P-3</td><td>P3 8412 PROGRAMME MANAGEMENT OFFICER</td><td>31032107</td><td>Nairobi</td><td></td><td>UNEP ODED DELC</td><td>Division of Environmental Law and Conventions</td></tr><tr><td>15.</td><td>P-3</td><td>P3 8412 PROGRAMME MANAGEMENT OFFICER</td><td>30600802</td><td>Paris</td><td></td><td>UNEP ODED DELC OA</td><td>Ozone Action</td></tr><tr><td>16.</td><td>P-3</td><td>P3 8412 PROGRAMME MANAGEMENT OFFICER</td><td>30603369</td><td>Paris</td><td></td><td>UNEP ODED DELC OA</td><td>Ozone Action</td></tr><tr><td>17.</td><td>P-2</td><td>P2 7756 ASSOCIATE EXPERT</td><td>30607149</td><td>Nairobi</td><td></td><td>UNEP ODED DELC ODD MSU</td><td>MEAs Support and Cooperation Unit</td></tr><tr><td>18.</td><td>P-2</td><td>P2 1510 ASSOCIATE LEGAL OFFICER</td><td>31034301</td><td>Nairobi</td><td></td><td>UNEP ODED DELC ILU</td><td>International Environmental Law Unit</td></tr><tr><td>19.</td><td>P-2</td><td>P2 1584 ASSOCIATE PROGRAMME MANAGEMENT O</td><td>31005934</td><td>Nairobi</td><td></td><td>UNEP ODED DELC ODD MSU</td><td>MEAs Support and Cooperation Unit</td></tr><tr><td>20.</td><td>P-2</td><td>P2 1510 ASSOCIATE LEGAL OFFICER</td><td>31036543</td><td>Geneva</td><td>EF</td><td>UNEP ODED DELC</td><td>Division of Environmental Law and Conventions</td></tr><tr><td>21.</td><td>P-2</td><td>P2 1408 ASSOCIATE FINANCE AND BUDGET OFF</td><td>31021945</td><td>Paris</td><td></td><td>UNEP ODED DELC OA</td><td>Ozone Action</td></tr><tr><td>22.</td><td>P-2</td><td>P2 1584 ASSOCIATE PROGRAMME MANAGEMENT O</td><td>30605450</td><td>Nairobi</td><td></td><td>UNEP ODED DELC ODD IGU</td><td>International Governance Unit</td></tr><tr><td>23.</td><td>G-7</td><td>G7 1068 SENIOR ADMINISTRATIVE ASSISTANT</td><td>30600490</td><td>Nairobi</td><td>EF</td><td>UNEP ODED DELC ODD PDMU</td><td>Programme Delivery and Management Unit</td></tr><tr><td>24.</td><td>G-6</td><td>G6 5255 PROGRAMME MANAGEMENT ASSISTANT</td><td>30600811</td><td>Paris</td><td></td><td>UNEP ODED DELC OA</td><td>Ozone Action</td></tr><tr><td>25.</td><td>G-6</td><td>G6 1067 ADMINISTRATIVE ASSISTANT</td><td>30602403</td><td>Paris</td><td></td><td>UNEP ODED DELC OA</td><td>Ozone Action</td></tr><tr><td>26.</td><td>G-5</td><td>G5 5253 PROGRAMME MANAGEMENT ASSISTANT</td><td>30600608</td><td>Nairobi</td><td></td><td>UNEP ODED DELC ILU</td><td>International Environmental Law Unit</td></tr><tr><td>27.</td><td>G-5</td><td>G5 1066 ADMINISTRATIVE ASSISTANT</td><td>30602389</td><td>Nairobi</td><td></td><td>UNEP ODED DELC</td><td>Division of Environmental Law and Conventions</td></tr><tr><td>28.</td><td>G-5</td><td>G5 5253 PROGRAMME MANAGEMENT ASSISTANT</td><td>30602488</td><td>Nairobi</td><td></td><td>UNEP ODED DELC</td><td>Division of Environmental Law and Conventions</td></tr><tr><td>29.</td><td>G-4</td><td>G4 3346 FINANCE AND BUDGET ASSISTANT</td><td>31030442</td><td>Nairobi</td><td></td><td>UNEP ODED DELC ODD PDMU</td><td>Programme Delivery and Management Unit</td></tr><tr><td>30.</td><td>G-4</td><td>G4 3358 FINANCE ASSISTANT</td><td>31014586</td><td>Nairobi</td><td></td><td>UNEP ODED DELC ODD PDMU</td><td>Programme Delivery and Management Unit</td></tr>                        </tbody>
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
                            <tr><td>1.</td><td>D-2</td><td>D2 2843 DIRECTOR, PROGRAMME MANAGEMENT</td><td>30601226</td><td>Nairobi</td><td>Arnold KREILHUBER</td><td>UNEP ODED DELC</td><td>Division of Environmental Law and Conventions</td></tr><tr><td>2.</td><td>D-1</td><td>D1 5139 PRINCIPAL LEGAL OFFICER</td><td>31034984</td><td>Nairobi</td><td>Stadler TRENGOVE</td><td>UNEP ODED DELC</td><td>Division of Environmental Law and Conventions</td></tr><tr><td>3.</td><td>P-5</td><td>D1 7563 CHIEF OF BRANCH, PROGRAMME</td><td>30600509</td><td>Nairobi</td><td>Tita KORVENOJA</td><td>UNEP ODED DELC ODD MSU</td><td>MEAs Support and Cooperation Unit</td></tr><tr><td>4.</td><td>P-5</td><td>P5 6170 SENIOR ENVIRONMENTAL AFFAIRS OFF</td><td>30600796</td><td>Paris</td><td>James CURLIN</td><td>UNEP ODED DELC OA</td><td>Ozone Action</td></tr><tr><td>5.</td><td>P-5</td><td>P5 6236 SENIOR LEGAL OFFICER</td><td>30600602</td><td>Nairobi</td><td>Maria Socorro MANGUIAT</td><td>UNEP ODED DELC NLU</td><td>National Environmental Law Unit</td></tr><tr><td>6.</td><td>P-5</td><td>P5 6291 SENIOR PROGRAMME MANAGEMENT OFFI</td><td>30607210</td><td>Nairobi</td><td>Andrew David RAINE</td><td>UNEP ODED DELC ILU</td><td>International Environmental Law Unit</td></tr><tr><td>7.</td><td>P-4</td><td>P4 5283 PROGRAMME MANAGEMENT OFFICER</td><td>30600058</td><td>Nairobi</td><td>Sylvia BANKOBEZA</td><td>UNEP ODED DELC NLU</td><td>National Environmental Law Unit</td></tr><tr><td>8.</td><td>P-4</td><td>P4 5283 PROGRAMME MANAGEMENT OFFICER</td><td>30600800</td><td>Paris</td><td>Ezra CLARK</td><td>UNEP ODED DELC OA</td><td>Ozone Action</td></tr><tr><td>9.</td><td>P-4</td><td>P4 5283 PROGRAMME MANAGEMENT OFFICER</td><td>30600508</td><td>Nairobi</td><td>Diane KLAIMI</td><td>UNEP ODED DELC ODD MSU</td><td>MEAs Support and Cooperation Unit</td></tr><tr><td>10.</td><td>P-4</td><td>P4 4430 LEGAL OFFICER</td><td>30604906</td><td>Geneva</td><td>Eva DUER</td><td>UNEP ODED DELC</td><td>Division of Environmental Law and Conventions</td></tr><tr><td>11.</td><td>P-4</td><td>P3 3349 FINANCE AND BUDGET OFFICER</td><td>30600336</td><td>Nairobi</td><td>Fatma TWAHIR</td><td>UNEP ODED DELC ODD PDMU</td><td>Programme Delivery and Management Unit</td></tr><tr><td>12.</td><td>P-4</td><td>P4 5283 PROGRAMME MANAGEMENT OFFICER</td><td>30603363</td><td>Paris</td><td>Ayman ELTALOUNY</td><td>UNEP ODED DELC OA</td><td>Ozone Action</td></tr><tr><td>13.</td><td>P-4</td><td>P4 1103 ADMINISTRATIVE OFFICER</td><td>31008213</td><td>Nairobi</td><td>Reem AL-QAWAS</td><td>UNEP ODED DELC ODD PDMU</td><td>Programme Delivery and Management Unit</td></tr><tr><td>14.</td><td>P-4</td><td>P4 5283 PROGRAMME MANAGEMENT OFFICER</td><td>30600987</td><td>Nairobi</td><td>Balakrishna PISUPATI</td><td>UNEP ODED DELC ODD IGU</td><td>International Governance Unit</td></tr><tr><td>15.</td><td>P-4</td><td>P4 4430 LEGAL OFFICER</td><td>31003332</td><td>Nairobi</td><td>Soo Young HWANG</td><td>UNEP ODED DELC ILU</td><td>International Environmental Law Unit</td></tr><tr><td>16.</td><td>P-4</td><td>P4 5283 PROGRAMME MANAGEMENT OFFICER</td><td>31018747</td><td>Paris</td><td>Mikheil TUSHISHVILI</td><td>UNEP ODED DELC OA</td><td>Ozone Action</td></tr><tr><td>17.</td><td>P-4</td><td>P4 5283 PROGRAMME MANAGEMENT OFFICER</td><td>30604204</td><td>Paris</td><td>Halvart KOEPPEN</td><td>UNEP ODED DELC OA</td><td>Ozone Action</td></tr><tr><td>18.</td><td>P-4</td><td>P4 4430 LEGAL OFFICER</td><td>30602068</td><td>Nairobi</td><td>Afroditi SMAGADI</td><td>UNEP ODED DELC NLU</td><td>National Environmental Law Unit</td></tr><tr><td>19.</td><td>P-4</td><td>P4 5283 PROGRAMME MANAGEMENT OFFICER</td><td>31024364</td><td>Nairobi</td><td>Emmanuel ADONSOU</td><td>UNEP ODED DELC ODD MSU</td><td>MEAs Support and Cooperation Unit</td></tr><tr><td>20.</td><td>P-3</td><td>P3 8412 PROGRAMME MANAGEMENT OFFICER</td><td>30603346</td><td>Nairobi</td><td>Angela KARIUKI</td><td>UNEP ODED DELC ILU</td><td>International Environmental Law Unit</td></tr><tr><td>21.</td><td>P-3</td><td>P3 4426 LEGAL OFFICER</td><td>30600524</td><td>Nairobi</td><td>Allan MESO</td><td>UNEP ODED DELC ILU</td><td>International Environmental Law Unit</td></tr><tr><td>22.</td><td>P-3</td><td>P3 8412 PROGRAMME MANAGEMENT OFFICER</td><td>30603497</td><td>Nairobi</td><td>Hyun SUNG</td><td>UNEP ODED DELC ODD IGU</td><td>International Governance Unit</td></tr><tr><td>23.</td><td>P-3</td><td>P3 8412 PROGRAMME MANAGEMENT OFFICER</td><td>30605176</td><td>Nairobi</td><td>Haddy GUISSE</td><td>UNEP ODED DELC ODD MSU</td><td>MEAs Support and Cooperation Unit</td></tr><tr><td>24.</td><td>P-3</td><td>P3 6448 SPECIAL ASSISTANT, ADMINISTRATIO</td><td>30603304</td><td>Nairobi</td><td>Alvin John GACHIE</td><td>UNEP ODED DELC</td><td>Division of Environmental Law and Conventions</td></tr><tr><td>25.</td><td>P-3</td><td>P3 8412 PROGRAMME MANAGEMENT OFFICER</td><td>30600512</td><td>Nairobi</td><td>Rami ABDEL MALIK</td><td>UNEP ODED DELC ODD MSU</td><td>MEAs Support and Cooperation Unit</td></tr><tr><td>26.</td><td>P-2</td><td>P2 7756 ASSOCIATE EXPERT</td><td>31029589</td><td>Nairobi</td><td>Kazuhiko SERIU</td><td>UNEP ODED DELC ODD MSU</td><td>MEAs Support and Cooperation Unit</td></tr><tr><td>27.</td><td>P-2</td><td>P2 1584 ASSOCIATE PROGRAMME MANAGEMENT O</td><td>31032967</td><td>Nairobi</td><td>Dorris CHEPKOECH</td><td>UNEP ODED DELC ODD IGU</td><td>International Governance Unit</td></tr><tr><td>28.</td><td>P-2</td><td>P2 1483 ASSOCIATE INFORMATION OFFICER</td><td>30604905</td><td>Geneva</td><td>Kelly KABIRU</td><td>UNEP ODED DELC</td><td>Division of Environmental Law and Conventions</td></tr><tr><td>29.</td><td>P-2</td><td>P2 7756 ASSOCIATE EXPERT</td><td>31021712</td><td>Nairobi</td><td>Amanda Lilia CABREJO LE ROUX</td><td>UNEP ODED DELC ILU</td><td>International Environmental Law Unit</td></tr><tr><td>30.</td><td>G-7</td><td>G7 3348 SENIOR FINANCE AND BUDGET ASSIST</td><td>31019616</td><td>Paris</td><td>Nancy WACHIRA</td><td>UNEP ODED DELC OA</td><td>Ozone Action</td></tr><tr><td>31.</td><td>G-6</td><td>G6 5255 PROGRAMME MANAGEMENT ASSISTANT</td><td>30606161</td><td>Nairobi</td><td>Redempta KIBE</td><td>UNEP ODED DELC ODD MSU</td><td>MEAs Support and Cooperation Unit</td></tr><tr><td>32.</td><td>G-6</td><td>G6 4045 INFORMATION SYSTEMS ASSISTANT</td><td>30600516</td><td>Nairobi</td><td>Idah KAMAU</td><td>UNEP ODED DELC</td><td>Division of Environmental Law and Conventions</td></tr><tr><td>33.</td><td>G-6</td><td>G6 1067 ADMINISTRATIVE ASSISTANT</td><td>30600237</td><td>Paris</td><td>Josephine CHONA</td><td>UNEP ODED DELC OA</td><td>Ozone Action</td></tr><tr><td>34.</td><td>G-6</td><td>G7 5257 SENIOR PROGRAMME MANAGEMENT ASSI</td><td>30600618</td><td>Nairobi</td><td>Rose OGOT</td><td>UNEP ODED DELC</td><td>Division of Environmental Law and Conventions</td></tr><tr><td>35.</td><td>G-6</td><td>G6 6338 STAFF ASSISTANT</td><td>30601051</td><td>Paris</td><td>Yamou JAGNE</td><td>UNEP ODED DELC OA</td><td>Ozone Action</td></tr><tr><td>36.</td><td>G-6</td><td>G6 1067 ADMINISTRATIVE ASSISTANT</td><td>31035365</td><td>Nairobi</td><td>Judith ABWOGA</td><td>UNEP ODED DELC ODD PDMU</td><td>Programme Delivery and Management Unit</td></tr><tr><td>37.</td><td>G-6</td><td>G6 5512 PUBLIC INFORMATION ASSISTANT</td><td>30602951</td><td>Paris</td><td>Samira DE GOBERT</td><td>UNEP ODED DELC OA</td><td>Ozone Action</td></tr><tr><td>38.</td><td>G-6</td><td>G6 5255 PROGRAMME MANAGEMENT ASSISTANT</td><td>30606736</td><td>Nairobi</td><td>Harpreet PANESAR</td><td>UNEP ODED DELC ODD MSU</td><td>MEAs Support and Cooperation Unit</td></tr><tr><td>39.</td><td>G-6</td><td>G7 3348 SENIOR FINANCE AND BUDGET ASSIST</td><td>30601035</td><td>Nairobi</td><td>Catherine KARUIRU</td><td>UNEP ODED DELC ODD PDMU</td><td>Programme Delivery and Management Unit</td></tr><tr><td>40.</td><td>G-6</td><td>G6 5255 PROGRAMME MANAGEMENT ASSISTANT</td><td>30600723</td><td>Nairobi</td><td>Paxon MAINA</td><td>UNEP ODED DELC ODD PDMU</td><td>Programme Delivery and Management Unit</td></tr><tr><td>41.</td><td>G-6</td><td>G6 5255 PROGRAMME MANAGEMENT ASSISTANT</td><td>30600614</td><td>Nairobi</td><td>Emma MAUNGU</td><td>UNEP ODED DELC ILU</td><td>International Environmental Law Unit</td></tr><tr><td>42.</td><td>G-5</td><td>G5 7430 FINANCE AND BUDGET ASSISTANT</td><td>30600612</td><td>Nairobi</td><td>Joyce KARIUKI</td><td>UNEP ODED DELC ODD PDMU</td><td>Programme Delivery and Management Unit</td></tr><tr><td>43.</td><td>G-5</td><td>G6 5255 PROGRAMME MANAGEMENT ASSISTANT</td><td>30600803</td><td>Paris</td><td>Ruperto Segundo DE JESUS</td><td>UNEP ODED DELC OA</td><td>Ozone Action</td></tr><tr><td>44.</td><td>G-5</td><td>G5 5253 PROGRAMME MANAGEMENT ASSISTANT</td><td>30600491</td><td>Nairobi</td><td>Joyce MWEA</td><td>UNEP ODED DELC ODD PDMU</td><td>Programme Delivery and Management Unit</td></tr><tr><td>45.</td><td>G-5</td><td>G5 2941 DOCUMENTS MANAGEMENT ASSISTANT</td><td>30600806</td><td>Paris</td><td>Mugure KIBE</td><td>UNEP ODED DELC OA</td><td>Ozone Action</td></tr><tr><td>46.</td><td>G-5</td><td>G6 5255 PROGRAMME MANAGEMENT ASSISTANT</td><td>30606160</td><td>Nairobi</td><td>Florence BAGUI</td><td>UNEP ODED DELC ODD MSU</td><td>MEAs Support and Cooperation Unit</td></tr><tr><td>47.</td><td>G-5</td><td>G6 5255 PROGRAMME MANAGEMENT ASSISTANT</td><td>30601228</td><td>Nairobi</td><td>Dorothy OBUYA</td><td>UNEP ODED DELC ODD MSU</td><td>MEAs Support and Cooperation Unit</td></tr><tr><td>48.</td><td>G-5</td><td>G5 5253 PROGRAMME MANAGEMENT ASSISTANT</td><td>30603492</td><td>Paris</td><td>Jemal PURLIYEVA</td><td>UNEP ODED DELC OA</td><td>Ozone Action</td></tr><tr><td>49.</td><td>G-5</td><td>G7 5257 SENIOR PROGRAMME MANAGEMENT ASSI</td><td>30600705</td><td>Nairobi</td><td>Sarah MUCHIRI</td><td>UNEP ODED DELC ODD</td><td>Office of the Deputy Director</td></tr><tr><td>50.</td><td>G-5</td><td>G5 7430 FINANCE AND BUDGET ASSISTANT</td><td>30603070</td><td>Nairobi</td><td>Anne NYORO</td><td>UNEP ODED DELC ODD PDMU</td><td>Programme Delivery and Management Unit</td></tr><tr><td>51.</td><td>G-5</td><td>G5 5253 PROGRAMME MANAGEMENT ASSISTANT</td><td>30600610</td><td>Nairobi</td><td>Rose OLOO</td><td>UNEP ODED DELC NLU</td><td>National Environmental Law Unit</td></tr><tr><td>52.</td><td>G-5</td><td>G5 5253 PROGRAMME MANAGEMENT ASSISTANT</td><td>30600500</td><td>Nairobi</td><td>Annabelle OLUM</td><td>UNEP ODED DELC ODD IGU</td><td>International Governance Unit</td></tr><tr><td>53.</td><td>G-5</td><td>G5 5253 PROGRAMME MANAGEMENT ASSISTANT</td><td>30601089</td><td>Nairobi</td><td>Lucy MWAKIO</td><td>UNEP ODED DELC NLU</td><td>National Environmental Law Unit</td></tr><tr><td>54.</td><td>G-5</td><td>G5 5253 PROGRAMME MANAGEMENT ASSISTANT</td><td>30601234</td><td>Nairobi</td><td>Rosemary MWASYA</td><td>UNEP ODED DELC ODD IGU</td><td>International Governance Unit</td></tr><tr><td>55.</td><td>G-5</td><td>G6 5255 PROGRAMME MANAGEMENT ASSISTANT</td><td>30600519</td><td>Nairobi</td><td>James OKONJI</td><td>UNEP ODED DELC ODD PDMU</td><td>Programme Delivery and Management Unit</td></tr><tr><td>56.</td><td>G-5</td><td>G5 5253 PROGRAMME MANAGEMENT ASSISTANT</td><td>30601120</td><td>Nairobi</td><td>Masline OKETCH</td><td>UNEP ODED DELC NLU</td><td>National Environmental Law Unit</td></tr><tr><td>57.</td><td>G-5</td><td>G5 5253 PROGRAMME MANAGEMENT ASSISTANT</td><td>30600611</td><td>Nairobi</td><td>Jennifer CHEGE</td><td>UNEP ODED DELC ILU</td><td>International Environmental Law Unit</td></tr><tr><td>58.</td><td>G-5</td><td>G5 5253 PROGRAMME MANAGEMENT ASSISTANT</td><td>31028692</td><td>Nairobi</td><td>Catherine ABUTO</td><td>UNEP ODED DELC ODD PDMU</td><td>Programme Delivery and Management Unit</td></tr><tr><td>59.</td><td>G-4</td><td>G5 5253 PROGRAMME MANAGEMENT ASSISTANT</td><td>30600613</td><td>Nairobi</td><td>Lillian ONYANGO</td><td>UNEP ODED DELC</td><td>Division of Environmental Law and Conventions</td></tr><tr><td>60.</td><td>G-4</td><td>G4 6675 TEAM ASSISTANT</td><td>30600725</td><td>Nairobi</td><td>John GATHUKU</td><td>UNEP ODED DELC ODD</td><td>Office of the Deputy Director</td></tr>                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- End of .toprint -->
    </div>
';

$pageheader = '<div class="row reportbody section1">
	        	<img src="assets/images/' . strtolower(str_replace(' ', '_', $division)) . '.png" style="">
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
    $annex1table .= '<td class="center"><img src="assets/images/' . gethealthimage($processed_divisiondata[$division]["projectlisting"][$i]['system_rating']) . ' " style="vertical-align:middle; height:12px;"></td>';
    $annex1table .= '<td class="center"><img src="assets/images/' . gethealthimage($processed_divisiondata[$division]["projectlisting"][$i]['management_rating']) . ' " style="vertical-align:middle; height:12px;"></td>';
    $annex1table .= '<td class="center"><img src="assets/images/' . gethealthimage($processed_divisiondata[$division]["projectlisting"][$i]['final_rating']) . ' " style="vertical-align:middle; height:12px;"></td>';
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
                        <tbody>' . $annex1table . '
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
                        <tbody>' . $annex2table . '
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
                        <tbody>' . $annex3table . '
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
]);

$mpdf->SetProtection(array('print'));
$mpdf->SetTitle("pimsreport");
$mpdf->SetAuthor("UNEP - PIMS+");
$mpdf->SetDisplayMode('fullpage');


$mpdf->Bookmark('Dashboard');
$mpdf->WriteHTML($dash);
$mpdf->AddPage();

$mpdf->SetJS("
Highcharts.chart('budgetsize_chart', {
                                    credits: {
                                        text: ''
                                    },
                                    chart: {
                                        backgroundColor: 'transparent',
                                        type: 'column',
                                        height: 200
                                    },
                                    title: {
                                        text: 'Figure 1: Projects by Rating',
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
                                        categories: [\"Red\", \"Yellow\", \"Green\"],
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
                                        headerFormat: '<span style=\"font-size:10px\">{point.key}</span><table>',
                                        pointFormat: '<tr><td style=\"color:{series.color};padding:0\">{series.name}: </td>' +
                                            '<td style=\"padding:0\"><b>USD {point.y:.1f} M</b></td></tr>',
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
                                            borderWidth: 0,
                                            colorByPoint: true,
                                            colors: ['#dc3545','#ffc107', '#28a745']
                                        }
                                    },
                                    series: [{
                                        name: 'Rating',
                                        data: [363,13,3],
                                        showInLegend: false

                                    }]
                                });
                                /*
                                Highcharts.chart('budgetsize_chart', {
                                    chart: {
                                        type: 'scatter',
                                        zoomType: 'xy',
                                        height: 200
                                    },
                                    credits: {
                                        enabled: false
                                    },
                                    title: {
                                        text: 'Figure 4: Project Rank vs Budget',
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
                                        min: 0,
                                        max: 3,
                                        categories: [\"Not Reported\",\"Red\", \"Yellow\", \"Green\"],
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
                                        borderWidth: 1,
                                        enabled: false
                                    },
                                    plotOptions: {
                                        scatter: {
                                            marker: {
                                                radius: 3,
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
                                                pointFormat: 'Rating: {point.x}, Budget size: {point.y}'
                                            }
                                        }
                                    },
                                    series: [{
                                        name: 'Red',
                                        color: 'rgba(220, 53, 69, .9)',
                                        data: [[0,75970],[0,279244],[0,813200],[0,305000],[0,85000],[0,150000],[0,150000],[0,150000],[0,109200],[0,109200],[0,90010],[0,134400],[0,134400],[0,134400],[0,36000],[0,31515],[0,10000],[0,47640],[0,90000],[0,45000],[0,15000],[0,114240],[0,104530],[0,145000],[0,146314],[0,145000],[0,59999],[0,155000],[0,230000],[0,33500],[0,79108],[0,60000],[0,60000],[0,43686],[0,60000],[0,60000],[0,59369],[0,165095],[0,78867],[0,78867],[0,100950],[0,150000],[0,78173],[0,78173],[0,100061],[0,85000],[0,123000],[0,70000],[0,70000],[0,85000],[0,76700],[0,65000],[0,145000],[0,161650],[0,80850],[0,60000],[0,176980],[0,72812],[0,133794],[0,40127],[0,0],[0,130962],[0,52000],[0,60000],[0,60000],[0,55000],[0,139532],[0,77900],[0,145000],[0,60000],[0,79989],[0,85000],[0,50000],[0,1579000],[0,1104000],[0,217600],[0,1173000],[0,275000],[0,107720],[0,60000],[0,100000],[0,35000],[0,13000],[0,85000],[0,50000],[0,15817],[0,134333],[0,159333],[0,95375],[0,149540],[0,164540],[0,53962],[0,30000],[0,30000],[0,25000],[0,226305],[0,0],[0,27223],[0,145000],[0,20000],[0,130850],[0,142400],[0,180000],[0,55000],[0,0],[0,33999],[0,60000],[0,17674],[0,46419],[0,60000],[0,60000],[0,14917],[0,60000],[0,0],[0,60000],[0,60000],[0,55000],[0,141500],[0,145000],[0,185000],[0,25000],[0,30000],[0,23000],[0,60000],[0,62482],[0,69010],[0,145000],[0,130000],[0,46700],[0,99000],[0,15822360],[0,17847806],[0,15800574],[0,82350],[0,15000],[0,33000],[0,25627],[0,96000],[0,87400],[0,144879],[0,53434],[0,3991249],[0,60000],[0,53918],[0,100000],[0,171000],[0,43268],[0,75000],[0,60000],[0,60000],[0,180800],[0,344640],[0,140253],[0,20927],[0,60000],[0,242455],[0,221340],[0,136115],[0,60000],[0,149999],[0,112667],[0,112667],[0,151667],[0,151667],[0,97250],[0,60000],[0,60000],[0,85000],[1.2,10900],[0,75000],[1.4,105320],[1.4,105320],[0,31680],[0,115830],[0,75891],[0,120911],[0,113625],[0,60000],[0,60000],[0,60000],[0,60000],[0,85000],[0,85213],[0,131000],[0,103900],[0,145700],[0,160700],[0,60000],[0,46504],[0,85000],[0,60000],[0,60000],[0,60000],[0,168000],[0,110900],[0,133670],[0,337556],[0,60000],[0,60000],[0,85000],[0,85000],[0,120590],[0,145677],[0,175677],[0,60000],[0,55000],[0,30000],[0,66733],[0,66733],[0,74500],[0,140500],[0,69334],[0,46709],[0,71977],[0,65000],[0,30000],[0,60000],[0,60000],[0,59000],[0,80800],[0,80800],[0,150000],[0,0],[0,32753],[0,76000],[0,60000],[0,46500],[0,60000],[0,60000],[0,85000],[0,15000],[0,52500],[0,35000],[0,71046],[0,35000],[0,60000],[0,40000],[0,221250],[0,64828],[0,130000],[0,12663421],[0,38000],[0,60000],[0,85000],[0,8010],[0,60000],[0,60000],[0,200000],[0,200000],[0,200000],[0,25000],[0,15000],[0,80000],[0,90000],[0,24000],[0,60000],[0,60000],[0,60000],[0,85000],[0,36266],[0,181133],[0,64471],[0,42000],[0,60000],[0,145000],[0,65000],[0,42000],[0,40000],[0,60000],[0,60000],[0,40000],[0,30000],[0,55000],[0,60000],[0,60000],[0.8,14850],[1.2,55766],[0,152101],[0,319689],[0,60000],[0,95000],[0,25000],[0,23000],[0,85800],[0,85800],[0,95000],[0,109824],[0,60000],[0,60000],[0,26000],[0,174600],[0,75100],[0,20000],[0,40000],[0,67068],[0,60000],[0,60000],[0,13150],[0,0],[0,60000],[0,60000],[0,60000],[0,65000],[0,64274],[0,145225],[0,135666],[0,81463],[0,28000],[0,40000],[0,145860],[0,145860],[0,15000],[0,73333],[0,73333],[0,49179],[0,55000],[0,60000],[0,60000],[0,283000],[0,115693],[0,53255],[0,40000],[0,20000],[0,60000],[0,90200],[0,145448],[0,185632],[0,85000],[0,85000],[0,60000],[0,60000],[0,50000],[0,26500],[0,60000],[0,60000],[0,85000],[0,28950],[0,76000],[0,60000],[0,60000],[0,9200],[0,15184],[0,40500],[0,30000],[0,25000],[0,85000],[0,78000],[0,60000],[0,22000],[0,60000],[0,60000],[0,60000],[0,118976],[0,110251],[0,169999],[0,20000],[0,38635],[0,40000],[0,65520],[0,65520],[0,85000],[0,148242],[0,148242]]
                                    }, {
                                        name: 'Yellow',
                                        color: 'rgba(255, 193, 7, .9)',
                                        data: [[1.8,0],[1.8,2394638],[1.8,3298537],[1.8,52500],[2,490500],[1.6,926130],[1.6,74329],[1.6,238641],[1.8,547200],[1.6,292912],[1.8,17779],[1.6,232639],[2.2,60000]]
                                    }, {
                                        name: 'Green',
                                        color: 'rgba(40, 167, 69, .9)',
                                        data: [[3,580893],[2.8,4860703],[3,65000]]
                                    }]
                                });*/


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
                                        headerFormat: '<span style=\"font-size:10px\">{point.key}</span><table>',
                                        pointFormat: '<tr><td style=\"color:{series.color};padding:0\">{series.name}: </td>' +
                                            '<td style=\"padding:0\"><b>USD {point.y:.1f} M</b></td></tr>',
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
                                            114.8645443,
                                            64.58747268,
                                            50.27707162],
                                        showInLegend: false
                                    }]
                                });

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
                                    text: '56%',
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
                                        ['Time Taken', 56.229250787181 ],
                                        {
                                            name: '',
                                            y: 43.770749212819,
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
                                    text: '86%',
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
                                        ['Time Taken', 86 ],
                                        {
                                            name: '',
                                            y: 14,
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
                                    text: '15%',
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
                                        ['Time Taken', 15 ],
                                        {
                                            name: '',
                                            y: 85,
                                            dataLabels: {
                                                enabled: false
                                            }
                                        }
                                    ]
                                }]
                            });

                             Highcharts.chart('groupingbyage_chart', {
                                    colors: ['#0077b6'],
                                    credits: {
                                        text: ''
                                    },
                                    chart: {
                                        backgroundColor: 'transparent',
                                        type: 'bar',
                                        height: 200
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
                                        headerFormat: '<span style=\"font-size:10px\">{point.key}</span><table>',
                                        pointFormat: '<tr><td style=\"color:{series.color};padding:0\">{series.name}: </td>' +
                                            '<td style=\"padding:0\"><b>USD {point.y:.1f} M</b></td></tr>',
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
                                                    return (this.y!=0)?this.y:\"\";
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
                                        data: [69,252,56,2],
                                        color: '#4e90e0',
                                        showInLegend: false

                                    }]
                                });

                                Highcharts.chart('projectsbysubprogramme_chart', {
                                    colors: ['#0077b6'],
                                    credits: {
                                        text: ''
                                    },
                                    chart: {
                                        backgroundColor: 'transparent',
                                        type: 'column',
                                        height: 250
                                    },
                                    title: {
                                        text: 'Figure 4: Projects by Sub-Programme',
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
                                        categories: [\"SP 3\",\"SP 4\",\"SP 5\"],
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
                                        headerFormat: '<span style=\"font-size:10px\">{point.key}</span><table>',
                                        pointFormat: '<tr><td style=\"color:{series.color};padding:0\">{series.name}: </td>' +
                                            '<td style=\"padding:0\"><b>USD {point.y:.1f} M</b></td></tr>',
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
                                        data: [2,6,371],
                                        showInLegend: false

                                    }]
                                });

                                Highcharts.chart('hrfilled_chart', {
                                    colors: ['rgb(220,53,69,0.6)','rgb(104,135,83,0.6)'],
                                    /*colors: ['rgb(220,53,69,0.7)','rgb(112,112,112,0.7)'],*/
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
                                        categories: [\"D-2\",\"D-1\",\"P-5\",\"P-4\",\"P-3\",\"P-2\",\"GS\"],
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
                                        data: [0,4,3,5,4,6,8],
                                        showInLegend: true
                                    }, {
                                        name: 'Filled',
                                        data: [1,1,4,13,6,4,31],
                                        showInLegend: true
                                    }]
                                });

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
                                        categories: [\"D-2\",\"D-1\",\"P-5\",\"P-4\",\"P-3\",\"P-2\",\"GS\"],
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
                                        categories: [\"D-2\",\"D-1\",\"P-5\",\"P-4\",\"P-3\",\"P-2\",\"GS\"],
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
                                        data: [0,0,-50,-53.84615384615385,-50,-50,-87.09677419354838]                                    },{
                                        name: 'Male',
                                        data: [100,100,50,46.15384615384615,50,50,12.903225806451612]                                    }]
                                });
');
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
$mpdf->Output('docs/' . $filename, 'I');
echo 'Done!';
