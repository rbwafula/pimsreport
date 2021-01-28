<?php
//Projects by same manager

//Individual project summary

//overallbudget

//projdoc table

//coding block

//1 project
//top-right : budget->table
// ->top left: project title sand descrt
// no. of outputs
// no of activi
// duration
// rank in org
// project rating
// budget
// balance
// total
// outputs in danger
// activities behind

// bottom table - what are the outputs
//BASIC FUNCTIONS
function getdataobjectfromurl($url)
{
    // CURL GET DATA FROM URL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $data = curl_exec($ch);
    curl_close($ch);
    // DATA COMES IN AS STRING, CONVERT TO JSON OBJECT
    return json_decode($data);
}
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
function gethealthcolor($health)
{
    $color = '#dc3545 !important'; //red
    if ($health >= 2.5) {
        $color = '#28a745 !important'; //green
    } elseif ($health >= 1.5) {
        $color = '#ffc107 !important'; // yellow
    }
    return $color;
}
function gethealthimage($health)
{
    $color = 'red.png'; //red
    if ($health >= 2.5) {
        $color = 'green.png'; //green
    } elseif ($health >= 1.5) {
        $color = 'yellow.png'; // yellow
    }
    return $color;
}
function sortByOrder($a, $b)
{
    return $a['order'] - $b['order'];
}
function filter_unique($array, $key)
{
    $temp_array = [];
    $unique_keys = [];
    foreach ($array as &$v) {
        // if (!isset($temp_array[$v[$key]])) {
        if (!in_array($v[$key], $unique_keys)) {
            $temp_array[$v[$key]] = &$v;
        }
    }
    // $array = array_values($temp_array);
    return $array;
}

//FETCH DATA -> CACHED/LIVE
$version = 'cached'; // live * Choose between: cached and live data here */
$cacheddata_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/assets/data/'; // localhost address and folder path to data folder
$livedata_link = 'https://staging1.unep.org/simon/pims-stg/modules/main/pims3-api/'; // live api
$page_link = ($version == 'cached') ? $cacheddata_link : $livedata_link;
$urlsuffix = ($version == 'cached') ? '.json' : '';

//$url = $page_link . 'final_data' . $urlsuffix;
$url = 'https://staging1.unep.org/simon/pims-stg/modules/main/pims3-api/final_data';
$activities_url = $page_link . 'div_practivitycount_data' . $urlsuffix;
$outputs_url = $page_link . 'div_activitycount_data' . $urlsuffix;
$hr_url = $page_link . 'officestaff_data' . $urlsuffix;
//$proj_activity_url = $page_link.'div_practivitycount_data'.$urlsuffix;
$budget_commitment_url = $page_link . 'reportfinancial_data' . $urlsuffix;
$project_all_activities_url = $page_link . 'allactivities_data' . $urlsuffix;
$project_outputs_url = $page_link . 'outputtracking_data' . $urlsuffix;

$all_projects_data = getdataobjectfromurl($url); // GET PROJECTS DATA
$activities_data = getdataobjectfromurl($activities_url); // GET ACTIVITIES DATA
$outputs_data = getdataobjectfromurl($outputs_url); // GET OUTPUTS DATA
$hr_data_uf = getdataobjectfromurl($hr_url); //GET HR DATA
$proj_outputs_data = getdataobjectfromurl($project_outputs_url);
$proj_activities_data = getdataobjectfromurl($project_all_activities_url);
$budget_data = getdataobjectfromurl($budget_commitment_url);

$budget_class_order = [
    "staff and other personnel costs",
    "contractual services",
    "travel",
    "equipment vehicles and furniture",
    "operating and other direct costs",
    "supplies commodities and materials",
    "transfers and grants issued to implementing partner (ip)",
    "ip-psc",
    "grants out",
    "un-psc",
];

$hr_data = [];
$unique_posids = [];
foreach ($hr_data_uf as $h) {
    if (!in_array($h->pos_id, $unique_posids)) {
        $hr_data[] = $h;
        $unique_posids[] = $h->pos_id;
    }
}

$projects_name_id = [];
$projects_ids = [];
$unique_final_ratings = [0];

$i = 0;
$refresh_date = '2021-01-28';
foreach ($all_projects_data as $key => $value) {

    if ($i == 1) {
        //var_dump($value);
    }
    $i += 1;

    if (!in_array($value->project_id, $projects_ids)) {
        $projects_name_id[] = [
            'id' => $value->project_id,
            'title' => $value->project_title,
        ];
        $projects_ids[] = $value->project_id;
    }
    //var_dump($projects_ids);

    if (!$value->final_rating) {
        $f_rating = 0;
    } else {
        $f_rating = $value->final_rating;
    }

    if (!in_array($f_rating, $unique_final_ratings)) {
        $unique_final_ratings[] = $f_rating;
    }

    if ($value->data_refreshed) {
        $refresh_date = $value->data_refreshed;
    }

}

