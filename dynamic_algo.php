<?php
$url = 'https://staging1.unep.org/simon/pims-stg/modules/main/pims3-api/final_data';

$activities_url = 'https://staging1.unep.org/simon/pims-stg/modules/main/pims3-api/div_activitycount_data';

$processed_divisiondata = array();

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
$colorcode = array('name' => ['red', 'yellow', 'green'],
    'color' => ['dc3545', 'ffc107', '28a745'],
    'scale' => ['poor', 'fair', 'good']);


function gethealthcolor($health)
{
    $color = 'red';

    if ($health >= 2.5) {
        $color = 'green';

    } elseif ($health >= 1.5) {
        $color = 'yellow';
    }

    return $color;
}

function getHealthRating($a, $b)
{
    $color = '#' . $b['color'][2] . ' !important';
    if ($health >= 2.5) {
        $color = '#' . $b['color'][1] . ' !important';
    } elseif ($health >= 1.5) {
       $color = '#' . $b['color'][0] . ' !important';
    }

    return $color;
}
/*unction getHealthName($a, $b)
{
    if ($a > 0 && $a <= 0.3) {
        $name = ucwords($b['scale'][0]);
    } else if ($a > 0.3 && $a <= 0.7) {
        $name = ucwords($b['scale'][1]);
    } else if ($a > 0.7) {
        $name = ucwords($b['scale'][2]);
    }
    return $name;
}*/

//$healthrating_color = getHealthRating($healthrating, $colorcode);
//$healthrating_name = getHealthName($healthrating, $colorcode);



// CURL GET DATA FROM URL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
$data = curl_exec($ch);
curl_close($ch);

