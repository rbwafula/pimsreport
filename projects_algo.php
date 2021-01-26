<?php
function getdaysbetween($start, $end)
{
    $startDate = strtotime($start);

    if ($end) {
        $endDate = strtotime($end);
    } else {
        $endDate = time();
    }

    $datediff = $endDate - $startDate;
    $days_duration = round($datediff / (60 * 60 * 24));
    return $days_duration;
}
function gethealthcolor($health) {
	$color = '#dc3545 !important'; //red
    if ($health >= 2.5) {
        $color = '#28a745 !important'; //green
    } elseif ($health >= 1.5) {
        $color = '#ffc107 !important'; // yellow
    }
    return $color;
}

$projectlisting = array();

for ($i=0; $i<10; $i++){
	$project_id = 'PJ-'.($i+1);
	$project_office = ($i < 5) ? 'OfficeA' : 'OfficeB';
	$project_fund_amount = 1111;
	$project_prodoc_amount = 1111;
	$project_duration = 18;
	$project_rank = 13;
	$project_healthrating = 1.6;

	/* Simulating budget classes for the respective project */
	$budgetclass_count = mt_rand(2,7);
	$budgetclass_names = array();
	$budgetclass_amounts = array();
	for ($j=0; $j<$budgetclass_count; $j++) {
		// Variables needed for budget classes
		$budgetclass_names[] = 'Budget '.($j+1);
		$budgetclass_amounts[] = mt_rand(20000,1500000);
	}

	/* Simulating populating outputs */
	$outputs_activities = array();
	$outputs_count=0;
	$activities_count=0;

	$outputs_samplecount = mt_rand(2,5); // for test
	for ($k=0; $k<$outputs_samplecount; $k++) {
		$output_id = ($k+1);
		$output_title = 'Test '.$output_id.' - A sample output';
		
		/* Simulating populating activities for specific output */
		$activities_list = array();
		$output_fundamount = 0;

		$activities_samplecount = mt_rand(2,5);
		for ($l=0; $l<$activities_samplecount; $l++) {
			// Variables needed for each activity
			$activity_id = $l+1;
			$activity_title = 'Test '.$activity_id.' - A sample activity';
			$teststart = strtotime("01 Jan 2017");
			$testend = strtotime("31 December 2025");
			$activity_startdate = date("d-m-Y", mt_rand($teststart,time()));
			$activity_enddate = date("d-m-Y", mt_rand(time(),$testend));
			$activity_staff = 'a.nother@un.org';
			$activity_office = 'Developers Division';
			$activity_branch = 'Nighthawk Branch';
			$activity_status = 'Status';
			$activity_tracking_text = 'Something';
			$activity_tracking_color = mt_rand(0,1);
			$activity_funded = mt_rand(0,1);
			$activity_fundamount = mt_rand(10000,250000);

			// Fill in activity data
			$activities_list[] = [
				"id" => $activity_id,
				"title" => $activity_title,
				"startdate" => $activity_startdate,
				"enddate" => $activity_enddate,
				"duration" => getdaysbetween($activity_startdate, $activity_enddate),
				"elapsed" => getdaysbetween($activity_startdate, date("d-m-Y",time())),
				"staff" => $activity_staff,
				"office" => $activity_office,
				"branch" => $activity_branch,
				"status" => $activity_status,
				"trackingtext" => $activity_tracking_text,
				"trackingcolor" => $activity_tracking_color,
				"funded" => $activity_funded,
				"fundamount" => $activity_fundamount
			];
			$output_fundamount += $activity_fundamount;
			$activities_count++;
		}

		// Fill in output data
		$outputs_activities[] = [
			"id" => $output_id,
			"title" => $output_title,
			"activities" => $activities_list,
			"fundamount" => $output_fundamount
		];
		$outputs_count++;
	}


	$projectlisting[$project_id] = [
		"id" => $project_id,
		"title" => "Example ".$project_id.' - Example project title', 
		"office" => $project_office,
		"fundamount" => $project_fund_amount,
		"prodocamount" => $project_prodoc_amount,
		"outputscount" => $outputs_count,
		"activitiescount" => $activities_count,
		"duration" => $project_duration,
		"rank" => $project_rank,
		"healthrating" => $project_healthrating,
		"healthcolor" => gethealthcolor($project_healthrating),
		"budgetclass" => array("names" => $budgetclass_names, "amounts" => $budgetclass_amounts),
		"outputs_activities" => $outputs_activities
	];
}

/*echo '<pre>';
var_dump($projectlisting);
echo '</pre>';*/
?>