$p = 0;
foreach ($all_projects_data as $key => $value) {
    // var_dump($value);

    if (!$value->final_rating) {
        $project_rank = 'N/A';
    } else {
        $f_rating = $value->final_rating;
        $project_rank = array_search($f_rating, $unique_final_ratings) + 1;
    }

    $project_id = $value->project_id;
    $project_title = $value->project_title;
    $project_summary = $value->project_summary;
    $project_office = $value->managing_division;
    $project_fund_amount = $value->consumable_budget;
    $project_prodoc_amount = 0;
    $project_duration = getdaysbetween($value->StartDate, $value->EndDate) / 30;
    $project_rank = $project_rank;
    $project_healthrating = $value->final_rating;
    $project_manager = $value->project_manager;

/* Simulating budget classes for the respective project */

    $budgetclass_names = array();
    $budgetclass_codes = array();
    $budgetclass_amounts = array();
    $budgetclass_spent = array();
    $budgetclass_obligated = array();
    $budgetclass_expenditure = array();
    $budgetclass_balance = array();

    // BUDGET DATA FROM BUDGET COMMITMENT ENDPOINT
    foreach ($budget_data as $budget) {
        if ($budget->projectID == $value->project_id) {
            // Variables needed for budget classes

            if ($p == 1) {
                //  var_dump($budget);
            }
            if ($budget->commitment_item && $budget->commitment_item !== '') {
                if (!in_array($budget->commitment_item, $budgetclass_names)) {

                    $order = array_search(strtolower($budget->commitment_item), $budget_class_order);
                    if (!$order) {
                        $order = rand(10, 100);
                    }
                    $budgetclass_names[$order] = $budget->commitment_item;
                    $budgetclass_codes[$order] = $budget->funded_program_key;
                    $budgetclass_amounts[$order] = $budget->consumable_budget;
                    $budgetclass_spent[$order] = $budget->actual;
                    $budgetclass_obligated[$order] = $budget->commitment;
                    $budgetclass_expenditure[$order] = $budget->consumed_budget;
                    $budgetclass_balance[$order] = $budget->consumable_budget - $budget->consumed_budget;
                } else {
                    foreach ($budgetclass_names as $ckey => $cvalue) {
                        if ($cvalue == $budget->commitment_item) {
                            $budgetclass_amounts[$ckey] = $budgetclass_amounts[$ckey] + $budget->consumable_budget;
                            $budgetclass_spent[$ckey] = $budgetclass_spent[$ckey] + $budget->actual;
                            $budgetclass_obligated[$ckey] = $budgetclass_obligated[$ckey] + $budget->commitment;
                            $budgetclass_expenditure[$ckey] = $budgetclass_expenditure[$ckey] + $budget->consumed_budget;
                            $budgetclass_balance[$ckey] = $budgetclass_amounts[$ckey] - $budgetclass_expenditure[$ckey];
                        }
                    }
                }
            }
        }
    }
    sort($budgetclass_names);
    sort($budgetclass_codes);
    sort($budgetclass_amounts);
    sort($budgetclass_spent);
    sort($budgetclass_obligated);
    sort($budgetclass_expenditure);
    sort($budgetclass_balance);

    //var_dump($budgetclass_balance[$ckey]);
    $outputs_activities = array();
    $outputs_count = 0;
    $activities_count = 0;

    $activity_status_desc = array("0" => "Not Defined", "1" => "Not Started", "2" => "In Progress", "3" => "Completed");

    foreach ($proj_outputs_data as $output) {
        if ($output->projectID == $value->project_id) {
            $output_fundamount = 0;
            $activities_list = [];

            foreach ($proj_activities_data as $activity) {
                if ($activity->op_id == $output->output_id) {
                    $activity_id = $activity->activity_no;
                    $activity_title = $activity->activity_title;
                    $activity_startdate = $activity->start_date;
                    $activity_enddate = $activity->end_date;
                    $activity_staff = $activity->resp_staff_email;
                    $activity_office = $activity->managing_division;
                    $activity_branch = $activity->managing_branch;
                    $activity_status = $activity->status;
                    $activity_tracking_text = $activity->activity_tracking;
                    $activity_tracking_color = $activity->activity_traffic_light;
                    $activity_funded = $activity->funded;
                    $activity_fundamount = $activity->amount_funded;

                    // Fill in activity data
                    $activities_list[] = [
                        "id" => $activity_id,
                        "title" => $activity_title,
                        "startdate" => $activity_startdate,
                        "enddate" => $activity_enddate,
                        "duration" => getdaysbetween($activity_startdate, $activity_enddate),
                        "elapsed" => getdaysbetween($activity_startdate, date("d-m-Y", time())),
                        "staff" => $activity_staff,
                        "office" => $activity_office,
                        "branch" => $activity_branch,
                        "status" => $activity_status,
                        "trackingtext" => $activity_tracking_text,
                        "trackingcolor" => $activity_tracking_color,
                        "funded" => $activity_funded,
                        "fundamount" => $activity_fundamount,
                    ];
                    $output_fundamount += $activity_fundamount;
                    $activities_count++;
                }
            }

            $outputs_activities[] = [
                "id" => $output->output_id,
                "title" => $output->output_name,
                "activities" => $activities_list,
                "fundamount" => $output_fundamount,
            ];
            $outputs_count++;
        }
    }

    $projectlisting[$project_id] = [
        "id" => $project_id,
        "title" => $project_title,
        "summary" => $project_summary,
        "office" => $project_office,
        "manager" => $project_manager,
        "fundamount" => $project_fund_amount,
        "prodocamount" => $project_prodoc_amount,
        "outputscount" => $outputs_count,
        "activitiescount" => $activities_count,
        "duration" => $project_duration,
        "rank" => $project_rank,
        "healthrating" => $project_healthrating,
        "healthcolor" => gethealthcolor($project_healthrating),
        "budgetclass" => array("names" => $budgetclass_names, "codes" => $budgetclass_codes, "amounts" => $budgetclass_amounts, "spent" => $budgetclass_spent, "obligated" => $budgetclass_obligated, "expenditure" => $budgetclass_expenditure, "balance" => $budgetclass_balance),
        "outputs_activities" => $outputs_activities,
        "refresh_date" => $refresh_date,
    ];
    if ($p == 1) {
        //var_dump($projectlisting[$project_id]);
    }

    $p++;
}

