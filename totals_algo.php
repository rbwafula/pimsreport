<?php
$version = 'cached'; // live * Choose between: cached and live data here */
$cacheddata_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/assets/data/'; // localhost address and folder path to data folder
$livedata_link = 'https://staging1.unep.org/simon/pims-stg/modules/main/pims3-api/'; // live api
$page_link = ($version == 'cached') ? $cacheddata_link : $livedata_link;
$urlsuffix = ($version == 'cached') ? '.json' : '';

$url = $page_link . 'final_data' . $urlsuffix;
$activities_url = $page_link . 'div_activitycount_data' . $urlsuffix;
$outputs_url = $page_link . 'div_activitycount_data' . $urlsuffix;
$hr_url = $page_link . 'officestaff_data' . $urlsuffix;
$proj_activity_url = $page_link . 'div_practivitycount_data' . $urlsuffix;
$grant_data_url = $page_link . 'grant_data' . $urlsuffix;
$grant_details_url = $page_link . 'grantdetails_data' . $urlsuffix;
$consultants_url = $page_link . 'consultants_data' . $urlsuffix;
$risks_url = $page_link . 'divisionrisk_data' . $urlsuffix;
$boa_url = $page_link . 'boa_data' . $urlsuffix;
$oios_url = $page_link . 'oios_data' . $urlsuffix;

// TODO Staff positions
// TODO epass and mandatory learning compliance

/*
$page_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
$url = $page_link . '/assets/data/final_data.json';
$activities_url = $page_link . '/assets/data/div_activitycount_data.json';
$outputs_url = $page_link . '/assets/data/div_activitycount_data.json';
$hr_url = $page_link . '/assets/data/officestaff_data.json';
$proj_activity_url = $page_link . '/assets/data/div_practivitycount_data.json';
$grant_data_url = $page_link . 'grant_data' . $urlsuffix;
$grant_details_url = 'https://staging1.unep.org/simon/pims-stg/modules/main/pims3-api/grantdetails_data';
 */

$processed_divisiondata = array();

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

