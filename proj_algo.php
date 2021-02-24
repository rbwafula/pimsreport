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
function gettrafficlight($health)
{
    $color = '#dc3545 !important'; //red
    if ($health == 'green') {
        $color = '#28a745 !important'; //green
    } elseif ($health == 'yellow') {
        $color = '#ffc107 !important'; // yellow
    }
    return $color;
}

function checkexpired($date)
{
    $expired = 'YES';
    if (!$date) {
        $expired = 'N/A';
    } elseif (strtotime($date) > time()) {
        $expired = 'NO';
    }
    return $expired;
}
function checkactive($date)
{
    $active = 'No';
    if (!$date) {
        $active = 'N/A';
    } elseif (strtotime($date) > time()) {
        $active = 'Yes';
    }
    return $active;
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

function reorder($array)
{
    ksort($array);
    $new = [];
    $i = 0;
    foreach ($array as $a) {
        $new[$i] = $a;
        $i++;
    }

    return $new;

}

//FETCH DATA -> CACHED/LIVE
$version = 'cached'; // live * Choose between: cached and live data here */
$cacheddata_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/assets/data/'; // localhost address and folder path to data folder
$livedata_link = 'https://staging1.unep.org/simon/pims-stg/modules/main/pims3-api/'; // live api
$page_link = ($version == 'cached') ? $cacheddata_link : $livedata_link;
$urlsuffix = ($version == 'cached') ? '.json' : '';

$url = $page_link . 'final_data' . $urlsuffix;
$consultants_url = $page_link . 'consultants_data' . $urlsuffix;
$outputs_url = $page_link . 'div_activitycount_data' . $urlsuffix;
$hr_url = $page_link . 'officestaff_data' . $urlsuffix;
$budget_commitment_url = $page_link . 'reportfinancial_data' . $urlsuffix;
$project_all_activities_url = $page_link . 'allactivities_data' . $urlsuffix;
$project_outputs_url = $page_link . 'outputtracking_data' . $urlsuffix;
$grant_data_url = $page_link . 'grant_data' . $urlsuffix;
$grant_details_url = $page_link . 'grantdetails_data' . $urlsuffix;

$all_projects_data = getdataobjectfromurl($url); // GET PROJECTS DATA
$outputs_data = getdataobjectfromurl($outputs_url); // GET OUTPUTS DATA
$hr_data_uf = getdataobjectfromurl($hr_url); //GET HR DATA
$proj_outputs_data = getdataobjectfromurl($project_outputs_url);
$proj_activities_data = getdataobjectfromurl($project_all_activities_url);
$budget_data = getdataobjectfromurl($budget_commitment_url);
$consultants_data = getdataobjectfromurl($consultants_url);
$all_grants_data = getdataobjectfromurl($grant_data_url);
$all_grants_details = getdataobjectfromurl($grant_details_url);

$budget_class_order = [
    "staffandotherpersonnelcosts",
    "contractualservices",
    "travel",
    "equipmentvehiclesandfurniture",
    "operatingandotherdirectcosts",
    "suppliescommoditiesandmaterials",
    "transfersandgrantsissuedtoimplementingpartner(ip)",
    "transfersandgrantsissuedtoimplementpartner",
    "ip-psc",
    "grantsout",
    "un-psc",
];

$hr_data = [];
$unique_posids = [];
foreach ($hr_data_uf as $hkey => $staff) {
    if (!in_array($staff->pos_id, $unique_posids)) {
        $hr_data[] = $staff;
        $unique_posids[] = $staff->pos_id;
    }
}

// STAFF ORDER BY SENIORITY FOR REFERENCE
$staff_order_array = ['USG ', 'ASG', 'D-2', 'D-1', 'P-5', 'P-4', 'P-3', 'P-2', 'P-1', 'GS'];
$staff_order_array_all = ['USG ', 'ASG', 'D-2', 'D-1', 'P-5', 'P-4', 'P-3', 'P-2', 'P-1', 'G-7', 'G-6', 'G-5', 'G-4', 'G-3', 'G-2', 'G-1', 'NO-A', 'NO-B', 'NO-C', 'NO-D'];

$projects_name_id = [];
$projects_ids = [];
$unique_final_ratings = [0];

$overall_vacant_posts = [];
$overall_filled_posts = [];
$total_vacant_posts = 0;
$total_filled_posts = 0;
$total_posts = 0;
$unique_post_groups = [];
$unique_posts_data = [];

$i = 0;
$refresh_date = '2021-01-28';
$coding_block = '';

foreach ($all_projects_data as $key => $value) {

    if ($i == 1) {
        // var_dump($value);
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

//USE DATA FROM API TO FEED THE UNIQUE POST POSITIONS ARRAY
foreach ($hr_data as $key => $value) {

    if (!in_array($value->pos_ps_group, $unique_post_groups)) {

        if ($value->gender == 'male') {

        } else {

        }

        if ($value->pers_no > 0) {
            if ($value->gender == 'Male') {
                $male = 1;
                $female = 0;
            } elseif ($value->gender == 'Female') {
                $male = 0;
                $female = 1;
            }

            $unique_posts_data[] = ["post" => $value->pos_ps_group, "vacant" => 0, "filled" => 1, "filled_male" => $male, "filled_female" => $female, "projects_post_vacant" => [], "projects_post_filled" => [$value->wbse]];
            $total_filled_posts += 1;
            $overall_filled_posts[array_search($value->pos_ps_group, $staff_order_array)] = $value->pos_ps_group;

        } else {
            $unique_posts_data[] = ["post" => $value->pos_ps_group, "vacant" => 1, "filled" => 0, "filled_male" => 0, "filled_female" => 0, "projects_post_vacant" => [$value->wbse], "projects_post_filled" => []];
            $total_vacant_posts += 1;
            $overall_vacant_posts[array_search($value->pos_ps_group, $staff_order_array)] = $value->pos_ps_group;

        }

        $unique_post_groups[] = $value->pos_ps_group;
    } else {
        foreach ($unique_posts_data as $pkey => $pvalue) {
            if ($value->pos_ps_group == $pvalue['post']) {
                if ($value->pers_no > 0) {
                    if ($value->gender == 'Male') {
                        $unique_posts_data[$pkey]['filled_male'] += 1;

                    } elseif ($value->gender == 'Female') {
                        $unique_posts_data[$pkey]['filled_female'] += 1;
                    }

                    $unique_posts_data[$pkey]['filled'] += 1;
                    $unique_posts_data[$pkey]['projects_post_filled'][] = $value->wbse;
                    $total_filled_posts += 1;
                    $overall_filled_posts[] = $value->pos_ps_group;

                } else {
                    $unique_posts_data[$pkey]['vacant'] += 1;
                    $unique_posts_data[$pkey]['projects_post_vacant'][] = $value->wbse;
                    $total_vacant_posts += 1;
                    $overall_vacant_posts[] = $value->pos_ps_group;

                }
            }
        }
    }
    $total_posts += 1;

}

$overall_post_status_distribution = [];

$t_filled_posts = 0;
$t_vacant_posts = 0;
$t_posts = 0;

$t_filled_male_count = 0;
$t_filled_female_count = 0;

foreach ($unique_posts_data as $pkey => $pvalue) {

    if ($pvalue['post'] !== '') {
        $t_filled_count = 0;
        $t_vacant_count = 0;
        $t_filled_male = 0;
        $t_filled_female = 0;

        foreach ($pvalue['projects_post_filled'] as $okey => $ovalue) {
            $t_filled_count += 1;
        }

        foreach ($pvalue['projects_post_vacant'] as $okey => $ovalue) {
            $t_vacant_count += 1;
        }
        $t_filled_male += $pvalue['filled_male'];
        $t_filled_female += $pvalue['filled_female'];

        $overall_post_status_distribution[] = ["post" => $pvalue['post'], "filled" => $t_filled_count, "filled_male" => $t_filled_male, "filled_female" => $t_filled_female, "vacant" => $t_vacant_count];

        $t_filled_posts += $t_filled_count;
        $t_vacant_posts += $t_vacant_count;
        $t_posts += $t_filled_count + $t_vacant_count;

        $t_filled_male_count += $t_filled_male;
        $t_filled_female_count += $t_filled_female;

    }
}

$G_staff_distribution = ["post" => 'GS', "filled" => 0, "filled_male" => 0, "filled_female" => 0, "vacant" => 0];

foreach ($overall_post_status_distribution as $key => $value) {
    if ($value['filled'] == 0 && $value['vacant'] == 0) {
        unset($overall_post_status_distribution[$key]);
    }

    $firstCharacter = $value['post'][0];
    if ($firstCharacter == 'G' || $firstCharacter == 'N') {
        $G_staff_distribution['filled'] += $value['filled'];
        $G_staff_distribution['filled_male'] += $value['filled_male'];
        $G_staff_distribution['filled_female'] += $value['filled_female'];
        $G_staff_distribution['vacant'] += $value['vacant'];
        unset($overall_post_status_distribution[$key]);
    }
}

$overall_post_status_distribution[] = $G_staff_distribution;

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
    $project_start_date = $value->StartDate;
    $project_end_date = $value->EndDate;
    $project_duration = 'N/A';
    $project_duration_elapsed = 'N/A';
    if (!is_null($value->StartDate) && !is_null($value->EndDate)) {
        $project_duration = number_format(ceil(getdaysbetween($value->StartDate, $value->EndDate) / 365.25), 0, '.', ',');
        $project_duration_elapsed = number_format(ceil(getdaysbetween($project_start_date, null) / 365.25), 0, '.', ',');
    }
    $project_rank = $project_rank;
    $project_healthrating = $value->final_rating;
    $project_healthtraffic = $value->system_traffic_light;
    $project_manager = $value->project_manager;
    $project_subprogramme = $value->subprogramme;
    $project_pctg_budget_spent = round($value->percentage_budget_utilized * 100);
    $project_pctg_time_used = round($value->percentage_time_taken * 100);
    $pj_elapsedtime = 0;
    if (is_null($value->percentage_time_taken)) {
        //echo $value->project_id.'<br/>';
        // IF no value from DB for percentage_time_taken, calculate using start & end dates
        if (!is_null($project_start_date) && !is_null($project_end_date)) {
            $pj_elapsedtime = (time() > strtotime($project_end_date)) ? strtotime($project_end_date) : time();
            $project_pctg_time_used = round(((($pj_elapsedtime - strtotime($project_start_date)) / max((strtotime($project_end_date) - strtotime($project_start_date)), 1)) * 100));
        } else {
            $project_pctg_time_used = 0;
        }

    }
    $project_pctg_activities_completed = round($value->percentage_activities_completed * 100);

    // Staff Data
    $staff_data = [];
    foreach ($hr_data_uf as $hkey => $staff) {
        if ($staff->project_id == $project_id) {
            $staff_data[] = [
                "person_no" => $staff->pers_no,
                "name" => $staff->first_name . ' ' . $staff->last_name,
                "gender" => $staff->gender,
                "duty_station" => $staff->duty_station,
                "pos_title" => $staff->pos_title,
                "pos_group" => $staff->pos_ps_group,
                "org_unit" => $staff->org_unit_desc,
                "office" => $staff->office,
                "branch" => $staff->branch,
                "subprogramme" => $staff->subprogramme,
                "wbse" => $staff->wbse,
                "fundkey" => $staff->fund_key,
                "fund_desc" => $staff->fund_description,
                "fundcategory" => $staff->fund_category,
                "category" => $staff->category,
                "performance_cycle" => $staff->performance_cycle,
                "fro_name" => $staff->fro_name,
                "sro_name" => $staff->sro_name,
                "document_stage" => $staff->fro_name,
                "document_final_status" => $staff->sro_name,
                "allcourses" => $staff->no_of_total_courses_done,
                "mandatorycourses" => $staff->no_of_mandatory_courses_done,
                "appt_exp" => $staff->appt_exp,
                "retirement_date" => $staff->retirement_date,
                "appt_exp_months" => $staff->months_to_appt_exp,
                "retirement_date_months" => $staff->months_to_retirement,
            ];
        }
    }

    //CONSULTANTS DATA
    $consultantslist_data = [];
    foreach ($consultants_data as $consultancy) {
        if ($consultancy->project_id == $project_id) {
            $consultantslist_data[] = [
                "names" => $consultancy->supplier_full_name,
                "startdate" => $consultancy->latest_contract_start_date,
                "enddate" => $consultancy->latest_contract_end_date,
                "renewals" => $consultancy->no_of_contract_renewals,
                "active" => checkactive($consultancy->latest_contract_end_date),
                "duration" => getdaysbetween($consultancy->latest_contract_start_date, $consultancy->latest_contract_end_date),
                "morethan11" => (getdaysbetween($consultancy->latest_contract_start_date, $consultancy->latest_contract_end_date) > 30 * 11 ? 'YES' : 'NO'),
            ];
        }
    }

/* Simulating budget classes for the respective project */

    $budgetclass_names = array();
    $budgetclass_grants = array();
    $budgetclass_grants_count = array();

    $budgetclass_grants_from = array();
    $budgetclass_grants_to = array();
    $budgetclass_grants_expired = array();
    $budgetclass_grants_amount = array();
    // LATEST ADDITIONS START

    //LATEST ADDITIONS END

    $budgetclass_amounts = array();
    $budgetclass_spent = array();
    $budgetclass_obligated = array();
    $budgetclass_expenditure = array();
    $budgetclass_balance = array();
    $budgetclass_difference = array();
    $budgetclass_cost_centers = array();

    foreach ($all_grants_data as $grant) {
        if ($grant->project_id == $value->project_id) {
// Variables needed for budget classes
            if ($grant->grant_key) {
                $budgetclass_grants[] = $grant->grant_key;

                $budgetclass_grants_from[] = $grant->grant_valid_from;

                $budgetclass_grants_to[] = $grant->grant_valid_to;
                $budgetclass_grants_expired[] = checkexpired($grant->grant_valid_to);

                // if ($project_id == '00270' || $project_id == 00270) {

                //     echo $budget->grant_valid_to . '<br />';
                //     echo checkexpired($budget->grant_valid_to) . '<br />';
                // }
                // $budgetclass_grants_amount[] = $grant->total_grant_amount;
                $budgetclass_grants_amount[] = $grant->grant_cash_balance;

                $budgetclass_difference[] = $grant->difference;

                $budgetclass_grants_fund = array();
                $budgetclass_grants_precommitment = array();
                $budgetclass_grants_commitment = array();
                $budgetclass_grants_actual = array();
                $budgetclass_grants_consumable_budget = array();
                $budgetclass_grants_consumed_budget = array();

                foreach ($all_grants_details as $detail) {
                    if ($detail->grant_key == $grant->grant_key) {
                        $budgetclass_grants_fund[] = $detail->funded_program_key;
                        $budgetclass_grants_precommitment[] = $detail->precommitment;
                        $budgetclass_grants_commitment[] = $detail->commitment;
                        $budgetclass_grants_actual[] = $detail->actual;
                        $budgetclass_grants_consumable_budget[] = $detail->consumable_budget;
                        $budgetclass_grants_consumed_budget[] = $detail->consumed_budget;
                    }}
                //    latest additions population start

                $budgetclass_cost_centers[] = ["funds" => $budgetclass_grants_fund, "precommitment" => $budgetclass_grants_precommitment, "commitment" => $budgetclass_grants_commitment, "actual" => $budgetclass_grants_actual, "consumable" => $budgetclass_grants_consumable_budget, "consumed" => $budgetclass_grants_consumed_budget];
                //    latest additions population end

            }
        }
    }
    // BUDGET DATA FROM BUDGET COMMITMENT ENDPOINT
    foreach ($budget_data as $budget) {
        if ($budget->projectID == $value->project_id) {

            // var_dump($budget);
            if ($budget->commitment_item && $budget->commitment_item !== '') {

                if (!in_array($budget->commitment_item, $budgetclass_names)) {

                    $order = array_search(strtolower(str_replace(' ', '', $budget->commitment_item)), $budget_class_order) + 1;
                    if ($project_id == '00270' || $project_id == 00270) {
                        // echo $order . '<br />';
                        // echo $budget->commitment_item . '<br />';
                        // echo $budget->total_grant_amount . '<br />';
                        // echo '---------------------------------------<br />';
                    }

                    if (!$order) {
                        $order = rand(10, 100);
                    }

                    if ($budget->funded_program_key) {
                        $coding_block = $budget->funded_program_key;
                    }

                    $budgetclass_names[$order] = $budget->commitment_item;

                    //echo $budget->grant_key;

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

                            // $budgetclass_grants_expired[$ckey] = checkexpired($budget->grant_valid_to);
                            // $budgetclass_grants_amount[$ckey] = $budgetclass_grants_amount[$ckey] + $budget->grant_amount;

                        }
                    }
                }
            }
        }
    }
    $budgetclass_names = reorder($budgetclass_names);
    // $budgetclass_grants = reorder($budgetclass_grant);

    // $budgetclass_grants_from = reorder($budgetclass_grants_from);
    // $budgetclass_grants_to = reorder($budgetclass_grants_to);
    // $budgetclass_grants_expired = reorder($budgetclass_grants_expired);
    // $budgetclass_grants_amount = reorder($budgetclass_grants_amount);
    //var_dump($budgetclass_grants_expired);
    $budgetclass_amounts = reorder($budgetclass_amounts);
    $budgetclass_spent = reorder($budgetclass_spent);
    $budgetclass_obligated = reorder($budgetclass_obligated);
    $budgetclass_expenditure = reorder($budgetclass_expenditure);
    $budgetclass_balance = reorder($budgetclass_balance);

    $unique_grants = [];
    $unique_grants_count = [];
    $unique_grants_from = [];
    $unique_grants_to = [];
    $unique_grants_expired = [];
    $unique_grants_amount = [];

//latest additions
    // $unique_grants_fund = [];
    $unique_grants_precommitment = [];
    $unique_grants_commitment = [];
    $unique_grants_actual = [];
    $unique_grants_consumable_budget = [];
    $unique_grants_consumed_budget = [];

//latest additions

    foreach ($budgetclass_grants as $gkey => $gvalue) {
        $position = array_search($gvalue, $unique_grants);
        if (!in_array($gvalue, $unique_grants)) {
            if ($project_id == '00270' || $project_id == 00270) {
                // echo $gvalue . '<br/>';
                // echo $position . '<br/>';
                // var_dump($budgetclass_cost_centers);
                // echo '---------------------------------------------------<br/>';
            }

            $unique_grants[] = $gvalue;
            $unique_grants_count[] = 1;
            $unique_grants_from[] = $budgetclass_grants_from[$gkey];
            $unique_grants_to[] = $budgetclass_grants_to[$gkey];
            $unique_grants_expired[] = $budgetclass_grants_expired[$gkey];
            $unique_grants_amount[] = $budgetclass_grants_amount[$gkey];
            $unique_grants_cost_centers[] = $budgetclass_cost_centers[$gkey];

            //latest additions
            // $unique_grants_fund[] = $budgetclass_grants_fund[$gkey];
            // $unique_grants_precommitment[] = $budgetclass_grants_precommitment[$gkey];
            // $unique_grants_commitment[] = $budgetclass_grants_commitment[$gkey];
            // $unique_grants_actual[] = $budgetclass_grants_actual[$gkey];
            // $unique_grants_consumable_budget[] = $budgetclass_grants_consumable_budget[$gkey];
            // $unique_grants_consumed_budget[] = $budgetclass_grants_consumed_budget[$gkey];
            //latest additions

        }
        // else {
        //     $current_amount = $unique_grants_amount[$position];
        //     $unique_grants_amount[$position] = $current_amount + $budgetclass_grants_amount[$gkey];
        //     $unique_grants_count[$position] += 1;
        // }

    }

    // if ($project_id == '00270' || $project_id == 00270) {
    //     echo '<br />------------------------------------------------------<br />';
    //     var_dump($unique_grants);
    //     echo '<br />------------------------------------------------------<br />';
    //     var_dump($unique_grants_count);
    //     echo '<br />------------------------------------------------------<br />';
    //     var_dump($unique_grants_amount);
    //     echo '<br />------------------------------------------------------<br />';
    //     var_dump($unique_grants_expired);
    //     echo '<br />------------------------------------------------------<br />';
    //     var_dump($unique_grants_from);
    //     echo '<br />------------------------------------------------------<br />';
    //     var_dump($unique_grants_to);
    //     echo '<br />------------------------------------------------------<br />';
    // }

    //var_dump($budgetclass_balance[$ckey]);
    $outputs_activities = array();
    $outputs_count = 0;
    $activities_count = 0;
    $completed_activities_count = 0;

    $activity_status_desc = array("0" => "Not Defined", "1" => "Not Started", "2" => "In Progress", "3" => "Completed");

    foreach ($proj_outputs_data as $output) {
        if ($output->projectID == $value->project_id) {
            $output_fundamount = 0;
            $activities_list = [];

            foreach ($proj_activities_data as $activity) {
                if ($activity->op_id == $output->output_id) {

                    //var_dump($activity);
                    if (strtolower($activity->status) == 'completed') {
                        $completed_activities_count++;
                    }
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
                    $activity_elapsed_enddate = '';
                    if ($activity_status == 'Completed') {
                        $activity_elapsed_enddate = $activity_enddate;
                    } else if ($activity_status == 'Not Started') {
                        $activity_elapsed_enddate = $activity_startdate;
                    } else {
                        $activity_elapsed_enddate = date("d-m-Y", time());
                    }

                    // Fill in activity data
                    $activities_list[] = [
                        "id" => $activity_id,
                        "title" => $activity_title,
                        "startdate" => $activity_startdate,
                        "enddate" => $activity_enddate,
                        "duration" => ceil(getdaysbetween($activity_startdate, $activity_enddate)),
                        "elapsed" => ceil(getdaysbetween($activity_startdate, $activity_elapsed_enddate)),
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

    $p_vacant_posts = [];
    $p_filled_posts = [];
    $p_vacant_posts = 0;
    $p_filled_posts = 0;
    $p_posts = 0;
    $p_filled_male_count = 0;
    $p_filled_female_count = 0;

    //PROJECT STAFF INFORMATION
    $p_staff_information = [];
    foreach ($hr_data as $hkey => $hvalue) {
        if ($hvalue->wbse == $project_id) {
            if ($hvalue->pers_no > 0) {
                $p_status = 'FILLED';
            } else {
                $p_status = 'VACANT';
            }
            $p_staff_information[] = [
                'grade' => $hvalue->pos_ps_group,
                'position_title' => $hvalue->pos_title,
                'position_number' => $hvalue->pos_id,
                'duty_station' => $hvalue->duty_station,
                'position_status' => $p_status,
                'staff_name' => $hvalue->first_name . ' ' . $hvalue->last_name,
                'performance_cycle' => $hvalue->performance_cycle,
                'mandatory_training_enrollment_status' => $hvalue->mandatory_training_enrollment_status,
                'no_of_learning_courses' => $hvalue->no_of_learning_courses,
                'fund_key' => $hvalue->fund_key,
                'fund_description' => $hvalue->fund_description,
                'category' => $hvalue->category,
                'org_code' => $hvalue->org_unit,
                'org_unit_description' => $hvalue->org_unit_desc,
                'order' => array_search($hvalue->pos_ps_group, $staff_order_array_all),

            ];
        }
    }

    usort($p_staff_information, 'sortByOrder');

    $p_post_status_distribution = [];

    foreach ($unique_posts_data as $pkey => $pvalue) {

        if ($pvalue['post'] !== '') {
            $p_filled_count = 0;
            $p_vacant_count = 0;
            $p_filled_male = 0;
            $p_filled_female = 0;

            foreach ($pvalue['projects_post_filled'] as $okey => $ovalue) {
                if ($ovalue == $project_id) {
                    $p_filled_count += 1;
                }
            }

            foreach ($pvalue['projects_post_vacant'] as $okey => $ovalue) {
                if ($ovalue == $project_id) {
                    $p_vacant_count += 1;
                }
            }

            foreach ($hr_data as $hkey => $hvalue) {
                # code...
                if ($hvalue->wbse == $project_id && $hvalue->pos_ps_group == $pvalue['post']) {
                    if ($hvalue->pers_no > 0) {
                        if ($hvalue->gender == 'Male') {
                            $p_filled_male += 1;
                        } elseif ($hvalue->gender == 'Female') {

                            $p_filled_female += 1;

                        }
                    } else {

                    }
                }
            }

            $p_post_status_distribution[] = ["post" => $pvalue['post'], "filled" => $p_filled_count, "filled_male" => $p_filled_male, "filled_female" => $p_filled_female, "vacant" => $p_vacant_count];

            $p_filled_posts += $p_filled_count;
            $p_vacant_posts += $p_vacant_count;

            $p_filled_male_count += $p_filled_male;
            $p_filled_female_count += $p_filled_female;

            $p_posts += $p_filled_count + $p_vacant_count;
        }
    }

    $G_p_staff_distribution = ["post" => 'GS', "filled" => 0, "filled_male" => 0, "filled_female" => 0, "vacant" => 0];

    foreach ($p_post_status_distribution as $key => $value) {
        if ($value['filled'] == 0 && $value['vacant'] == 0) {
            unset($p_post_status_distribution[$key]);
        }

        $firstCharacter = $value['post'][0];
        if ($firstCharacter == 'G' || $firstCharacter == 'N') {
            $G_p_staff_distribution['filled'] += $value['filled'];
            $G_p_staff_distribution['filled_male'] += $value['filled_male'];
            $G_p_staff_distribution['filled_female'] += $value['filled_female'];
            $G_p_staff_distribution['vacant'] += $value['vacant'];
            unset($p_post_status_distribution[$key]);
        }
    }

    $p_post_status_distribution[] = $G_p_staff_distribution;

    $unsorted_posts = $p_post_status_distribution;
// $d_post_status_distribution = [];

    foreach ($p_post_status_distribution as $key => $value) {
        $position = intval(array_search($value['post'], $staff_order_array));
        $p_post_status_distribution[$key]['order'] = $position;
    }

    usort($p_post_status_distribution, 'sortByOrder');

    $p_post_categories = array();
    $p_post_filled = array();
    $p_post_filled_male = array();
    $p_post_filled_female = array();
    $p_post_vacant = array();
    $p_post_male = array();
    $p_post_female = array();

// foreach ($d_subprogramme_projects_distribution as $key => $value) {
    //     echo $value['subprogramme'] . ' subprogramme, ' . $value['projects'] . ' projects <br />';
    // }

    foreach ($p_post_status_distribution as $key => $value) {
        array_push($p_post_categories, $value['post']);
        array_push($p_post_filled, $value['filled']);
        if ($value['filled'] != 0 && $value['filled_male'] != 0) {
            array_push($p_post_filled_male, (1 * (100 * $value['filled_male'] / $value['filled'])));
        } else {
            array_push($p_post_filled_male, 0);
        }
        if ($value['filled'] != 0 && $value['filled_female'] != 0) {
            array_push($p_post_filled_female, (-1 * (100 * $value['filled_female'] / $value['filled'])));
        } else {
            array_push($p_post_filled_female, 0);
        }
        array_push($p_post_vacant, $value['vacant']);
        array_push($p_post_male, $value['filled_male']);
        array_push($p_post_female, $value['filled_female']);
    }

    $projectlisting[$project_id] = [
        "id" => $project_id,
        "title" => $project_title,
        "startdate" => $project_start_date,
        "enddate" => $project_end_date,
        "subprogramme" => $project_subprogramme,
        "summary" => $project_summary,
        "office" => $project_office,
        "manager" => $project_manager,
        "fundamount" => $project_fund_amount,
        "prodocamount" => $project_prodoc_amount,
        "outputscount" => $outputs_count,
        "activitiescount" => $activities_count,
        "duration" => $project_duration,
        "budget_spent" => $project_pctg_budget_spent,
        "time_used" => $project_pctg_time_used,
        "activities_completed" => $project_pctg_activities_completed,
        "activities_completed_count" => $completed_activities_count,
        "duration_elapsed" => $project_duration_elapsed,
        "rank" => $project_rank,
        "healthrating" => $project_healthrating,
        "trafficlight" => $project_healthtraffic,
        "healthcolor" => gettrafficlight($project_healthtraffic),
        "budgetclass" => array("names" => $budgetclass_names, "grants" => $unique_grants, "grants_from" => $unique_grants_from,
            "grants_to" => $unique_grants_to,
            "grants_expired" => $unique_grants_expired,
            "grants_amount" => $unique_grants_amount,
            "grants_cost_centers" => $unique_grants_cost_centers,
//latest changes annexing start
            // "grants_fund" => $unique_grants_fund,
            "grants_precommitment" => $unique_grants_precommitment,
            "grants_commitment" => $unique_grants_commitment,
            "grants_actual" => $unique_grants_actual,
            "grants_consumable_budget" => $unique_grants_consumable_budget,
            "grants_consumed_budget" => $unique_grants_consumed_budget,
//latest changes annexing ends
            "amounts" => $budgetclass_amounts,
            "spent" => $budgetclass_spent, "obligated" => $budgetclass_obligated, "expenditure" => $budgetclass_expenditure, "balance" => $budgetclass_balance),
        "coding_block" => $coding_block,
        "outputs_activities" => $outputs_activities,
        "hrpostscategories" => $p_post_categories,
        "hrpostsfilled" => $p_post_filled,
        "hrpostsfilledmale" => $p_post_filled_male,
        "hrpostsfilledfemale" => $p_post_filled_female,
        "hrpostsvacant" => $p_post_vacant,
        "hrpostsmale" => $p_post_male,
        "hrpostsfemale" => $p_post_female,
        "consultants" => $consultantslist_data,
        "staff" => $staff_data,
        "refresh_date" => $refresh_date,
    ];
    if ($project_id == 00270 || $project_id == '00270') {
        //var_dump($projectlisting[$project_id]['budgetclass']);
        // echo '-------------------------------';
        // var_dump($consultancy_expired);
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
