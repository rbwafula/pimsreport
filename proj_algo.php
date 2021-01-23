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

$page_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
$url = $page_link . '/assets/data/final_data.json';
//$activities_url = $page_link . '/assets/data/div_activitycount_data.json';
$activities_url = 'https://staging1.unep.org/simon/pims-stg/modules/main/pims3-api/div_practivitycount_data';
$outputs_url = $page_link . '/assets/data/div_activitycount_data.json';
$hr_url = 'https://staging1.unep.org/simon/pims-stg/modules/main/pims3-api/officestaff_data';
$proj_activity_url = $page_link . '/assets/data/div_practivitycount_data.json';
$budget_commitment_url = 'https://staging1.unep.org/simon/pims-stg/modules/main/pims3-api/budgetcommitment_data';
$project_all_activities_url = 'https://projects.unep.org/modules/main/pims3-api/allactivities_data';
$project_outputs_url = 'https://staging1.unep.org/simon/pims-stg/modules/main/pims3-api/outputtracking_data';

// GET PROJECTS DATA
$all_projects_data = getdataobjectfromurl($url);

// GET ACTIVITIES DATA
$activities_data = getdataobjectfromurl($activities_url);

// GET OUTPUTS DATA
$outputs_data = getdataobjectfromurl($outputs_url);

//GET HR DATA
$hr_data_uf = getdataobjectfromurl($hr_url);
$proj_outputs_data = getdataobjectfromurl($proj_activity_url);

$proj_activities_data = getdataobjectfromurl($project_outputs_url);
$commitment_data = getdataobjectfromurl($budget_commitment_url);

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
foreach ($all_projects_data as $key => $value) {
    if ($i == 1) {
        var_dump($value);
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
}

foreach ($all_projects_data as $key => $value) {
    $project_outputs = [];
    $project_budget_classes = [];
    $project_classes_amounts = [];

    foreach ($commitment_data as $c) {
        if ($c->projectID == $value->project_id) {
            if ($c->commitment_item) {
                $project_budget_classes[] = $c->commitment_item;
                $project_classes_amounts[] = $c->consumable_budget;
            }
        }
    }
    foreach ($proj_activities_data as $output) {
        if ($output->projectID == $value->project_id) {
            $project_outputs[] = $output;
        }
    }

    if (isset($value->StartDate) && isset($value->EndDate)) {
        $project_duration = getdaysbetween($value->StartDate, $value->EndDate);
    } else {
        $project_duration = 'NO DATE(S)';
    }

    if (!$value->final_rating) {
        $project_rank = 'N/A';
    } else {
        $f_rating = $value->final_rating;
        $project_rank = array_search($f_rating, $unique_final_ratings) + 1;
    }

    var_dump($project_budget_classes);

    $processed_spdata[$value->project_id] = [
        'project_title' => $value->project_title
        , 'project_fund_amount' => $value->consumable_budget
        , 'project_prodoc_amount' => 0//$value->consumable_budget,
        , 'project_outputs_count' => count($project_outputs)
        , 'project_activities_count' => 0
        , 'project_duration' => $project_duration
        , 'project_rank' => $project_rank
        , 'project_health_rating' => $value->final_rating
        , 'project_health_rating_color' => gethealthcolor($value->final_rating)
        , 'project_budget_information' => [$project_budget_classes, $project_classes_amounts],
    ];

    // var_dump($project_outputs);
    echo '<br/>_________________________________<br />';

}