//var_dump($projectlisting);
// foreach ($all_projects_data as $key => $value) {
//     $project_outputs = [];
//     $project_budget_classes = [];
//     $project_classes_amounts = [];

//     foreach ($commitment_data as $c) {
//         if ($c->projectID == $value->project_id) {
//             if ($c->commitment_item) {
//                 $project_budget_classes[] = $c->commitment_item;
//                 $project_classes_amounts[] = $c->consumable_budget;
//             }
//         }
//     }
//     foreach ($proj_activities_data as $output) {
//         if ($output->projectID == $value->project_id) {
//             $project_outputs[] = $output;
//         }
//     }

//     if (isset($value->StartDate) && isset($value->EndDate)) {
//         $project_duration = getdaysbetween($value->StartDate, $value->EndDate);
//     } else {
//         $project_duration = 'NO DATE(S)';
//     }

//     if (!$value->final_rating) {
//         $project_rank = 'N/A';
//     } else {
//         $f_rating = $value->final_rating;
//         $project_rank = array_search($f_rating, $unique_final_ratings) + 1;
//     }

//     var_dump($project_budget_classes);

//     $processed_spdata[$value->project_id] = [

//         "id" => $project_id,
//         "title" => $value->project_title,
//         "office" => $project_office,
//         "fundamount" => $value->consumable_budget,
//         "prodocamount" => $project_prodoc_amount,
//         "outputscount" => count($project_outputs),
//         "activitiescount" => $activities_count,
//         "duration" => $project_duration,
//         "rank" => $project_rank,
//         "healthrating" => $project_healthrating,
//         "healthcolor" => gethealthcolor($project_healthrating),
//         "budgetclass" => array("names" => $budgetclass_names, "amounts" => $budgetclass_amounts),
//         "outputs_activities" => $outputs_activities

//         //new project details

//         , 'project_prodoc_amount' => 0//$value->consumable_budget,
//         , 'project_activities_count' => 0
//         , 'project_duration' => $project_duration
//         , 'project_health_rating' => $value->final_rating
//         , 'project_health_rating_color' => gethealthcolor($value->final_rating)
//         , 'project_budget_information' => [$project_budget_classes, $project_classes_amounts],
//     ];

//     // var_dump($project_outputs);
//     echo '<br/>_________________________________<br />';

// }