function sortByConsumable($a, $b)
{
    return $b['consumable'] - $a['consumable'];
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

// GET PROJECTS DATA
$division_data = getdataobjectfromurl($url);

// GET ACTIVITIES DATA
$activities_data = getdataobjectfromurl($activities_url);

// GET OUTPUTS DATA
$outputs_data = getdataobjectfromurl($outputs_url);

//GET HR DATA
$hr_data_uf = getdataobjectfromurl($hr_url);

$all_grants_data = getdataobjectfromurl($grant_data_url);
$all_grants_details = getdataobjectfromurl($grant_details_url);
$consultants_data = getdataobjectfromurl($consultants_url);
$risks_data = getdataobjectfromurl($risks_url);
$boa_data = getdataobjectfromurl($boa_url);
$oios_data = getdataobjectfromurl($oios_url);

// CLEANSE HR DATA FOR UNIQUE pos_id
$hr_data = [];
$unique_posids = [];
foreach ($hr_data_uf as $h) {
    if (!in_array($h->pos_id, $unique_posids)) {
        $hr_data[] = $h;
        $unique_posids[] = $h->pos_id;
    }
}


// var_dump($unique_posids);

// GET PROJECT ACTIVITIES DATA
$proj_data = getdataobjectfromurl($proj_activity_url);

// var_dump($hr_data);

// STAFF ORDER BY SENIORITY FOR REFERENCE
$staff_order_array = ['USG ', 'ASG', 'D-2', 'D-1', 'P-5', 'P-4', 'P-3', 'P-2', 'P-1', 'GS'];
$staff_order_array_all = ['USG ', 'ASG', 'D-2', 'D-1', 'P-5', 'P-4', 'P-3', 'P-2', 'P-1', 'G-7', 'G-6', 'G-5', 'G-4', 'G-3', 'G-2', 'G-1', 'NO-A', 'NO-B', 'NO-C', 'NO-D'];

$divisionlist = array('Economy', 'Disasters and Conflicts', 'Law', 'Communication', 'Ecosystems', 'Science');
$officelist = array('Europe', 'Latin America', 'Asia Pacific', 'Africa', 'West Asia');

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

$total_count_projects_duration_between0_2 = 0;
$total_count_projects_duration_between2_5 = 0;
$total_count_projects_duration_between5_10 = 0;
$total_count_projects_duration_more10 = 0;

$total_projects_duration = 0;

$total_count_projects_age_between0_2 = 0;
$total_count_projects_age_between2_5 = 0;
$total_count_projects_age_between5_10 = 0;
$total_count_projects_age_more10 = 0;
$total_projects_age = 0;

$total_activities = 0;
$total_completed_activities = 0;
$total_outputs = 0;
//$overall_percentage_completed_activitiesA = 0;
$total_avg_activities_completed = 0;

$total_projects_timetaken = 0;

$overall_vacant_posts = [];
$overall_filled_posts = [];
$total_vacant_posts = 0;
$total_filled_posts = 0;
$total_posts = 0;
$mc_completed_staff = 0;
$epass_compliant_staff = 0;

$unique_post_groups = [];
$unique_posts_data = [];

$unique_subprogrammes = [];
$unique_subprogramme_data = [];
$unique_final_ratings = [0];

//USE DATA FROM API TO FEED THE UNIQUE SUBPROGRAMMES AND FINAL RATINGS ARRAY
$x = 2;
foreach ($division_data as $key => $value) {
    $sp_name = strtolower($value->subprogramme);
    if (array_search($sp_name, $unique_subprogrammes) < 1) {
        $unique_subprogrammes[$x] = $sp_name;
        $unique_subprogramme_data[] = ["subprogramme" => $sp_name, "subprogramme_number" => $value->sp_number, "projects" => 1, "divisions" => [$value->managing_division]];
    } else {

        foreach ($unique_subprogramme_data as $skey => $svalue) {
            if ($sp_name == $svalue['subprogramme']) {

                $unique_subprogramme_data[$skey]['projects'] += 1;
                $unique_subprogramme_data[$skey]['divisions'][] = $value->managing_division;

            }}
    }
    $x += 1;

    if (!$value->final_rating) {
        $f_rating = 0;
    } else {
        $f_rating = $value->final_rating;
    }

    if (!in_array($f_rating, $unique_final_ratings)) {
        $unique_final_ratings[] = $f_rating;
    }
}
rsort($unique_final_ratings);

//USE DATA FROM API TO FEED THE UNIQUE POST POSITIONS ARRAY
$staff_dutystations = [];
$staff_contracttypes_usg = [];
$staff_contracttypes_asg = [];
$staff_contracttypes_d2 = [];
$staff_contracttypes_d1 = [];
$staff_contracttypes_p5 = [];
$staff_contracttypes_p4 = [];
$staff_contracttypes_p3 = [];
$staff_contracttypes_p2 = [];
$staff_contracttypes_p1 = [];
$staff_contracttypes_gs = [];
$staff_contracttypes_no = [];
$staff_contracttypes_others = [];

$staff_contracttypes_continuing = [0,0,0,0,0,0,0];
$staff_contracttypes_fixedterm = [0,0,0,0,0,0,0];
$staff_contracttypes_permanent = [0,0,0,0,0,0,0];
$staff_contracttypes_temporary = [0,0,0,0,0,0,0];
$staff_contracttypes_undefined = [0,0,0,0,0,0,0];


$staff_nationality = [];
$staff_regionality = [];
$staff_offices = [];

foreach ($hr_data as $key => $value) {
    //$position = (substr($value->pos_ps_group, 1, 1) !== "-") ? substr($value->pos_ps_group, 0, 1) . "-" . substr($value->pos_ps_group, 1, 1) : $value->pos_ps_group;
    if (substr($value->pos_ps_group, 0, 1) == "P" && substr($value->pos_ps_group, 1, 1) !== "-") {
        $position = substr($value->pos_ps_group, 0, 1) . "-" . substr($value->pos_ps_group, 1, 1);
    } else {
        $position = $value->pos_ps_group;
    }
    if ($value->pers_no > 0) {
        $staff_dutystations[] = ltrim(rtrim($value->duty_station));
        if (ltrim(rtrim($value->contract_type)) == "Continuing") {
            if ($position == "USG") {
                //$staff_contracttypes_continuing[0]++;
            } else if ($position == "ASG") {
                //$staff_contracttypes_continuing[1]++;
            } else if ($position == "D-2") {
                $staff_contracttypes_continuing[0]++;
            } else if ($position == "D-1") {
                $staff_contracttypes_continuing[1]++;
            } else if ($position == "P-5") {
                $staff_contracttypes_continuing[2]++;
            } else if ($position == "P-4") {
                $staff_contracttypes_continuing[3]++;
            } else if ($position == "P-3") {
                $staff_contracttypes_continuing[4]++;
            } else if ($position == "P-2") {
                $staff_contracttypes_continuing[5]++;
            } else if (substr($value->pos_ps_group, 0, 1) == "G") {
                $staff_contracttypes_continuing[6]++;
            } else if (substr($value->pos_ps_group, 0, 2) == "NO") {
                //$staff_contracttypes_continuing[9]++;
            } else {
                //$staff_contracttypes_continuing[10]++;
            }
        } else if (ltrim(rtrim($value->contract_type)) == "Fixed Term") {
            if ($position == "USG") {
                //$staff_contracttypes_fixedterm[0]++;
            } else if ($position == "ASG") {
                //$staff_contracttypes_fixedterm[1]++;
            } else if ($position == "D-2") {
                $staff_contracttypes_fixedterm[0]++;
            } else if ($position == "D-1") {
                $staff_contracttypes_fixedterm[1]++;
            } else if ($position == "P-5") {
                $staff_contracttypes_fixedterm[2]++;
            } else if ($position == "P-4") {
                $staff_contracttypes_fixedterm[3]++;
            } else if ($position == "P-3") {
                $staff_contracttypes_fixedterm[4]++;
            } else if ($position == "P-2") {
                $staff_contracttypes_fixedterm[5]++;
            } else if (substr($value->pos_ps_group, 0, 1) == "G") {
                $staff_contracttypes_fixedterm[6]++;
            } else if (substr($value->pos_ps_group, 0, 2) == "NO") {
                //$staff_contracttypes_fixedterm[9]++;
            } else {
                //$staff_contracttypes_fixedterm[10]++;
            }
        } else if (ltrim(rtrim($value->contract_type)) == "Permanent") {
            if ($position == "USG") {
                //$staff_contracttypes_permanent[0]++;
            } else if ($position == "ASG") {
                //$staff_contracttypes_permanent[1]++;
            } else if ($position == "D-2") {
                $staff_contracttypes_permanent[0]++;
            } else if ($position == "D-1") {
                $staff_contracttypes_permanent[1]++;
            } else if ($position == "P-5") {
                $staff_contracttypes_permanent[2]++;
            } else if ($position == "P-4") {
                $staff_contracttypes_permanent[3]++;
            } else if ($position == "P-3") {
                $staff_contracttypes_permanent[4]++;
            } else if ($position == "P-2") {
                $staff_contracttypes_permanent[5]++;
            } else if (substr($value->pos_ps_group, 0, 1) == "G") {
                $staff_contracttypes_permanent[6]++;
            } else if (substr($value->pos_ps_group, 0, 2) == "NO") {
                //$staff_contracttypes_permanent[9]++;
            } else {
                //$staff_contracttypes_permanent[10]++;
            }
        } else if (ltrim(rtrim($value->contract_type)) == "Temporary") {
            if ($position == "USG") {
                //$staff_contracttypes_temporary[0]++;
            } else if ($position == "ASG") {
                //$staff_contracttypes_temporary[1]++;
            } else if ($position == "D-2") {
                $staff_contracttypes_temporary[0]++;
            } else if ($position == "D-1") {
                $staff_contracttypes_temporary[1]++;
            } else if ($position == "P-5") {
                $staff_contracttypes_temporary[2]++;
            } else if ($position == "P-4") {
                $staff_contracttypes_temporary[3]++;
            } else if ($position == "P-3") {
                $staff_contracttypes_temporary[4]++;
            } else if ($position == "P-2") {
                $staff_contracttypes_temporary[5]++;
            } else if (substr($value->pos_ps_group, 0, 1) == "G") {
                $staff_contracttypes_temporary[6]++;
            } else if (substr($value->pos_ps_group, 0, 2) == "NO") {
                //$staff_contracttypes_temporary[9]++;
            } else {
                //$staff_contracttypes_temporary[10]++;
            }
        } else {
            /*if ($position == "USG") {
                //$staff_contracttypes_undefined[0]++;
            } else if ($position == "ASG") {
                //$staff_contracttypes_undefined[1]++;
            } else if ($position == "D-2") {
                $staff_contracttypes_undefined[0]++;
            } else if ($position == "D-1") {
                $staff_contracttypes_undefined[1]++;
            } else if ($position == "P-5") {
                $staff_contracttypes_undefined[2]++;
            } else if ($position == "P-4") {
                $staff_contracttypes_undefined[3]++;
            } else if ($position == "P-3") {
                $staff_contracttypes_undefined[4]++;
            } else if ($position == "P-2") {
                $staff_contracttypes_undefined[5]++;
            } else if (substr($value->pos_ps_group, 0, 1) == "G") {
                $staff_contracttypes_undefined[6]++;
            } else if (substr($value->pos_ps_group, 0, 2) == "NO") {
                $staff_contracttypes_undefined[7]++;
            } else {
                $staff_contracttypes_undefined[8]++;
            }*/
            if ($position == "USG") {
                //$staff_contracttypes_fixedterm[0]++;
            } else if ($position == "ASG") {
                //$staff_contracttypes_fixedterm[1]++;
            } else if ($position == "D-2") {
                $staff_contracttypes_fixedterm[0]++;
            } else if ($position == "D-1") {
                $staff_contracttypes_fixedterm[1]++;
            } else if ($position == "P-5") {
                $staff_contracttypes_fixedterm[2]++;
            } else if ($position == "P-4") {
                $staff_contracttypes_fixedterm[3]++;
            } else if ($position == "P-3") {
                $staff_contracttypes_fixedterm[4]++;
            } else if ($position == "P-2") {
                $staff_contracttypes_fixedterm[5]++;
            } else if (substr($value->pos_ps_group, 0, 1) == "G") {
                $staff_contracttypes_fixedterm[6]++;
            } else if (substr($value->pos_ps_group, 0, 2) == "NO") {
                //$staff_contracttypes_fixedterm[9]++;
            } else {
                //$staff_contracttypes_fixedterm[10]++;
            }
        }

        $staff_contracttypes[] = ltrim(rtrim($value->contract_type));
        $staff_nationality[] = ltrim(rtrim($value->nationality));
        $staff_offices[] = ltrim(rtrim($value->office));
        $staff_regionality[] = ltrim(rtrim($value->region));
        /*if (ltrim(rtrim($value->office)) == "") {
            echo ltrim(rtrim($value->first_name))." ".ltrim(rtrim($value->last_name))."<br/>";
        }*/
    }
    if (!in_array($position, $unique_post_groups)) {
        if ($value->pers_no > 0) {
            if ($value->gender == 'Male') {
                $male = 1;
                $female = 0;
            } elseif ($value->gender == 'Female') {
                $male = 0;
                $female = 1;
            }
            $unique_posts_data[] = ["post" => $position, "vacant" => 0, "filled" => 1, "filled_male" => $male, "filled_female" => $female, "offices_post_vacant" => [], "offices_post_filled" => [$value->office]];
            $total_filled_posts += 1;
            $overall_filled_posts[array_search($position, $staff_order_array)] = $position;
        } else {
            $unique_posts_data[] = ["post" => $position, "vacant" => 1, "filled" => 0, "filled_male" => 0, "filled_female" => 0, "offices_post_vacant" => [$value->office], "offices_post_filled" => []];
            $total_vacant_posts += 1;
            $overall_vacant_posts[array_search($position, $staff_order_array)] = $position;
        }
        $unique_post_groups[] = $position;
    } else {
        foreach ($unique_posts_data as $pkey => $pvalue) {
            if ($position == $pvalue['post']) {
                if ($value->pers_no > 0) {
                    if ($value->gender == 'Male') {
                        $unique_posts_data[$pkey]['filled_male'] += 1;

                    } elseif ($value->gender == 'Female') {
                        $unique_posts_data[$pkey]['filled_female'] += 1;
                    }

                    $unique_posts_data[$pkey]['filled'] += 1;
                    $unique_posts_data[$pkey]['offices_post_filled'][] = $value->office;
                    $total_filled_posts += 1;
                    $overall_filled_posts[] = $position;

                } else {
                    $unique_posts_data[$pkey]['vacant'] += 1;
                    $unique_posts_data[$pkey]['offices_post_vacant'][] = $value->office;
                    $total_vacant_posts += 1;
                    $overall_vacant_posts[] = $position;
                }
            }
        }
    }
    $total_posts += 1;

    if ($value->document_stage === 'SM Self & FRO Evaluation' || $value->document_stage === 'COMPLETED') {
        $epass_compliant_staff++;
    }
    if ($value->no_of_mandatory_courses_done === '9' || $value->no_of_mandatory_courses_done === 9) {
        $mc_completed_staff++;
    }
}

foreach (array_count_values($staff_offices) as $key => $value) {
    $key = ($key == "") ? "Undefined" : $key;
    $staffoffices_data[] = [
        "name" => $key,
        "count" => $value,
    ];
}

array_multisort(array_column($staffoffices_data, 'count'), SORT_DESC, $staffoffices_data);
$staffoffices_xaxis = [];
$staffoffices_series = [];
foreach ($staffoffices_data as $key => $value) {
    $staffoffices_xaxis[] = $value["name"];
    $staffoffices_series[] = (-1*$value["count"]);
}



    /*$staffoffices_xaxis[] = $key;
    $staffoffices_series[] = (-1*$value);*/

/*echo "<pre>";
echo "Continuing: ".json_encode($staff_contracttypes_continuing)."<br/>";
echo "Fixed Term: ".json_encode($staff_contracttypes_fixedterm)."<br/>";
echo "</pre>";
exit;*/
$pctg_mc_completion = round(($mc_completed_staff / $total_filled_posts) * 100);
$pctg_epass_compliance = round(($epass_compliant_staff / $total_filled_posts) * 100);

//$total_filled_posts = 0;
// var_dump($unique_posts_data);
/*foreach ($hr_data as $key => $value) {
    if ($value->pers_no > 0) {
        $overall_filled_posts[] = $value;
        $total_filled_posts += 1;

    } else {
        $overall_vacant_posts[] = $value;
        $total_vacant_posts += 1;
    }
    $total_posts += 1;
}*/
$consultantoffice_data = [];
foreach ($staffoffices_xaxis as $key => $value) {
    $consultantoffice_data[$value] = 0;
}
$activeconsultants = 0;
$overall_consultants = [];
foreach ($consultants_data as $consultancy) {
    $office = ltrim(rtrim($consultancy->office));
    if ($office == "Latin American Caribbean") {
        $office = "Latin America";
    } else if ($office == "New York") {
        $office = "New York Office";
    } else if ($office == "Executive") {
        $office = "Executive Office";
    }
    if (checkexpired($consultancy->latest_contract_end_date) == "NO") {
        if (in_array($office, $staffoffices_xaxis)) {
            $activeconsultants++;
            $consultantoffice_data[$office]++;
        }
    }
    $overall_consultants[] = [
        'names' => $consultancy->supplier_full_name,
        'startdate' => $consultancy->latest_contract_start_date,
        'enddate' => $consultancy->latest_contract_end_date,
        'renewals' => $consultancy->no_of_contract_renewals,
        'expired' => checkexpired($consultancy->latest_contract_end_date),
        'duration' => getdaysbetween($consultancy->latest_contract_start_date, $consultancy->latest_contract_end_date),
        'morethan11months' => (getdaysbetween($consultancy->latest_contract_start_date, $consultancy->latest_contract_end_date) > 30 * 11 ? 'Yes' : 'No')
    ];

    
}
$consultantoffice_series = [];
foreach ($consultantoffice_data as $key => $value) {
    $consultantoffice_series[] = $value;
}

$overall_post_status_distribution = [];
$overall_office_budget_distribution = [];
$overall_office_budget_distribution_office = [];
$overall_office_budget_distribution_region = [];
$overall_office_budget_distribution_others = [];
$overall_grant_keys = [];
$overall_grant_amounts = [];
$overall_grant_start = [];
$overall_grant_end = [];
$overall_grant_aging = [];
$overall_grant_unique_keys = [];

$t_filled_posts = 0;
$t_vacant_posts = 0;
$t_posts = 0;

$t_filled_male_count = 0;
$t_filled_female_count = 0;

foreach ($all_grants_data as $gkey => $gvalue) {
    $overall_grant_keys[] = $gvalue->grant_key;
    $overall_grant_amounts[] = $gvalue->grant_cash_balance;
    $overall_grant_start[] = $gvalue->grant_valid_from;
    $overall_grant_end[] = $gvalue->grant_valid_to;
    $overall_grant_aging[] = ceil(getdaysbetween(null, $gvalue->grant_valid_to) / 30);
}

// Overall Grant Information
$overall_grantsdata = [];
foreach ($all_grants_details as $detkey => $detvalue) {
    if (!in_array($detvalue->grant_key, $overall_grant_unique_keys)) {
        foreach ($all_grants_data as $gkey => $gvalue) {
            if ($gvalue->grant_key == $detvalue->grant_key) {
                $overall_grant_unique_keys[] = $gvalue->grant_key;
                $overall_grantsdata[] = ["office"=> $detvalue->office,"grantkey" => $gvalue->grant_key, "grantamount" => $gvalue->grant_cash_balance, "grantstartdate" => $gvalue->grant_valid_from, "grantenddate" => $gvalue->grant_valid_to, "grantexpired" => checkexpired($gvalue->grant_valid_to), "grantaging" => ceil(getdaysbetween(null, $gvalue->grant_valid_to) / 30)];
            }
        }
    }
}

// Overall Risks Information
$overall_risksdata = [];
foreach ($risks_data as $rkey => $rvalue) {
    $overall_risksdata[] = ["office" => $rvalue->managing_division, "riskname" => $rvalue->risk, "projectcount" => $rvalue->number_of_projects, "year" => $rvalue->year];
}

foreach ($unique_posts_data as $pkey => $pvalue) {

    if ($pvalue['post'] !== '') {
        $t_filled_count = 0;
        $t_vacant_count = 0;
        $t_filled_male = 0;
        $t_filled_female = 0;

        foreach ($pvalue['offices_post_filled'] as $okey => $ovalue) {
            $t_filled_count += 1;
        }

        foreach ($pvalue['offices_post_vacant'] as $okey => $ovalue) {
            $t_vacant_count += 1;
        }
        $t_filled_male += $pvalue['filled_male'];
        $t_filled_female += $pvalue['filled_female'];

        if ($pvalue['post'] == 'INT-I' || $pvalue['post'] == 'INT-II') {

        } else {
            $overall_post_status_distribution[] = ["post" => $pvalue['post'], "filled" => $t_filled_count, "filled_male" => $t_filled_male, "filled_female" => $t_filled_female, "vacant" => $t_vacant_count];
        }

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

foreach ($activities_data as $key => $value) {
    $total_activities += $value->total_activities;
    $total_completed_activities += $value->completed_activities;
    $total_outputs += $value->total_outputs;
}
//$overall_percentage_completed_activitiesA = round($total_completed_activities / $total_activities, 2) * 100;

foreach ($division_data as $key => $value) {
    $startDate = strtotime($value->StartDate);
    $endDate = strtotime($value->EndDate);
    $datediff = $endDate - $startDate;
    $project_days_duration = round($datediff / (60 * 60 * 24));
    $total_project_days += $project_days_duration;

    $startDatea = strtotime($value->StartDate);
    $endDatea = time();
    $datediffa = $endDatea - $startDatea;
    $project_days_age = round($datediffa / (60 * 60 * 24));

    $endDater = strtotime($value->EndDate);
    $startDater = time();
    $datediffr = $endDater - $startDater;
    $project_days_remaining = round($datediffr / (60 * 60 * 24));

    $total_projects_duration += $project_days_duration;
    $total_projects_age += $project_days_age;

    $total_projects += 1;
    $total_consumable_budget += $value->consumable_budget;
    $total_consumed_budget += $value->consumed_budget;
    $total_percentage_budget_utilized += $value->percentage_budget_utilized;
    $total_percentage_activities_completed += $value->percentage_activities_completed;
    if ($value->percentage_time_taken) {
        $total_projects_timetaken += $value->percentage_time_taken;
    } else {
        $total_projects_timetaken += 0;
    }

    if ($value->percentage_activities_completed) {
        $total_avg_activities_completed += $value->percentage_activities_completed;
    }

    if ($project_days_duration > 3648) {
        $total_count_projects_duration_more10 += 1;

    } elseif ($project_days_duration > 1820) {
        $total_count_projects_duration_between5_10 += 1;

    } elseif ($project_days_duration > 730) {
        $total_count_projects_duration_between2_5 += 1;

    } else {
        $total_count_projects_duration_between0_2 += 1;
    }
    if ($project_days_age > 3648) {
        $total_count_projects_age_more10 += 1;

    } elseif ($project_days_age > 1820) {
        $total_count_projects_age_between5_10 += 1;

    } elseif ($project_days_age > 730) {
        $total_count_projects_age_between2_5 += 1;

    } else {
        $total_count_projects_age_between0_2 += 1;

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

    if (isset($value->days_past_due)) {
        if ($value->days_past_due > 0) {
            $total_past_due_projects += 1;
        } else {
            if ($value->days_past_due > -174) {
                $total_projects_expiringin6 += 1;
            }
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
//OVERALL PROJECT INFORMATION
$overall_project_information = [];
foreach ($division_data as $prkey => $prvalue) {
    if (!$prvalue->final_rating) {
        $reported = 'NO';
    } else {
        $reported = 'YES';
    }

    $p_outputs = 0;
    $p_completed_activities = 0;
    $p_activities = 0;

    foreach ($proj_data as $pakey => $pavalue) {
        if ($pavalue->projectID == $prvalue->project_id) {
            $p_outputs = $pavalue->total_outputs;
            $p_completed_activities = $pavalue->completed_activities;

            $p_activities = $pavalue->total_activities;

        }
    }

    if (!$prvalue->final_rating) {
        $project_rating = 'N/A';
    } else {
        $f_rating = $prvalue->final_rating;
        $project_rating = array_search($f_rating, $unique_final_ratings) + 1;
    }

    $overall_project_information[] = [
        'project_id' => $prvalue->project_id,
        'project_title' => $prvalue->project_title,
        'subprogramme' => $prvalue->subprogramme,
        'budget' => $prvalue->consumable_budget,
        'system_rating' => $prvalue->system_rating,
        'management_rating' => $prvalue->manager_rating,
        'reported' => $reported,
        'project_manager' => $prvalue->project_manager,
        'project_rank' => $project_rating,
        'outputs' => $p_outputs,
        'completed_activities' => $p_completed_activities,
        'total_activities' => $p_activities,
    ];
}

//OVERALL STAFF INFORMATION
$overall_staff_information = [];
$p_status = '';
foreach ($hr_data as $hkey => $hvalue) {
    if ($hvalue->pers_no > 0) {
        $filled = true;
        $p_status = 'FILLED';
    } else {
        $filled = false;
        $p_status = 'VACANT';
    }
    $overall_staff_information[] = [
        'grade' => (substr($hvalue->pos_ps_group, 1, 1) !== "-") ? substr($hvalue->pos_ps_group, 0, 1) . "-" . substr($hvalue->pos_ps_group, 1, 1) : $hvalue->pos_ps_group,
        'position_title' => $hvalue->pos_title,
        'position_number' => $hvalue->pos_id,
        'duty_station' => $hvalue->duty_station,
        'position_status' => $p_status,
        'staff_name' => $hvalue->first_name . ' ' . $hvalue->last_name,
        'contract_type' => $hvalue->contract_type,
        'fund_key' => $hvalue->fund_key,
        'fund_description' => $hvalue->fund_description,
        'category' => $hvalue->category,
        'org_code' => $hvalue->org_unit,
        'org_unit_description' => $hvalue->org_unit_desc,
        'order' => array_search((substr($hvalue->pos_ps_group, 0, 1) !== "-") ? substr($hvalue->pos_ps_group, 0, 1) . "-" . substr($hvalue->pos_ps_group, 1, 1) : $hvalue->pos_ps_group, $staff_order_array_all),
        'final_status' => $hvalue->document_final_status,
        'stage' => $hvalue->document_stage,
        'mandatory_training' => $hvalue->no_of_mandatory_courses_done,
        'all_training' => $hvalue->no_of_total_courses_done,
        'contract_expiry' => $hvalue->appt_exp,
        'retirement_date' => $hvalue->retirement_date
    ];
}

$total_percentage_projects_budget_between0_1 = round($total_count_projects_budget_between0_1 / $total_projects, 2) * 100;
$total_percentage_projects_budget_between1_2 = round($total_count_projects_budget_between1_2 / $total_projects, 2) * 100;
$total_percentage_projects_budget_between2_5 = round($total_count_projects_budget_between2_5 / $total_projects, 2) * 100;
$total_percentage_projects_budget_between5_10 = round($total_count_projects_budget_between5_10 / $total_projects, 2) * 100;
$total_percentage_projects_budget_more10 = round($total_count_projects_budget_more10 / $total_projects, 2) * 100;

$total_reporting_percentage = round(($total_reported_projects / $total_projects), 2) * 100;

$overall_average_consumable = round($total_consumable_budget / $total_projects, 2);
$overall_average_project_days_duration = round($total_project_days / $total_projects);
$overall_average_project_years_duration = round($overall_average_project_days_duration / 365.25, 1);

$overall_average_project_health = round($total_project_health / $total_projects, 1);

$total_average_percentage_budget_utilized = round($total_percentage_budget_utilized / $total_projects, 1) * 100;

$total_average_system_rating = round($total_system_rating / $total_projects, 1);
$total_average_manager_rating = round($total_manager_rating / $total_projects, 1);
$total_average_final_rating = round($total_final_rating / $total_projects, 1);

$overall_pctg_duration_used = round($total_projects_age / $total_projects_duration, 2) * 100;

$overall_avg_projects_timetaken = round($total_projects_timetaken / $total_projects, 2) * 100;

//DECLARE THE DIVISIONS ARRAY TO STORE UNIQUES DIVISIONS
$unique_divisions = [];

//DECLARE THE BRANCHES ARRAY TO STORE UNIQUES BRANCHES
$unique_branches = [];

$subprogrammes_project_distribution = [];
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

//echo '<br />---------------------DIVISIONAL DATA--------------------<br /><br />';
$total_scatter_points_red = [];
$total_scatter_points_yellow = [];
$total_scatter_points_green = [];
$total_overan_days = 0;
$total_overan_months = 0;

$total_project_pctgtimetaken = 0;

$overall_sp_array = [];
$overall_sp_array['spnames'] = [];
$overall_sp_array['spnumbers'] = [];
$overall_sp_array['projectcount'] = [];

$o_staff_information = [];

$o_subprogramme_projects_distribution = [];

$t_past_projects = 0;

$divisional_overan_days = 0;
$divisional_past_projects = 0;

$regional_overan_days = 0;
$regional_past_projects = 0;

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

    $d_final_ratings = 0;

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

    $d_count_projects_duration_between0_2 = 0;
    $d_count_projects_duration_between2_5 = 0;
    $d_count_projects_duration_between5_10 = 0;
    $d_count_projects_duration_more10 = 0;
    $d_projects_duration = 0;

    $d_count_projects_age_between0_2 = 0;
    $d_count_projects_age_between2_5 = 0;
    $d_count_projects_age_between5_10 = 0;
    $d_count_projects_age_more10 = 0;
    $d_projects_age = 0;

    $d_activities = 0;
    $d_completed_activities = 0;
    $d_outputs = 0;
    $d_percentage_completed_activities = 0;
    $d_percentage_completed_activitiesA = 0;

    $d_project_pctgtimetaken = 0;

    $d_vacant_posts = [];
    $d_filled_posts = [];
    $d_vacant_posts = 0;
    $d_filled_posts = 0;
    $d_posts = 0;
    $d_filled_male_count = 0;
    $d_filled_female_count = 0;

    //DIVISION PROJECT INFORMATION
    $d_project_information = [];
    $d_project_branch = [''];
    $d_scatter_points = [];
    $d_scatter_points_red = [];
    $d_scatter_points_yellow = [];
    $d_scatter_points_green = [];
    $d_overan_days = 0;

    $d_red_projects = 0;
    $d_yellow_projects = 0;
    $d_green_projects = 0;

    $d_senior_posts = 0;

    $d_short_projects = 0;

    $d_past_projects = 0;

    foreach ($division_data as $prkey => $prvalue) {
        if ($prvalue->managing_division == $dvalue) {
            if (!in_array($prvalue->managing_branch, $d_project_branch)) {
                $d_project_branch[] = $prvalue->managing_branch;
            }
            $endDater = strtotime($prvalue->EndDate);
            $startDater = time();
            $datediffr = $endDater - $startDater;
            $project_days_remaining = round($datediffr / (60 * 60 * 24));

            if ($prvalue->EndDate) {
                if ($project_days_remaining < 0) {
                    $project_months_remaining = floor($project_days_remaining / 30);
                } else {
                    $project_months_remaining = ceil($project_days_remaining / 30);
                }
            } else {
                $project_months_remaining = 'No Enddate';
            }

            // if ($project_days_remaining < 0) {
            //     $d_overan_days += $project_days_remaining;
            //     $total_overan_days += $project_days_remaining;

            // }

            if (isset($prvalue->days_past_due) && $prvalue->days_past_due > 0) {
                $d_past_projects += 1;
                $t_past_projects += 1;

                $d_overan_days += $prvalue->days_past_due;
                $total_overan_days += $prvalue->days_past_due;

                if (in_array($dvalue, $officelist)) {
                    $regional_overan_days += $prvalue->days_past_due;
                    $regional_past_projects += 1;
                } else {
                    $divisional_overan_days += $prvalue->days_past_due;
                    $divisional_past_projects += 1;
                }
            }

            if (!$prvalue->final_rating) {
                $reported = 'NO';
            } else {
                $reported = 'YES';
            }

            $p_outputs = 0;
            $p_completed_activities = 0;
            $p_activities = 0;

            foreach ($proj_data as $pakey => $pavalue) {
                if ($pavalue->projectID == $prvalue->project_id) {
                    $p_outputs = $pavalue->total_outputs;
                    $p_completed_activities = $pavalue->completed_activities;

                    $p_activities = $pavalue->total_activities;

                }
            }

            if (!$prvalue->final_rating) {
                $project_rating = 'N/A';
                $fr = 0;
            } else {
                $f_rating = $prvalue->final_rating;
                $project_rating = array_search($f_rating, $unique_final_ratings) + 1;
                $fr = floatval(number_format((float) $prvalue->final_rating, 2, '.', ''));
            }
            //feed into scatter points -> consumable budget, rating
            $d_scatter_points[] = [intval($prvalue->consumable_budget), $fr];

            if ($fr >= 2.5) {
                //green
                $d_scatter_points_green[] = [$fr, intval($prvalue->consumable_budget)];
                $total_scatter_points_green[] = [$fr, intval($prvalue->consumable_budget)];
                $d_green_projects += 1;
            } elseif ($fr >= 1.5) {
                // yellow
                $d_scatter_points_yellow[] = [$fr, intval($prvalue->consumable_budget)];
                $total_scatter_points_yellow[] = [$fr, intval($prvalue->consumable_budget)];
                $d_yellow_projects += 1;
            } else {
                //red
                $d_scatter_points_red[] = [$fr, intval($prvalue->consumable_budget)];
                $total_scatter_points_red[] = [$fr, intval($prvalue->consumable_budget)];
                $d_red_projects += 1;
            }

            $d_project_information[] = [
                'project_id' => $prvalue->project_id,
                'project_title' => $prvalue->project_title,
                'subprogramme' => $prvalue->subprogramme,
                'sp_number' => $prvalue->sp_number,
                'branch' => $prvalue->managing_branch,
                'budget' => $prvalue->consumable_budget,
                'system_rating' => $prvalue->system_rating,
                'management_rating' => $prvalue->manager_rating,
                'final_rating' => $prvalue->final_rating,
                'reported' => $reported,
                'project_manager' => $prvalue->project_manager,
                'project_rank' => $project_rating,
                'outputs' => $p_outputs,
                'completed_activities' => $p_completed_activities,
                'total_activities' => $p_activities,
                'days_remaining' => $project_days_remaining,
                'months_remaining' => $project_months_remaining,
                'order' => array_search($prvalue->managing_branch, $d_project_branch),
            ];
        }
    }

    //DIVISIONAL STAFF INFORMATION
    $d_staff_information = [];
    foreach ($hr_data as $hkey => $hvalue) {
        if ($hvalue->office == $dvalue) {
            if ($hvalue->pos_ps_group == 'D-2' || $hvalue->pos_ps_group == 'D-1' || $hvalue->pos_ps_group == 'P-5') {
                $d_senior_posts += 1;
            }
            if ($hvalue->pers_no > 0) {
                $p_status = 'FILLED';
            } else {
                $p_status = 'VACANT';
            }
            $d_staff_information[] = [
                'grade' => $hvalue->pos_ps_group,
                'position_title' => $hvalue->pos_title,
                'position_number' => $hvalue->pos_id,
                'duty_station' => $hvalue->duty_station,
                'position_status' => $p_status,
                'staff_name' => $hvalue->first_name . ' ' . $hvalue->last_name,
                'fund_key' => $hvalue->fund_key,
                'fund_description' => $hvalue->fund_description,
                'category' => $hvalue->category,
                'org_code' => $hvalue->org_unit,
                'org_unit_description' => $hvalue->org_unit_desc,
                'order' => array_search($hvalue->pos_ps_group, $staff_order_array_all),

            ];
        }
    }

    usort($d_staff_information, 'sortByOrder');

    foreach ($d_staff_information as $key => $value) {
        $value['division'] = $dvalue;
        $o_staff_information[] = $value;
    }

    $d_post_status_distribution = [];

    foreach ($unique_posts_data as $pkey => $pvalue) {

        if ($pvalue['post'] !== '') {
            $d_filled_count = 0;
            $d_vacant_count = 0;
            $d_filled_male = 0;
            $d_filled_female = 0;

            foreach ($pvalue['offices_post_filled'] as $okey => $ovalue) {

                if ($ovalue == $dvalue) {
                    $d_filled_count += 1;

                }

            }

            foreach ($pvalue['offices_post_vacant'] as $okey => $ovalue) {
                if ($ovalue == $dvalue) {
                    $d_vacant_count += 1;
                }

            }

            foreach ($hr_data as $hkey => $hvalue) {
                # code...
                if ($hvalue->office == $dvalue && $hvalue->pos_ps_group == $pvalue['post']) {
                    if ($hvalue->pers_no > 0) {
                        if ($hvalue->gender == 'Male') {
                            $d_filled_male += 1;
                        } elseif ($hvalue->gender == 'Female') {

                            $d_filled_female += 1;

                        }
                    } else {

                    }
                }
            }

            $d_post_status_distribution[] = ["post" => $pvalue['post'], "filled" => $d_filled_count, "filled_male" => $d_filled_male, "filled_female" => $d_filled_female, "vacant" => $d_vacant_count];

            $d_filled_posts += $d_filled_count;
            $d_vacant_posts += $d_vacant_count;

            $d_filled_male_count += $d_filled_male;
            $d_filled_female_count += $d_filled_female;

            $d_posts += $d_filled_count + $d_vacant_count;

        }
    }
    $d_subprogramme_projects_distribution = [];

    foreach ($unique_subprogramme_data as $key => $value) {
        $sp_projects_count = 0;
        foreach ($value['divisions'] as $udkey => $udvalue) {
            if ($udvalue == $dvalue) {
                $sp_projects_count += 1;
            }
        }
        $d_subprogramme_projects_distribution[$value['subprogramme_number']] = ["order" => $value['subprogramme_number'], "subprogramme" => $value['subprogramme'], "subprogramme_number" => $value['subprogramme_number'], "projects" => $sp_projects_count];

    }

    usort($d_subprogramme_projects_distribution, 'sortByOrder');
    usort($o_subprogramme_projects_distribution, 'sortByOrder');

    foreach ($activities_data as $key => $value) {
        if ($value->managing_division == $dvalue) {
            $d_activities += $value->total_activities;
            $d_completed_activities += $value->completed_activities;
            $d_outputs += $value->total_outputs;
        }
    }
    //$d_percentage_completed_activitiesA = round($d_completed_activities / $d_activities, 2) * 100;

    foreach ($division_data as $key => $value) {
        if ($value->managing_division == $dvalue) {

            $startDate = strtotime($value->StartDate);
            $endDate = strtotime($value->EndDate);
            $datediff = $endDate - $startDate;
            $project_days_duration = round($datediff / (60 * 60 * 24));
            $d_project_days += $project_days_duration;

            $startDatea = strtotime($value->StartDate);
            $endDatea = time();
            $datediffa = $endDatea - $startDatea;
            $project_days_age = round($datediffa / (60 * 60 * 24));
            // $project_days_age = getdaysbetween($startDate, null);

            // echo 'From ' . $value->StartDate . ' to Now, age by days -' . $project_days_age . ' <br />';

            if ($value->percentage_time_taken != null) {
                $d_project_pctgtimetaken += $value->percentage_time_taken;
                $total_project_pctgtimetaken += $value->percentage_time_taken;
            } else {
                $d_project_pctgtimetaken += 0;
                $total_project_pctgtimetaken += 0;
            }

            $d_projects += 1;
            $d_final_ratings += $value->final_rating;

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

            } else {
                $d_count_projects_duration_between0_2 += 1;

            }
            if ($project_days_age > 3648) {
                $d_count_projects_age_more10 += 1;

            } elseif ($project_days_age > 1820) {
                $d_count_projects_age_between5_10 += 1;

            } elseif ($project_days_age > 728) {
                $d_count_projects_age_between2_5 += 1;
                $d_short_projects += 1;

            } else {
                $d_count_projects_age_between0_2 += 1;
                $d_short_projects += 1;

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

            if (isset($value->days_past_due)) {
                if ($value->days_past_due > 0) {
                    $d_past_due_projects += 1;
                } else {
                    if ($value->days_past_due > -174) {
                        $d_projects_expiringin6 += 1;
                    }
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

    $d_total_average_system_rating = round($d_total_system_rating / $d_projects, 1);
    $d_total_average_manager_rating = round($d_total_manager_rating / $d_projects, 1);
    $d_total_average_final_rating = round($d_total_final_rating / $d_projects, 1);

    $d_percentage_of_budget_utilized = round($d_consumed_budget / $d_consumable_budget, 2) * 100;

    //$d_overall_pctg_duration_used = round( $d_projects_age / $d_projects_duration , 2)*100;

    $d_avg_project_pctgtimetaken_a = round($d_project_pctgtimetaken / $d_projects, 2) * 100;
    $d_average_percentage_activities_completed = round($d_percentage_activities_completed / $d_projects, 2) * 100;

    if ($d_overan_days == 0) {
        $d_average_overan_days = 0;
        $d_average_overan_monthsA = 0;
    } else {
        $d_average_overan_days = round($d_overan_days / $d_past_projects);
        $d_average_overan_monthsA = ceil($d_average_overan_days / 30);
        $total_overan_months += $d_average_overan_monthsA;
    }

    $G_d_staff_distribution = ["post" => 'GS', "filled" => 0, "filled_male" => 0, "filled_female" => 0, "vacant" => 0];

    foreach ($d_post_status_distribution as $key => $value) {
        if ($value['filled'] == 0 && $value['vacant'] == 0) {
            unset($d_post_status_distribution[$key]);
        }

        $firstCharacter = $value['post'][0];
        if ($firstCharacter == 'G' || $firstCharacter == 'N') {
            $G_d_staff_distribution['filled'] += $value['filled'];
            $G_d_staff_distribution['filled_male'] += $value['filled_male'];
            $G_d_staff_distribution['filled_female'] += $value['filled_female'];
            $G_d_staff_distribution['vacant'] += $value['vacant'];
            unset($d_post_status_distribution[$key]);
        }
    }

    $d_post_status_distribution[] = $G_d_staff_distribution;

    $unsorted_posts = $d_post_status_distribution;
    // $d_post_status_distribution = [];

    foreach ($d_post_status_distribution as $key => $value) {
        $position = intval(array_search($value['post'], $staff_order_array));
        $d_post_status_distribution[$key]['order'] = $position;
    }

    usort($d_post_status_distribution, 'sortByOrder');

    $d_post_categories = array();
    $d_post_filled = array();
    $d_post_filled_male = array();
    $d_post_filled_female = array();
    $d_post_vacant = array();

    foreach ($d_subprogramme_projects_distribution as $key => $value) {
        if (!$value['projects'] > 0) {
            unset($d_subprogramme_projects_distribution[$key]);
        }
    }

    // foreach ($d_subprogramme_projects_distribution as $key => $value) {
    //     echo $value['subprogramme'] . ' subprogramme, ' . $value['projects'] . ' projects <br />';
    // }

    // total poists,
    // vacancy rates - vacant/total,
    // ratio of total budget/ filled posts,
    // no red projects red, yellow,green,
    // total projects,
    // total post in d1,d2,p5 divided by total filled posts.(senior management compared to filled)
    // reporting compliance-
    // expired projects,
    // average months past due,
    // percentage projects projecst implemented 5 years and below.

    foreach ($d_post_status_distribution as $key => $value) {
        array_push($d_post_categories, $value['post']);
        array_push($d_post_filled, $value['filled']);
        if ($value['filled'] != 0 && $value['filled_male'] != 0) {
            array_push($d_post_filled_male, (1 * (100 * $value['filled_male'] / $value['filled'])));
        } else {
            array_push($d_post_filled_male, 0);
        }
        if ($value['filled'] != 0 && $value['filled_female'] != 0) {
            array_push($d_post_filled_female, (-1 * (100 * $value['filled_female'] / $value['filled'])));
        } else {
            array_push($d_post_filled_female, 0);
        }
        //array_push($d_post_filled_male, (-1*(100*$value['filled_male']/$value['filled'])));
        //array_push($d_post_filled_female, ((100*$value['filled_female']/$value['filled'])));
        array_push($d_post_vacant, $value['vacant']);
    }

    usort($d_project_information, 'sortByOrder');

    // display the division name its and number of projects
    //echo '<br />_____________' . $dvalue . ' Division/Office ______________<br /><br />';

    // $d_average_overan_days = round($d_overan_days / $d_past_projects);
    // $d_average_overan_months = ceil($d_average_overan_days / 30);

    // echo $d_overan_days . ' overan days <br />';
    // echo $d_past_projects . 'overan projects <br />';
    // echo $d_average_overan_days . ' average days <br />';
    // echo $d_average_overan_monthsA . ' average months';

    //var_dump($d_scatter_points);

    $divisionorder = in_array($dvalue, $divisionlist) ? 1 : 2;
    $filled_posts = $d_posts - $d_vacant_posts;

    //echo $d_projects;

    $overall_office_budget_distribution[] = [
        'office' => $dvalue,
        'consumable' => $d_consumable_budget,
        'consumed' => $d_consumed_budget,
        'balance' => $d_consumable_budget - $d_consumed_budget,
        'total_posts' => $d_posts,
        'filled_posts' => $filled_posts,
        'budget_staff_ratio' => round($d_consumable_budget / $filled_posts, 0),
        'vacant_posts' => $d_vacant_posts,
        'total_outputs' => $d_outputs,
        'total_activities' => $d_activities,
        'completed_activities' => $d_completed_activities,
        'percentage_vacancy' => round($d_vacant_posts / $d_posts, 2) * 100,
        'average_post_budget' => round($d_consumable_budget / $d_posts, 2),
        'total_projects' => $d_projects,
        'o_ratings' => $d_final_ratings,
        'red_projects' => $d_red_projects,
        'yellow_projects' => $d_yellow_projects,
        'green_projects' => $d_green_projects,
        'percentage_senior_posts' => round($d_senior_posts / $d_posts, 2) * 100,
        'reporting_compliance' => $d_reporting_percentage,
        'total_days_past_due' => $d_overan_days,
        'expired_projects' => $d_past_due_projects,
        'average_months_past_due' => $d_average_overan_monthsA,
        'short_projects_percentage' => round($d_short_projects / $d_projects, 2) * 100,
        'officeorder' => $divisionorder,
    ];

    if (in_array($dvalue, $divisionlist)) {
        $overall_office_budget_distribution_office[] = [
            'office' => $dvalue,
            'consumable' => $d_consumable_budget,
            'consumed' => $d_consumed_budget,
            'balance' => $d_consumable_budget - $d_consumed_budget,
            'total_posts' => $d_posts,
            'filled_posts' => ($d_posts - $d_vacant_posts),
            'vacant_posts' => $d_vacant_posts,
            'total_outputs' => $d_outputs,
            'total_activities' => $d_activities,
            'completed_activities' => $d_completed_activities,
            'percentage_vacancy' => round($d_vacant_posts / $d_posts, 2) * 100,
            'average_post_budget' => round($d_consumable_budget / $d_posts, 2),
            'o_projects' => $d_projects,
            'red_projects' => $d_red_projects,
            'yellow_projects' => $d_yellow_projects,
            'green_projects' => $d_green_projects,
            'total_projects' => $d_projects,//$total_projects,
            'o_ratings' => $d_final_ratings,
            'total_health' => $total_project_health,
            'final_rating' => $d_total_average_final_rating,
            'percentage_senior_posts' => round($d_senior_posts / $d_posts, 2) * 100,
            'reporting_compliance' => $d_reporting_percentage,
            'total_days_past_due' => $d_overan_days,
            'expired_projects' => $d_past_due_projects,
            'average_months_past_due' => $d_average_overan_monthsA,
            'short_projects_percentage' => round($d_short_projects / $d_projects, 2) * 100,
            'officeorder' => $divisionorder,
        ];
    } else if (in_array($dvalue, $officelist)) {
        $overall_office_budget_distribution_region[] = [
            'office' => $dvalue,
            'consumable' => $d_consumable_budget,
            'consumed' => $d_consumed_budget,
            'balance' => $d_consumable_budget - $d_consumed_budget,
            'total_posts' => $d_posts,
            'filled_posts' => ($d_posts - $d_vacant_posts),
            'vacant_posts' => $d_vacant_posts,
            'total_outputs' => $d_outputs,
            'total_activities' => $d_activities,
            'completed_activities' => $d_completed_activities,
            'percentage_vacancy' => round($d_vacant_posts / $d_posts, 2) * 100,
            'average_post_budget' => round($d_consumable_budget / $d_posts, 2),
            'o_projects' => $d_projects,
            'o_ratings' => $d_final_ratings,
            'red_projects' => $d_red_projects,
            'yellow_projects' => $d_yellow_projects,
            'green_projects' => $d_green_projects,
            'total_projects' => $d_projects,//$total_projects,
            'total_health' => $total_final_rating,
            'final_rating' => $d_total_average_final_rating,
            'percentage_senior_posts' => round($d_senior_posts / $d_posts, 2) * 100,
            'reporting_compliance' => $d_reporting_percentage,
            'total_days_past_due' => $d_overan_days,
            'expired_projects' => $d_past_due_projects,
            'average_months_past_due' => $d_average_overan_monthsA,
            'short_projects_percentage' => round($d_short_projects / $d_projects, 2) * 100,
            'officeorder' => $divisionorder,
        ];
    } else {
        $overall_office_budget_distribution_others[] = [
            'office' => $dvalue,
            'consumable' => $d_consumable_budget,
            'consumed' => $d_consumed_budget,
            'balance' => $d_consumable_budget - $d_consumed_budget,
            'total_posts' => $d_posts,
            'filled_posts' => ($d_posts - $d_vacant_posts),
            'vacant_posts' => $d_vacant_posts,
            'total_outputs' => $d_outputs,
            'total_activities' => $d_activities,
            'completed_activities' => $d_completed_activities,
            'percentage_vacancy' => round($d_vacant_posts / $d_posts, 2) * 100,
            'average_post_budget' => round($d_consumable_budget / $d_posts, 2),
            'o_projects' => $d_projects,
            'o_ratings' => $d_final_ratings,
            'red_projects' => $d_red_projects,
            'yellow_projects' => $d_yellow_projects,
            'green_projects' => $d_green_projects,
            'total_projects' => $d_projects,//$total_projects,
            'total_health' => $total_final_rating,
            'final_rating' => $d_total_average_final_rating,
            'percentage_senior_posts' => round($d_senior_posts / $d_posts, 2) * 100,
            'reporting_compliance' => $d_reporting_percentage,
            'total_days_past_due' => $d_overan_days,
            'expired_projects' => $d_past_due_projects,
            'average_months_past_due' => $d_average_overan_monthsA,
            'short_projects_percentage' => round($d_short_projects / $d_projects, 2) * 100,
            'officeorder' => $divisionorder,
        ];
    }


    $o_boadata = [];
    foreach ($boa_data as $bkey => $bvalue) {
        $o_boadata[] = [
            "office" => $bvalue->departments_responsible,
            "year" => $bvalue->year,
            "reportreference" => $bvalue->report_reference_and_financial_period,
            "summaryrecommendation" => $bvalue->summary_of_recommendation,
            "unepresponse" => $bvalue->unep_responses_provided_for_sgr,
            "referencedocuments" => $bvalue->reference_documents,
            "boardassessment" => $bvalue->boards_assessment,
            "departmentresponsible" => $bvalue->departments_responsible,
            "responiblestaff" => $bvalue->responsible_staff,
            "priority" => $bvalue->priority,
            "targetdate" => $bvalue->target_date,
            "suggestedstatusverified" => $bvalue->suggested_status_after_verification_from_unep,
            "suggestedstatus" => $bvalue->suggested_status,
            "category" => $bvalue->category,
            "agemonths" => $bvalue->age_in_months,
        ];
    }

    $o_oiosdata = [];
    foreach ($oios_data as $key => $value) {
        $o_oiosdata[] = [
            "office" => $value->client_responsible_office,
            "title" => $value->audit_title,
            "projectcode" => $value->project_code,
            "recommendation_no" => $value->recommendation_no,
            "division" => $value->division,
            "category" => $value->category,
            "issue_date" => $value->actual_issue_date,
            "project_name" => $value->project_name,
            "recommendation" => $value->recommendation,
            "status_update" => $value->status_update,
            "recommendation_update" => $value->recommendation_update,
            "recommendation_state" => $value->recommendation_state,
            "implementation_date" => $value->estimated_implementation_date,
            "age_months" => $value->age_in_months,
            "implementation_pastdue" => $value->past_due_est_implementation_in_months,
            "client_responsible_office" => $value->client_responsible_office,
            "team_central_update" => $value->last_status_update_from_team_central,
            "proposed_status_update" => $value->proposed_status_update,
            "proposed_revision_of_estimated_date" => $value->proposed_revision_of_estimated_date,
            "reference_to_attachment" => $value->reference_to_attachment,
            "proposed_status_in_progress_implemented" => $value->proposed_status_in_progress_implemented,
        ];
    }


    //sort by budget

    // foreach ($d_project_information as $key => $value) {
    //     echo $value['project_id'] . ' - ' . $value['final_rating'] . ' - ' . $value['project_rank'] . '<br />';
    // }

    $d_sp_array = [];
    $d_sp_array['spnames'] = [];
    $d_sp_array['spnumbers'] = [];
    $d_sp_array['projectcount'] = [];

    foreach ($d_subprogramme_projects_distribution as $key => $value) {
        $d_sp_array['spnames'][] = ucwords($value['subprogramme']);
        $d_sp_array['spnumbers'][] = 'SP ' . $value['subprogramme_number'];
        $d_sp_array['projectcount'][] = $value['projects'];

        // echo $value['order'] . ' ' . $value['subprogramme'] . ' subprogramme, ' . $value['projects'] . ' projects <br />';
    }

    /*echo ' <br /> <br />';
    echo $d_filled_posts . ' Filled posts (' . $d_filled_male_count . ' male, ' . $d_filled_female_count . ' female) <br />';
    echo $d_vacant_posts . ' Vacant posts <br />';
    echo $d_posts . ' Total posts <br />';*/

    /*echo $d_projects . ' projects<br />' . $d_consumable_budget . ' consumable budget <br />';
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

    $pctbudgetutilized = ($d_consumed_budget * 100 / $d_consumable_budget);

    $processed_divisiondata[$dvalue] = array(
        "entity" => $dvalue,
        "totalprojects" => $d_projects,
        /*"totalactivities" => $d_activities,
    "totaloutputs" => $d_outputs,
    "healthcolor" => gethealthcolor($d_average_project_health),
    "healthrating" => $d_average_project_health,
    "consumablebudget" => $d_consumable_budget,
    "pastdueprojects" => $d_past_due_projects,
    "avgmonthspastdue" => $d_average_overan_months,
    "in6monthexpiry" => $d_projects_expiringin6,
    "pctconsumablebudget" => $d_percentage_consumable_budget,
    "avgconsumablebudget" => $d_average_consumable,
    "totalconsumedbudget" => $d_consumed_budget,
    "avgbudgetutilized" => $d_average_percentage_budget_utilized,
    "pctbudgetutilized" => $pctbudgetutilized,
    "avgactivitiescompleted" => $d_average_percentage_activities_completed,
    "avgtimetaken" => $d_average_project_days_duration,
    "avgprojecthealth" => $d_average_project_health,
    "avgsystemrating" => $d_total_average_system_rating,
    "avgmanagerrating" => $d_total_average_manager_rating,
    "avgfinalrating" => $d_total_average_final_rating,
    "reportedprojects" => $d_reported_projects,
    "reportedprojectspct" => $d_reporting_percentage,
    "pctgdurationused" => $d_avg_project_pctgtimetaken_a,
    "pctcompletedactivities" => $d_percentage_completed_activitiesA,
    "hrpostscategories" => $d_post_categories,
    "hrpostsfilled" => $d_post_filled,
    "hrpostsfilledmale" => $d_post_filled_male,
    "hrpostsfilledfemale" => $d_post_filled_female,
    "hrpostsvacant" => $d_post_vacant,
    "projectage" => array($d_count_projects_age_between0_2, $d_count_projects_age_between2_5, $d_count_projects_age_between5_10, $d_count_projects_age_more10),
    "grantfundingbygroup" => array($d_amount_projects_budget_between0_1, $d_amount_projects_budget_between1_2, $d_amount_projects_budget_between2_5, $d_amount_projects_budget_between5_10, $d_amount_projects_budget_more10),
    "grantfundingcountbygroup" => array($d_count_projects_budget_between0_1, $d_count_projects_budget_between1_2, $d_count_projects_budget_between2_5, $d_count_projects_budget_between5_10, $d_count_projects_budget_more10),
    "projectlisting" => $d_project_information,
    "stafflisting" => $d_staff_information,
    "projectsubprogramme" => $d_sp_array,
    "scatterpoints" => ["red" => $d_scatter_points_red, "yellow" => $d_scatter_points_yellow, "green" => $d_scatter_points_green],*/
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
 */
/*
 */

//$o_unsorted_posts = $overall_post_status_distribution;
// $d_post_status_distribution = [];
//var_dump($overall_office_budget_distribution_office);
foreach ($overall_post_status_distribution as $key => $value) {
    $position = intval(array_search($value['post'], $staff_order_array));
    $overall_post_status_distribution[$key]['order'] = $position;
}
usort($overall_post_status_distribution, 'sortByOrder');

$hrpostscategories = array();
$hrpostsfilled = array();
$hrpostsvacant = array();

$overall_post_categories = array();
$overall_post_filled = array();
$overall_post_filled_male = array();
$overall_post_filled_female = array();
$overall_post_vacant = array();
$overall_post_male = array();
$overall_post_female = array();
foreach ($overall_post_status_distribution as $key => $value) {
    array_push($overall_post_categories, $value['post']);
    array_push($overall_post_filled, $value['filled']);
    if ($value['filled'] != 0 && $value['filled_male'] != 0) {
        array_push($overall_post_filled_male, number_format((1 * (100 * $value['filled_male'] / $value['filled'])), 2));
    } else {
        array_push($overall_post_filled_male, 0);
    }
    if ($value['filled'] != 0 && $value['filled_female'] != 0) {
        array_push($overall_post_filled_female, number_format((-1 * (100 * $value['filled_female'] / $value['filled'])), 2));
    } else {
        array_push($overall_post_filled_female, 0);
    }
    array_push($overall_post_vacant, $value['vacant']);
    array_push($overall_post_male, $value['filled_male']);
    array_push($overall_post_female, $value['filled_female']);
}

/*
foreach ($overall_post_status_distribution as $key => $value) {
$position = intval(array_search($value['post'], $staff_order_array));
echo $overall_post_status_distribution[$key]['order'] = $position;
}

usort($overall_post_status_distribution, 'sortByOrder');
 */
//echo '<br /><br />_______________TOTAL VALUES______________<br /><br />';

// foreach ($unique_subprogramme_data as $key => $value) {
//     echo $value['subprogramme'] . ' subprogramme, ' . $value['projects'] . ' projects <br />';
// }

/*
foreach ($overall_post_status_distribution as $key => $value) {
echo $value['post'] . ' - ' . $value['filled'] . ' filled posts (' . $value['filled_male'] . ' male,' . $value['filled_female'] . ' female), ' . $value['vacant'] . ' vacant posts <br />';
}
echo ' <br /> <br />';
echo $t_filled_posts . ' Filled posts (' . $t_filled_male_count . ' male, ' . $t_filled_female_count . ' female) <br />';
echo $t_vacant_posts . ' Vacant posts <br />';
echo $t_posts . ' Total posts <br />';

 */

/*
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
echo $total_count_projects_duration_between0_2 . ' Projects whose duration is between 0 and 2 years <br />';

echo $total_count_projects_age_more10 . ' Projects whose age is more than 10 years<br />';
echo $total_count_projects_age_between5_10 . ' Projects whose age is between 5 and 10 years  <br />';
echo $total_count_projects_age_between2_5 . ' Projects whose age is between 2 and 5 years <br />';
echo $total_count_projects_age_between0_2 . ' Projects whose age is between 0 and 2 years <br />';

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

/* Totals Array */

//array_push($processed_divisiondata, ['unep'] =>

// $d_past_projects += 1;
// $t_past_projects += 1;

// $d_overan_days += $prvalue->days_past_due;
// $total_overan_days += $prvalue->days_past_due;

if ($total_overan_days == 0) {
    $average_overan_days = 0;
    $average_overan_months = 0;
} else {
    $average_overan_days = round($total_overan_days / $t_past_projects);
    $average_overan_months = ceil($d_average_overan_days / 30);
}

$regional_average_overan_days = round($regional_overan_days / $regional_past_projects);
$regional_average_overan_months = ceil($regional_average_overan_days / 30);

$divisional_average_overan_days = round($divisional_overan_days / $divisional_past_projects);
$divisional_average_overan_months = ceil($divisional_average_overan_days / 30);

// echo $regional_overan_days . '-' . $regional_past_projects . 'regional <br />';

// echo $divisional_overan_days . '-' . $divisional_past_projects . ' divisional <br />';

// echo $total_overan_days . ' total overan days <br />';
// echo $t_past_projects . ' total past projects <br />';

// echo $regional_average_overan_months . ' regional avg overan months<br/>';
// echo $divisional_average_overan_months . ' divisional avg overan months<br/>';

$avg_project_pctgtimetaken_a = round($total_project_pctgtimetaken / $total_projects, 2) * 100;

$overall_percentage_completed_activitiesA = round($total_avg_activities_completed / $total_projects, 2) * 100;

foreach ($unique_subprogramme_data as $key => $value) {
    $o_projects_count = 0;
    foreach ($value['divisions'] as $udkey => $udvalue) {
        $o_projects_count += 1;
    }
    $o_subprogramme_projects_distribution[$value['subprogramme_number']] = ["order" => $value['subprogramme_number'], "subprogramme" => $value['subprogramme'], "subprogramme_number" => $value['subprogramme_number'], "projects" => $o_projects_count];

}

foreach ($o_subprogramme_projects_distribution as $key => $value) {
    if (!$value['projects'] > 0) {
        unset($o_subprogramme_projects_distribution[$key]);
    }
}

$o_sp_array = [];
$o_sp_array['spnames'] = [];
$o_sp_array['spnumbers'] = [];
$o_sp_array['projectcount'] = [];

foreach ($o_subprogramme_projects_distribution as $key => $value) {
    $o_sp_array['spnames'][] = ucwords($value['subprogramme']);
    $o_sp_array['spnumbers'][] = 'SP ' . $value['subprogramme_number'];
    $o_sp_array['projectcount'][] = $value['projects'];
}

usort($overall_office_budget_distribution, 'sortByConsumable');
usort($overall_office_budget_distribution_office, 'sortByConsumable');
usort($overall_office_budget_distribution_region, 'sortByConsumable');
usort($overall_office_budget_distribution_others, 'sortByConsumable');

//sort by consumable

//var_dump($overall_office_budget_distribution);
// echo 'Total time taken ' . $total_avg_activities_completed . '<br />';
// echo 'Total total projects ' . $total_projects . '<br />';
// echo $overall_percentage_completed_activitiesA;

//JOB GRADES -ONLY ->$unique_posts_data
// POSTS-VACANT, FILLED, MALE,FEMALE->$overall_post_status_distribution

// foreach ($overall_post_status_distribution as $key => $value) {
//     if ($value['post'] == 'INT-I' || $value['post'] == 'INT-II') {

//         echo 'intern';
//         unset($overall_post_status_distribution[$key]);
//     }
// }

foreach ($overall_office_budget_distribution_office as $office) {
    //echo $office['o_projects'] . ' projects - ' . $office['o_ratings'] . ' total ratings';
}
$avg_months_past_due = round($total_overan_days / $t_past_projects) / 30;
$processed_divisiondata['Unep'] = array(
    "entity" => 'UN Environment'
    , "totalprojects" => $total_projects
    , "totalactivities" => $total_activities
    , "totaloutputs" => $total_outputs
    , "healthcolor" => gethealthcolor($overall_average_project_health)
    , "healthrating" => $overall_average_project_health
    , "consumablebudget" => $total_consumable_budget
    , "pastdueprojects" => $total_past_due_projects
    //, "avgmonthspastdue" => $average_overan_months
    , "avgmonthspastdue" => $avg_months_past_due
    , "avgmonthspastdue_region" => $regional_average_overan_months
    , "avgmonthspastdue_division" => $divisional_average_overan_months
    , "in6monthexpiry" => $total_projects_expiringin6
    , "reportedprojectspct" => $total_reporting_percentage
    , "scatterpoints" => ["red" => $total_scatter_points_red, "yellow" => $total_scatter_points_yellow, "green" => $total_scatter_points_green]
    , "totalconsumedbudget" => $total_consumed_budget
    , "pctbudgetutilized" => ($total_consumed_budget * 100 / $total_consumable_budget)
    , "pctgdurationused" => $avg_project_pctgtimetaken_a
    , "avgactivitiescompleted" => $overall_percentage_completed_activitiesA
    , "projectage" => array($total_count_projects_age_between0_2, $total_count_projects_age_between2_5, $total_count_projects_age_between5_10, $total_count_projects_age_more10)
    , "hrpostscategories" => $overall_post_categories
    , "hrpostsfilled" => $overall_post_filled
    , "hrpostsfilledmale" => $overall_post_filled_male
    , "hrpostsfilledfemale" => $overall_post_filled_female
    , "hrpostsvacant" => $overall_post_vacant
    , "hrpostsmale" => $overall_post_male
    , "hrpostsfemale" => $overall_post_female
    , "projectsubprogramme" => $o_sp_array
    , "divisionlisting" => $overall_office_budget_distribution
    , "divisionlisting_office" => $overall_office_budget_distribution_office
    , "divisionlisting_region" => $overall_office_budget_distribution_region
    , "divisionlisting_others" => $overall_office_budget_distribution_others
    , "boa_data" => $o_boadata
    , "oios_data" => $o_oiosdata
    , "mandatory_training_completion" => $pctg_mc_completion
    , "epass_compliance" => $pctg_epass_compliance
    , "activeconsultants" => $activeconsultants
    , "grantsdata" => $overall_grantsdata
    , "risks_data" => $overall_risksdata
    , "stafflisting" => $overall_staff_information
    , "consultants_data" => $overall_consultants
    , "hrdashboard" => ["dutystations" => $staff_dutystations, "contracttypes" => $staff_contracttypes, "nationality" => $staff_nationality, "regionality" => $staff_regionality]
    /*, "hrpostscategories" => $hrpostscategories
    , "hrpostsfilled" => $hrpostsfilled
    , "hrpostsvacant" => $hrpostsvacant
    , "hrpostsvacantcount" => $t_vacant_posts
    , "hrpostsfilledcount" => $t_filled_posts
    , "hrpoststotal" => $t_posts
    , "hrpostsfilledmale" => $t_filled_male
    , "hrpostsfilledfemale" => $t_filled_female
    , "hrpostsfilledmalecount" => $t_filled_male_count
    , "hrpostsfilledfemalecount" => $t_filled_female_count*/

    //new data

    /*"pctconsumablebudget" => $d_percentage_consumable_budget,

"avgbudgetutilized" => $d_average_percentage_budget_utilized,
"pctbudgetutilized" => $pctbudgetutilized,

"avgtimetaken" => $d_average_project_days_duration,
"avgprojecthealth" => $d_average_project_health,
"avgsystemrating" => $d_total_average_system_rating,
"avgmanagerrating" => $d_total_average_manager_rating,
"avgfinalrating" => $d_total_average_final_rating,
"reportedprojects" => $d_reported_projects,

"pctgdurationused" => $d_avg_project_pctgtimetaken_a,
"pctcompletedactivities" => $d_percentage_completed_activitiesA,

"hrpostsfilledmale" => $d_post_filled_male,
"hrpostsfilledfemale" => $d_post_filled_female,

"grantfundingbygroup" => array($d_amount_projects_budget_between0_1, $d_amount_projects_budget_between1_2, $d_amount_projects_budget_between2_5, $d_amount_projects_budget_between5_10, $d_amount_projects_budget_more10),
"grantfundingcountbygroup" => array($d_count_projects_budget_between0_1, $d_count_projects_budget_between1_2, $d_count_projects_budget_between2_5, $d_count_projects_budget_between5_10, $d_count_projects_budget_more10),
"projectlisting" => $d_project_information,
"stafflisting" => $d_staff_information,
"projectsubprogramme" => $d_sp_array,
"scatterpoints" => ["red" => $d_scatter_points_red, "yellow" => $d_scatter_points_yellow, "green" => $d_scatter_points_green],*/
);

//Clean
//Clean 2

?>