// CURL GET DATA FROM ACTIVITIES URL
$ch = curl_init($activities_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
$a_data = curl_exec($ch);
curl_close($ch);

// DATA COMES IN AS STRING, CONVERT TO JSON OBJECT
$division_data = json_decode($data);

// DATA COMES IN AS STRING, CONVERT TO JSON OBJECT
$activities_data = json_decode($a_data);
// var_dump($activities_data);

// CALCULATE THE TOTAL METRICS
$total_projects = 0;
$total_consumable_budget = 0;
$total_consumed_budget = 0;
$total_percentage_budget_utilized = 0;
$total_percentage_activities_completed = 0;
$total_reported_projects = 0;
$total_project_days = 0;
$total_project_health = 0;

$total_count_projects_budget_between0_1 = 0;
$total_count_projects_budget_between1_2 = 0;
$total_count_projects_budget_between2_5 = 0;
$total_count_projects_budget_between5_10 = 0;
$total_count_projects_budget_more10 = 0;

$total_amount_projects_budget_between0_1 = 0;
$total_amount_projects_budget_between1_2 = 0;
$total_amount_projects_budget_between2_5 = 0;
$total_amount_projects_budget_between5_10 = 0;
$total_amount_projects_budget_more10 = 0;

$total_past_due_projects = 0;
$total_projects_expiringin6 = 0;

$total_system_rating = 0;
$total_manager_rating = 0;
$total_final_rating = 0;

$total_count_projects_duration_between0_1 = 0;
$total_count_projects_duration_between1_2 = 0;
$total_count_projects_duration_between2_5 = 0;
$total_count_projects_duration_between5_10 = 0;
$total_count_projects_duration_more10 = 0;

$total_projects_duration = 0;

$total_count_projects_age_between0_1 = 0;
$total_count_projects_age_between1_2 = 0;
$total_count_projects_age_between2_5 = 0;
$total_count_projects_age_between5_10 = 0;
$total_count_projects_age_more10 = 0;
$total_projects_age = 0;

$total_activities = 0;
$total_completed_activities = 0;
$total_outputs = 0;
$overall_percentage_completed_activitiesA = 0;

foreach ($activities_data as $key => $value) {
    $total_activities += $value->total_activities;
    $total_completed_activities += $value->completed_activities;
    $total_outputs += $value->total_outputs;
}
$overall_percentage_completed_activitiesA = round($total_completed_activities / $total_activities, 2) * 100;

foreach ($division_data as $key => $value) {
    $startDate = strtotime($value->StartDate);
    $endDate = strtotime($value->EndDate);
    $datediff = $endDate - $startDate;
    $project_days_duration = round($datediff / (60 * 60 * 24));
    $total_project_days += $project_days_duration;
    $project_days_age = getdaysbetween($startDate, null);

    $total_projects_duration += $project_days_duration;
    $total_projects_age += $project_days_age;

    $total_projects += 1;
    $total_consumable_budget += $value->consumable_budget;
    $total_consumed_budget += $value->consumed_budget;
    $total_percentage_budget_utilized += $value->percentage_budget_utilized;
    $total_percentage_activities_completed += $value->percentage_activities_completed;



    if ($project_days_duration > 3648) {
        $total_count_projects_duration_more10 += 1;

    } elseif ($project_days_duration > 1820) {
        $total_count_projects_duration_between5_10 += 1;

    } elseif ($project_days_duration > 730) {
        $total_count_projects_duration_between2_5 += 1;

    } elseif ($project_days_duration > 365) {
        $total_count_projects_duration_between1_2 += 1;

    } else {
        $total_count_projects_duration_between0_1 += 1;
    }

    if ($project_days_age > 3648) {
        $total_count_projects_age_more10 += 1;

    } elseif ($project_days_age > 1820) {
        $total_count_projects_age_between5_10 += 1;

    } elseif ($project_days_age > 730) {
        $total_count_projects_age_between2_5 += 1;

    } elseif ($project_days_age > 365) {
        $total_count_projects_age_between1_2 += 1;

    } else {
        $total_count_projects_age_between0_1 += 1;
    }

    if ($value->consumable_budget > 10000000) {
        $total_count_projects_budget_more10 += 1;
        $total_amount_projects_budget_more10 += $value->consumable_budget;

    } elseif ($value->consumable_budget > 5000000) {
        $total_count_projects_budget_between5_10 += 1;
        $total_amount_projects_budget_between5_10 += $value->consumable_budget;

    } elseif ($value->consumable_budget > 2000000) {
        $total_count_projects_budget_between2_5 += 1;
        $total_amount_projects_budget_between2_5 += $value->consumable_budget;

    } elseif ($value->consumable_budget > 1000000) {
        $total_count_projects_budget_between1_2 += 1;
        $total_amount_projects_budget_between1_2 += $value->consumable_budget;

    } else {
        $total_count_projects_budget_between0_1 += 1;
        $total_amount_projects_budget_between0_1 += $value->consumable_budget;

    }

    if ($value->final_rating) {
        $total_reported_projects += 1;
        $total_project_health += $value->final_rating;
    } else {
        $total_project_health += 0;
    }

    if ($value->days_past_due > 0) {
        $total_past_due_projects += 1;
    } else {
        if ($value->days_past_due > -174) {
            $total_projects_expiringin6 += 1;
        }
    }

    if ($value->manager_rating) {
        $total_manager_rating += $value->manager_rating;
    } else {}

    if ($value->system_rating) {
        $total_system_rating += $value->system_rating;
    } else {}

    if ($value->final_rating) {
        $total_final_rating += $value->final_rating;
    } else {}

}
$total_percentage_projects_budget_between0_1 = round($total_count_projects_budget_between0_1 / $total_projects, 2) * 100;
$total_percentage_projects_budget_between1_2 = round($total_count_projects_budget_between1_2 / $total_projects, 2) * 100;
$total_percentage_projects_budget_between2_5 = round($total_count_projects_budget_between2_5 / $total_projects, 2) * 100;
$total_percentage_projects_budget_between5_10 = round($total_count_projects_budget_between5_10 / $total_projects, 2) * 100;
$total_percentage_projects_budget_more10 = round($total_count_projects_budget_more10 / $total_projects, 2) * 100;

$total_reporting_percentage = round(($total_reported_projects / $total_projects), 1);
$overall_average_consumable = round($total_consumable_budget / $total_projects, 2);
$overall_average_project_days_duration = round($total_project_days / $total_projects);
$overall_average_project_years_duration = round($overall_average_project_days_duration / 365.25, 1);

$overall_average_project_health = round($total_project_health / $total_projects, 1);

$total_average_percentage_budget_utilized = round($total_percentage_budget_utilized / $total_projects, 1) * 100;

$total_average_system_rating = round($total_system_rating / $total_projects, 1);
$total_average_manager_rating = round($total_manager_rating / $total_projects, 1);
$total_average_final_rating = round($total_final_rating / $total_projects, 1);

$overall_pctg_duration_used = round( $total_projects_age / $total_projects_duration , 2)*100;


//DECLARE THE DIVISIONS ARRAY TO STORE UNIQUES DIVISIONS
$unique_divisions = [];

//DECLARE THE BRANCHES ARRAY TO STORE UNIQUES BRANCHES
$unique_branches = [];

//USE DATA FROM API TO FEED THE UNIQUE DIVISIONS ARRAY
foreach ($division_data as $key => $value) {
    if (!in_array($value->managing_division, $unique_divisions)) {
        $unique_divisions[] = $value->managing_division;
    }
}

//USE DATA FROM API TO FEED THE UNIQUE BRANCHES ARRAY
foreach ($division_data as $key => $value) {
    if (!in_array($value->managing_branch, $unique_branches)) {
        $unique_branches[] = $value->managing_branch;
    }
}

//REMOVE ANY NULL ITEMS FROM DIVISIONS ARRAY
array_filter($unique_divisions, 'strlen');
foreach ($unique_divisions as $i => $row) {
    if ($row === null) {
        unset($unique_divisions[$i]);
    }
}

//REMOVE ANY NULL ITEMS FROM BRANCHES ARRAY
array_filter($unique_branches, 'strlen');
foreach ($unique_branches as $i => $row) {
    if ($row === null) {
        unset($unique_branches[$i]);
    }
}

// FOR EACH UNIQUE DIVISION CREATE THE REPORT AND MAIL TO THE RELEVANT FOCAL POINTS

//echo '<br />---------------------DIVISIONAL DATA--------------------<br /><br />';
foreach ($unique_divisions as $dkey => $dvalue) {
//CALCULATE DIVISIONAL METRICS

//calculate number of projects under this division
    $d_projects = 0;
    $d_consumable_budget = 0;
    $d_consumed_budget = 0;
    $d_percentage_budget_utilized = 0;
    $d_percentage_activities = 0;
    $d_percentage_activities_completed = 0;
    $d_reported_projects = 0;
    $d_project_days = 0;
    $d_project_health = 0;

    $d_count_projects_budget_between0_1 = 0;
    $d_count_projects_budget_between1_2 = 0;
    $d_count_projects_budget_between2_5 = 0;
    $d_count_projects_budget_between5_10 = 0;
    $d_count_projects_budget_more10 = 0;

    $d_amount_projects_budget_between0_1 = 0;
    $d_amount_projects_budget_between1_2 = 0;
    $d_amount_projects_budget_between2_5 = 0;
    $d_amount_projects_budget_between5_10 = 0;
    $d_amount_projects_budget_more10 = 0;

    $d_past_due_projects = 0;
    $d_projects_expiringin6 = 0;

    $d_total_system_rating = 0;
    $d_total_manager_rating = 0;
    $d_total_final_rating = 0;

    $d_count_projects_duration_between0_1 = 0;
    $d_count_projects_duration_between1_2 = 0;
    $d_count_projects_duration_between2_5 = 0;
    $d_count_projects_duration_between5_10 = 0;
    $d_count_projects_duration_more10 = 0;
    $d_projects_duration = 0;

    $d_count_projects_age_between0_1 = 0;
    $d_count_projects_age_between1_2 = 0;
    $d_count_projects_age_between2_5 = 0;
    $d_count_projects_age_between5_10 = 0;
    $d_count_projects_age_more10 = 0;
    $d_projects_age = 0;

    $d_activities = 0;
    $d_completed_activities = 0;
    $d_outputs = 0;
    $d_percentage_completed_activities = 0;
    $d_percentage_completed_activitiesA = 0;

    foreach ($activities_data as $key => $value) {
        if ($value->managing_division == $dvalue) {
            $d_activities += $value->total_activities;
            $d_completed_activities += $value->completed_activities;
            $d_outputs += $value->total_outputs;
        }
    }
    $d_percentage_completed_activitiesA = round($d_completed_activities / $d_activities, 2) * 100;

    foreach ($division_data as $key => $value) {
        if ($value->managing_division == $dvalue) {

            $startDate = strtotime($value->StartDate);
            $endDate = strtotime($value->EndDate);
            $datediff = $endDate - $startDate;
            $project_days_duration = round($datediff / (60 * 60 * 24));
            $d_project_days += $project_days_duration;
            $project_days_age = getdaysbetween($startDate, null);

            $d_projects_duration += $project_days_duration;

            $d_projects += 1;
            $d_consumable_budget += $value->consumable_budget;
            $d_consumed_budget += $value->consumed_budget;
            $d_percentage_budget_utilized += round($value->percentage_budget_utilized, 2);
            $d_percentage_activities_completed += $value->percentage_activities_completed;

            $d_projects_age += $project_days_age;

            if ($project_days_duration > 3648) {
                $d_count_projects_duration_more10 += 1;

            } elseif ($project_days_duration > 1820) {
                $d_count_projects_duration_between5_10 += 1;

            } elseif ($project_days_duration > 730) {
                $d_count_projects_duration_between2_5 += 1;

            } elseif ($project_days_duration > 365) {
                $d_count_projects_duration_between1_2 += 1;

            } else {
                $d_count_projects_duration_between0_1 += 1;
            }

            if ($project_days_age > 3648) {
                $d_count_projects_age_more10 += 1;

            } elseif ($project_days_age > 1820) {
                $d_count_projects_age_between5_10 += 1;

            } elseif ($project_days_age > 730) {
                $d_count_projects_age_between2_5 += 1;

            } elseif ($project_days_age > 365) {
                $d_count_projects_age_between1_2 += 1;

            } else {
                $d_count_projects_age_between0_1 += 1;
            }

            if ($value->final_rating) {
                $d_reported_projects += 1;
                $d_project_health += $value->final_rating;
            } else {
                $d_project_health += 0;
            }

            if ($value->consumable_budget > 10000000) {
                $d_count_projects_budget_more10 += 1;
                $d_amount_projects_budget_more10 += $value->consumable_budget;

            } elseif ($value->consumable_budget > 5000000) {
                $d_count_projects_budget_between5_10 += 1;
                $d_amount_projects_budget_between5_10 += $value->consumable_budget;

            } elseif ($value->consumable_budget > 2000000) {
                $d_count_projects_budget_between2_5 += 1;
                $d_amount_projects_budget_between2_5 += $value->consumable_budget;

            } elseif ($value->consumable_budget > 1000000) {
                $d_count_projects_budget_between1_2 += 1;
                $d_amount_projects_budget_between1_2 += $value->consumable_budget;

            } else {
                $d_count_projects_budget_between0_1 += 1;
                $d_amount_projects_budget_between0_1 += $value->consumable_budget;
            }

            if ($value->final_rating) {
                $d_reported_projects += 1;
                $d_project_health += $value->final_rating;
            } else {
                $d_project_health += 0;
            }

            if ($value->days_past_due > 0) {
                $d_past_due_projects += 1;
            } else {
                if ($value->days_past_due > -174) {
                    $d_projects_expiringin6 += 1;
                }
            }

            if ($value->manager_rating) {
                $d_total_manager_rating += $value->manager_rating;
            } else {}

            if ($value->system_rating) {
                $d_total_system_rating += $value->system_rating;
            } else {}

            if ($value->final_rating) {
                $d_total_final_rating += $value->final_rating;
            } else {}

        }
    }
    $d_percentage_projects_budget_between0_1 = round($d_count_projects_budget_between0_1 / $d_projects, 2) * 100;
    $d_percentage_projects_budget_between1_2 = round($d_count_projects_budget_between1_2 / $d_projects, 2) * 100;
    $d_percentage_projects_budget_between2_5 = round($d_count_projects_budget_between2_5 / $d_projects, 2) * 100;
    $d_percentage_projects_budget_between5_10 = round($d_count_projects_budget_between5_10 / $d_projects, 2) * 100;
    $d_percentage_projects_budget_more10 = round($d_count_projects_budget_more10 / $d_projects, 2) * 100;

    $d_percentage_consumable_budget = round($d_consumable_budget / $total_consumable_budget, 2) * 100;
    $d_percentage_consumed_budget = round($d_consumed_budget / $total_consumed_budget, 2) * 100;

    $d_reporting_percentage = round(($d_reported_projects / $d_projects) * 100, 1);
    $d_average_consumable = round($d_consumable_budget / $d_projects, 2);
    $d_average_project_days_duration = round($d_project_days / $d_projects);
    $d_average_project_years_duration = round($d_average_project_days_duration / 365.25, 1);

    $d_average_project_health = round($d_project_health / $d_projects, 1);

    $d_average_percentage_budget_utilized = round($d_percentage_budget_utilized / $d_projects, 1);

    $d_total_average_system_rating = round($d_total_system_rating / $total_projects, 1);
    $d_total_average_manager_rating = round($d_total_manager_rating / $total_projects, 1);
    $d_total_average_final_rating = round($d_total_final_rating / $total_projects, 1);

    $d_percentage_of_budget_utilized = round($d_consumed_budget / $d_consumable_budget, 2) * 100;

    $d_overall_pctg_duration_used = round( $d_projects_age / $d_projects_duration , 2)*100;

    // display the division name its and number of projects
    /*echo '<br />_____________' . $dvalue . ' Division/Office ______________<br />';
    echo $d_projects . ' projects<br />' . $d_consumable_budget . ' consumable budget <br />';
    echo $d_past_due_projects . ' projects past due <br />';
    echo $d_projects_expiringin6 . ' projects expiring in 6 months<br />';
    echo $d_percentage_consumable_budget . '% of total UNEP consumable budget<br />';
    echo $d_average_consumable . ' Project Size (average of consumable budget)<br />';

    echo $d_percentage_projects_budget_more10 . '% (' . $d_count_projects_budget_more10 . ') Projects above 10M (sum ' . $d_amount_projects_budget_more10 . ') <br />';
    echo $d_percentage_projects_budget_between5_10 . '% (' . $d_count_projects_budget_between5_10 . ') Projects between 5&10M (sum ' . $d_amount_projects_budget_between5_10 . ')  <br />';
    echo $d_percentage_projects_budget_between2_5 . '% (' . $d_count_projects_budget_between2_5 . ') Projects between 2&5M (sum ' . $d_amount_projects_budget_between2_5 . ')  <br />';
    echo $d_percentage_projects_budget_between1_2 . '% (' . $d_count_projects_budget_between1_2 . ') Projects between 1&2M (sum ' . $d_amount_projects_budget_between1_2 . ')  <br />';
    echo $d_percentage_projects_budget_between0_1 . '% (' . $d_count_projects_budget_between0_1 . ') Projects under 1M (sum ' . $d_amount_projects_budget_between0_1 . ')  <br />';

    echo $d_count_projects_duration_more10 . ' Projects whose duration is more than 10 years<br />';
    echo $d_count_projects_duration_between5_10 . ' Projects whose duration is between 5 and 10 years  <br />';
    echo $d_count_projects_duration_between2_5 . ' Projects whose duration is between 2 and 5 years <br />';
    echo $d_count_projects_duration_between1_2 . ' Projects whose duration is between 1 and 2 years <br />';
    echo $d_count_projects_duration_between0_1 . ' Projects whose duration is under 1 year  <br />';

    echo $d_count_projects_age_more10 . ' Projects whose age is more than 10 years<br />';
    echo $d_count_projects_age_between5_10 . ' Projects whose age is between 5 and 10 years  <br />';
    echo $d_count_projects_age_between2_5 . ' Projects whose age is between 2 and 5 years <br />';
    echo $d_count_projects_age_between1_2 . ' Projects whose age is between 1 and 2 years <br />';
    echo $d_count_projects_age_between0_1 . ' Projects whose age is under 1 year  <br />';

    echo $d_consumed_budget . ' total consumed budget <br />';

    echo $d_percentage_of_budget_utilized . ' % of office budget utilized<br />';

    echo $d_percentage_consumed_budget . '% of total UNEP consumed budget<br />';

    echo $d_average_percentage_budget_utilized . ' average percentage utilized budget <br />';
    echo $d_activities . ' activities<br />';
    echo $d_completed_activities . ' completed activities<br />';
    echo $d_percentage_completed_activitiesA . '% activities completed<br />';
    echo $d_outputs . ' outputs<br />';

    echo $d_average_project_days_duration . 'days/ ' . $d_average_project_years_duration . ' year(s) average project duration<br />';

    echo $d_average_project_health . '(' . gethealthcolor($d_average_project_health) . ') Average Project health <br />';

    echo $d_total_average_system_rating . ' Average system rating<br />';
    echo $d_total_average_manager_rating . ' Average manager rating<br />';
    echo $d_total_average_final_rating . ' Average final rating<br />';

    echo $d_reported_projects . ' projects reported<br />';

    echo $d_reporting_percentage . '% projects reported<br />';*/

    $pctbudgetutilized = ($d_consumed_budget*100 / $d_consumable_budget);

    $processed_divisiondata[$dvalue] = array(
        "entity" => $dvalue,
        "totalprojects" => $d_projects,
        "totalactivities" => $d_activities,
        "totaloutputs" => $d_outputs,
        "healthcolor" => gethealthcolor($d_average_project_health),
        "consumablebudget" => $d_consumable_budget,
        "pastdueprojects" => $d_past_due_projects,
        "in6monthexpiry" => $d_projects_expiringin6,
        "pctconsumablebudget" => $d_percentage_consumable_budget,
        "avgconsumablebudget" => $d_average_consumable,
        "totalconsumedbudget" => $d_consumed_budget,
        "avgbudgetutilized" => $d_average_percentage_budget_utilized,
        "pctbudgetutilized" => $pctbudgetutilized,
        "avgactivitiescompleted" => $d_percentage_activities_completed,
        "avgtimetaken" => $d_average_project_days_duration,
        "avgprojecthealth"=> $d_average_project_health,
        "avgsystemrating" => $d_total_average_system_rating,
        "avgmanagerrating" => $d_total_average_manager_rating,
        "avgfinalrating" => $d_total_average_final_rating,
        "reportedprojects" => $d_reported_projects,
        "reportedprojectspct" => $d_reporting_percentage,
        "pctgdurationused" => $d_overall_pctg_duration_used
    );



    ?>



	<?php

//SWITCHING TO DIVISIONAL CALCULATIONS

}
/*
echo '<br />---------------------BRANCH DATA-------------------- <br /><br />';

foreach ($unique_branches as $dkey => $dvalue) {
//CALCULATE BRANCH METRICS

//calculate number of projects under this branch
    $b_projects = 0;
    $b_consumable_budget = 0;
    $b_consumed_budget = 0;
    $b_percentage_budget_utilized = 0;
    $b_percentage_activities = 0;
    $b_percentage_activities_completed = 0;
    $b_reporteb_projects = 0;
    $b_project_days = 0;
    $b_project_health = 0;

    $b_count_projects_budget_between0_1 = 0;
    $b_count_projects_budget_between1_2 = 0;
    $b_count_projects_budget_between2_5 = 0;
    $b_count_projects_budget_between5_10 = 0;
    $b_count_projects_budget_more10 = 0;

    $b_amount_projects_budget_between0_1 = 0;
    $b_amount_projects_budget_between1_2 = 0;
    $b_amount_projects_budget_between2_5 = 0;
    $b_amount_projects_budget_between5_10 = 0;
    $b_amount_projects_budget_more10 = 0;

    $b_past_due_projects = 0;
    $b_projects_expiringin6 = 0;

    $b_total_system_rating = 0;
    $b_total_manager_rating = 0;
    $b_total_final_rating = 0;

    $b_count_projects_duration_between0_1 = 0;
    $b_count_projects_duration_between1_2 = 0;
    $b_count_projects_duration_between2_5 = 0;
    $b_count_projects_duration_between5_10 = 0;
    $b_count_projects_duration_more10 = 0;

    $b_count_projects_age_between0_1 = 0;
    $b_count_projects_age_between1_2 = 0;
    $b_count_projects_age_between2_5 = 0;
    $b_count_projects_age_between5_10 = 0;
    $b_count_projects_age_more10 = 0;

    foreach ($division_data as $key => $value) {
        if ($value->managing_branch == $dvalue) {
            $b_projects += 1;

            $startDate = strtotime($value->StartDate);
            $endDate = strtotime($value->EndDate);
            $datediff = $endDate - $startDate;
            $project_days_duration = round($datediff / (60 * 60 * 24));
            $b_project_days += $project_days_duration;
            $project_days_age = getdaysbetween($startDate, null);

            $b_consumable_budget += $value->consumable_budget;
            $b_consumed_budget += $value->consumed_budget;
            $b_percentage_budget_utilized += round($value->percentage_budget_utilized, 2);
            $b_percentage_activities_completed += $value->percentage_activities_completed;

            if ($project_days_duration > 3648) {
                $b_count_projects_duration_more10 += 1;

            } elseif ($project_days_duration > 1820) {
                $b_count_projects_duration_between5_10 += 1;

            } elseif ($project_days_duration > 730) {
                $b_count_projects_duration_between2_5 += 1;

            } elseif ($project_days_duration > 365) {
                $b_count_projects_duration_between1_2 += 1;

            } else {
                $b_count_projects_duration_between0_1 += 1;
            }

            if ($project_days_age > 3648) {
                $b_count_projects_age_more10 += 1;

            } elseif ($project_days_age > 1820) {
                $b_count_projects_age_between5_10 += 1;

            } elseif ($project_days_age > 730) {
                $b_count_projects_age_between2_5 += 1;

            } elseif ($project_days_age > 365) {
                $b_count_projects_age_between1_2 += 1;

            } else {
                $b_count_projects_age_between0_1 += 1;
            }

            if ($value->final_rating) {
                $b_reporteb_projects += 1;
                $b_project_health += $value->final_rating;
            } else {
                $b_project_health += 0;
            }

            if ($value->consumable_budget > 10000000) {
                $b_count_projects_budget_more10 += 1;
                $b_amount_projects_budget_more10 += $value->consumable_budget;

            } elseif ($value->consumable_budget > 5000000) {
                $b_count_projects_budget_between5_10 += 1;
                $b_amount_projects_budget_between5_10 += $value->consumable_budget;

            } elseif ($value->consumable_budget > 2000000) {
                $b_count_projects_budget_between2_5 += 1;
                $b_amount_projects_budget_between2_5 += $value->consumable_budget;

            } elseif ($value->consumable_budget > 1000000) {
                $b_count_projects_budget_between1_2 += 1;
                $b_amount_projects_budget_between1_2 += $value->consumable_budget;

            } else {
                $b_count_projects_budget_between0_1 += 1;
                $b_amount_projects_budget_between0_1 += $value->consumable_budget;
            }

            if ($value->final_rating) {
                $b_reporteb_projects += 1;
                $b_project_health += $value->final_rating;
            } else {
                $b_project_health += 0;
            }

            if ($value->days_past_due > 0) {
                $b_past_due_projects += 1;
            } else {
                if ($value->days_past_due > -174) {
                    $b_projects_expiringin6 += 1;
                }
            }

            if ($value->manager_rating) {
                $b_total_manager_rating += $value->manager_rating;
            } else {}

            if ($value->system_rating) {
                $b_total_system_rating += $value->system_rating;
            } else {}

            if ($value->final_rating) {
                $b_total_final_rating += $value->final_rating;
            } else {}

        }
    }
    $b_percentage_projects_budget_between0_1 = round($b_count_projects_budget_between0_1 / $b_projects, 2) * 100;
    $b_percentage_projects_budget_between1_2 = round($b_count_projects_budget_between1_2 / $b_projects, 2) * 100;
    $b_percentage_projects_budget_between2_5 = round($b_count_projects_budget_between2_5 / $b_projects, 2) * 100;
    $b_percentage_projects_budget_between5_10 = round($b_count_projects_budget_between5_10 / $b_projects, 2) * 100;
    $b_percentage_projects_budget_more10 = round($b_count_projects_budget_more10 / $b_projects, 2) * 100;

    $b_percentage_consumable_budget = round($b_consumable_budget / $total_consumable_budget, 2) * 100;
    $b_percentage_consumed_budget = round($b_consumed_budget / $total_consumed_budget, 2) * 100;
    $b_reporting_percentage = round(($b_reporteb_projects / $b_projects) * 100, 1);
    $b_average_consumable = round($b_consumable_budget / $b_projects, 2);
    $b_average_project_days_duration = round($b_project_days / $b_projects);
    $b_average_project_years_duration = round($b_average_project_days_duration / 365.25, 1);

    $b_average_project_health = round($b_project_health / $b_projects, 1);

    $b_average_percentage_budget_utilized = round($b_percentage_budget_utilized / $b_projects, 1);

    $b_total_average_system_rating = round($b_total_system_rating / $total_projects, 1);
    $b_total_average_manager_rating = round($b_total_manager_rating / $total_projects, 1);
    $b_total_average_final_rating = round($b_total_final_rating / $total_projects, 1);

    // display the branch name its and number of projects
    echo '<br />_____________' . $dvalue . ' Branch ______________<br />';
    echo $b_projects . ' projects<br />' . $b_consumable_budget . ' consumable budget <br />';
    echo $b_past_due_projects . ' projects past due <br />';
    echo $b_projects_expiringin6 . ' projects expiring in 6 months<br />';
    echo $b_percentage_consumable_budget . '% of total UNEP consumable budget<br />';
    echo $b_average_consumable . ' Project Size (average of consumable budget)<br />';

    echo $b_percentage_projects_budget_more10 . '% (' . $b_count_projects_budget_more10 . ') Projects above 10M (sum ' . $b_amount_projects_budget_more10 . ') <br />';
    echo $b_percentage_projects_budget_between5_10 . '% (' . $b_count_projects_budget_between5_10 . ') Projects between 5&10M (sum ' . $b_amount_projects_budget_between5_10 . ')  <br />';
    echo $b_percentage_projects_budget_between2_5 . '% (' . $b_count_projects_budget_between2_5 . ') Projects between 2&5M (sum ' . $b_amount_projects_budget_between2_5 . ')  <br />';
    echo $b_percentage_projects_budget_between1_2 . '% (' . $b_count_projects_budget_between1_2 . ') Projects between 1&2M (sum ' . $b_amount_projects_budget_between1_2 . ')  <br />';
    echo $b_percentage_projects_budget_between0_1 . '% (' . $b_count_projects_budget_between0_1 . ') Projects under 1M (sum ' . $b_amount_projects_budget_between0_1 . ')  <br />';

    echo $b_count_projects_duration_more10 . ' Projects whose duration is more than 10 years<br />';
    echo $b_count_projects_duration_between5_10 . ' Projects whose duration is between 5 and 10 years  <br />';
    echo $b_count_projects_duration_between2_5 . ' Projects whose duration is between 2 and 5 years <br />';
    echo $b_count_projects_duration_between1_2 . ' Projects whose duration is between 1 and 2 years <br />';
    echo $b_count_projects_duration_between0_1 . ' Projects whose duration is under 1 year  <br />';

    echo $b_count_projects_age_more10 . ' Projects whose age is more than 10 years<br />';
    echo $b_count_projects_age_between5_10 . ' Projects whose age is between 5 and 10 years  <br />';
    echo $b_count_projects_age_between2_5 . ' Projects whose age is between 2 and 5 years <br />';
    echo $b_count_projects_age_between1_2 . ' Projects whose age is between 1 and 2 years <br />';
    echo $b_count_projects_age_between0_1 . ' Projects whose age is under 1 year  <br />';

    echo $b_consumed_budget . ' total consumed budget <br />';
    echo $b_percentage_consumed_budget . '% of total UNEP consumed budget<br />';

    echo $b_average_percentage_budget_utilized . ' average percentage utilized budget <br />';
    echo $b_percentage_activities_completed . ' activities completed<br />';
    echo $b_average_project_days_duration . 'days/ ' . $b_average_project_years_duration . ' year(s) average project duration<br />';

    echo $b_average_project_health . '(' . gethealthcolor($b_average_project_health) . ') Average Project health <br />';

    echo $b_total_average_system_rating . ' Average system rating<br />';
    echo $b_total_average_manager_rating . ' Average manager rating<br />';
    echo $b_total_average_final_rating . ' Average final rating<br />';

    echo $b_reporteb_projects . ' projects reported<br />';

    echo $b_reporting_percentage . '% projects reported<br />';

    ?>



	<?php

//THE REPORT CREATION AND MAILING FUNCTIONS COME HERE - BRANCHES
}

echo '<br /><br />_______________TOTAL VALUES______________<br />';
echo $total_projects . ' total projects<br />';
echo $total_past_due_projects . ' total projects past due <br />';
echo $total_projects_expiringin6 . ' total projects expiring in 6 months<br />';
echo $total_consumable_budget . ' total consumable budget <br />';
echo $overall_average_consumable . ' Overall Project Size (average of consumable budget)<br />';

echo $total_percentage_projects_budget_more10 . '% (' . $total_count_projects_budget_more10 . ') Projects above 10M (' . $total_amount_projects_budget_more10 . ')  <br />';
echo $total_percentage_projects_budget_between5_10 . '% (' . $total_count_projects_budget_between5_10 . ') Projects between 5&10M ( sum ' . $total_amount_projects_budget_between5_10 . ')  <br />';
echo $total_percentage_projects_budget_between2_5 . '% (' . $total_count_projects_budget_between2_5 . ') Projects between 2&5M ( sum ' . $total_amount_projects_budget_between2_5 . ')  <br />';
echo $total_percentage_projects_budget_between1_2 . '% (' . $total_count_projects_budget_between1_2 . ') Projects between 1&2M (sum ' . $total_amount_projects_budget_between1_2 . ')  <br />';
echo $total_percentage_projects_budget_between0_1 . '% (' . $total_count_projects_budget_between0_1 . ') Projects under 1M (sum ' . $total_amount_projects_budget_between0_1 . ')  <br />';

echo $total_count_projects_duration_more10 . ' Projects whose duration is more than 10 years<br />';
echo $total_count_projects_duration_between5_10 . ' Projects whose duration is between 5 and 10 years  <br />';
echo $total_count_projects_duration_between2_5 . ' Projects whose duration is between 2 and 5 years <br />';
echo $total_count_projects_duration_between1_2 . ' Projects whose duration is between 1 and 2 years <br />';
echo $total_count_projects_duration_between0_1 . ' Projects whose duration is under 1 year  <br />';

echo $total_count_projects_age_more10 . ' Projects whose age is more than 10 years<br />';
echo $total_count_projects_age_between5_10 . ' Projects whose age is between 5 and 10 years  <br />';
echo $total_count_projects_age_between2_5 . ' Projects whose age is between 2 and 5 years <br />';
echo $total_count_projects_age_between1_2 . ' Projects whose age is between 1 and 2 years <br />';
echo $total_count_projects_age_between0_1 . ' Projects whose age is under 1 year  <br />';

echo $total_consumed_budget . ' total consumed budget <br />';
echo $total_average_percentage_budget_utilized . ' Overall average percentage utilized budget <br />';
echo $total_activities . ' total activities<br />';
echo $total_completed_activities . ' total completed activities<br />';
echo $overall_percentage_completed_activitiesA . '% overall activities completed<br />';
echo $total_outputs . ' total outputs<br />';

echo $overall_average_project_days_duration . 'days / ' . $overall_average_project_years_duration . ' year(s) overall average project duration<br />';

echo $overall_average_project_health . '(' . gethealthcolor($overall_average_project_health) . ') Overall Average Project health <br />';

echo $total_average_system_rating . ' Average system rating<br />';
echo $total_average_manager_rating . ' Average manager rating<br />';
echo $total_average_final_rating . ' Average final rating<br />';

echo $total_reported_projects . ' total projects reported<br />';

echo $total_reporting_percentage . '% projects reported<br />';


*/

?>