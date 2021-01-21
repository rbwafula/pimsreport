<?php
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
$activities_url = $page_link . '/assets/data/div_activitycount_data.json';
$outputs_url = $page_link . '/assets/data/div_activitycount_data.json';
$hr_url = $page_link . '/assets/data/officestaff_data.json';
$proj_activity_url = $page_link . '/assets/data/div_practivitycount_data.json';

// GET PROJECTS DATA
$division_data = getdataobjectfromurl($url);

// GET ACTIVITIES DATA
$activities_data = getdataobjectfromurl($activities_url);

// GET OUTPUTS DATA
$outputs_data = getdataobjectfromurl($outputs_url);

//GET HR DATA
$hr_data_uf = getdataobjectfromurl($hr_url);

//INITIALIZE VALUES
// STAFF ORDER BY SENIORITY FOR REFERENCE
$staff_order_array = ['USG ', 'ASG', 'D-2', 'D-1', 'P-5', 'P-4', 'P-3', 'P-2', 'P-1', 'GS'];
$staff_order_array_all = ['USG ', 'ASG', 'D-2', 'D-1', 'P-5', 'P-4', 'P-3', 'P-2', 'P-1', 'G-7', 'G-6', 'G-5', 'G-4', 'G-3', 'G-2', 'G-1', 'NO-A', 'NO-B', 'NO-C', 'NO-D'];

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
$overall_percentage_completed_activitiesA = 0;

$total_projects_timetaken = 0;

$overall_vacant_posts = [];
$overall_filled_posts = [];
$total_vacant_posts = 0;
$total_filled_posts = 0;
$total_posts = 0;

$unique_post_groups = [];
$unique_posts_data = [];

$unique_divisions = [];
$unique_subprogrammes = [];
$unique_subprogramme_data = [];
$unique_final_ratings = [0];

//GET THE UNIQUE SUBPROGRAMMES
//USE DATA FROM API TO FEED THE UNIQUE SUBPROGRAMMES AND FINAL RATINGS ARRAY
$x = 2;
foreach ($division_data as $key => $value) {
    $sp_name = strtolower($value->subprogramme);
    if (array_search($sp_name, $unique_subprogrammes) < 1 && $sp_name !== '') {
        $unique_subprogrammes[$x] = $sp_name;
        $unique_subprogramme_data[] = ["subprogramme" => $sp_name, "subprogramme_number" => $value->sp_number, "projects" => 1, "divisions" => [$value->managing_division]];
    } else {

        foreach ($unique_subprogramme_data as $skey => $svalue) {
            if ($sp_name == $svalue['subprogramme']) {

                $unique_subprogramme_data[$skey]['projects'] += 1;
                $unique_subprogramme_data[$skey]['divisions'][] = $value->managing_division;

            }}
    }

    $div_name = strtolower($value->managing_division);
    if (array_search($div_name, $unique_divisions) < 1 && $div_name !== '') {
        $unique_divisions[$x] = $div_name;
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

//var_dump($unique_subprogrammes);

//inserted start
//USE DATA FROM API TO FEED THE UNIQUE POST POSITIONS ARRAY

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

        foreach ($pvalue['offices_post_filled'] as $okey => $ovalue) {
            $t_filled_count += 1;
        }

        foreach ($pvalue['offices_post_vacant'] as $okey => $ovalue) {
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

//inserted end
//FOR EACH UNIQUES SUBPROGRAMME GET VALUES

//echo '<br />---------------------DIVISIONAL DATA--------------------<br /><br />';
foreach ($unique_subprogrammes as $dkey => $spvalue) {
//CALCULATE DIVISIONAL METRICS

//calculate number of projects under this division
    $sp_projects = 0;
    $sp_consumable_budget = 0;
    $sp_consumed_budget = 0;
    $sp_percentage_budget_utilized = 0;
    $sp_percentage_activities = 0;
    $sp_percentage_activities_completed = 0;
    $sp_reported_projects = 0;
    $sp_project_days = 0;
    $sp_project_health = 0;

    $sp_count_projects_budget_between0_1 = 0;
    $sp_count_projects_budget_between1_2 = 0;
    $sp_count_projects_budget_between2_5 = 0;
    $sp_count_projects_budget_between5_10 = 0;
    $sp_count_projects_budget_more10 = 0;

    $sp_amount_projects_budget_between0_1 = 0;
    $sp_amount_projects_budget_between1_2 = 0;
    $sp_amount_projects_budget_between2_5 = 0;
    $sp_amount_projects_budget_between5_10 = 0;
    $sp_amount_projects_budget_more10 = 0;

    $sp_past_due_projects = 0;
    $sp_projects_expiringin6 = 0;

    $sp_total_system_rating = 0;
    $sp_total_manager_rating = 0;
    $sp_total_final_rating = 0;

    $sp_count_projects_duration_between0_2 = 0;
    $sp_count_projects_duration_between2_5 = 0;
    $sp_count_projects_duration_between5_10 = 0;
    $sp_count_projects_duration_more10 = 0;
    $sp_projects_duration = 0;

    $sp_count_projects_age_between0_2 = 0;
    $sp_count_projects_age_between2_5 = 0;
    $sp_count_projects_age_between5_10 = 0;
    $sp_count_projects_age_more10 = 0;
    $sp_projects_age = 0;

    $sp_activities = 0;
    $sp_completed_activities = 0;
    $sp_outputs = 0;
    $sp_percentage_completed_activities = 0;
    $sp_percentage_completed_activitiesA = 0;

    $sp_project_pctgtimetaken = 0;

    $sp_vacant_posts = [];
    $sp_filled_posts = [];
    $sp_vacant_posts = 0;
    $sp_filled_posts = 0;
    $sp_posts = 0;
    $sp_filled_male_count = 0;
    $sp_filled_female_count = 0;

    //DIVISION PROJECT INFORMATION
    $sp_project_information = [];
    $sp_project_branch = [''];
    $sp_scatter_points = [];
    $sp_scatter_points_red = [];
    $sp_scatter_points_yellow = [];
    $sp_scatter_points_green = [];
    $sp_overan_days = 0;
    $sp_division_projects_distribution = [];

    foreach ($division_data as $prkey => $prvalue) {
        if (strtolower($prvalue->subprogramme) == $spvalue) {
            if (!in_array($prvalue->managing_branch, $sp_project_branch)) {
                $sp_project_branch[] = $prvalue->managing_branch;
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

            if ($project_days_remaining < 0) {

            }

            if (isset($prvalue->days_past_due) && $prvalue->days_past_due > 0) {
                $sp_overan_days += $prvalue->days_past_due;
                $sp_past_due_projects += 1;

            }

            if (!$prvalue->final_rating) {
                $reported = 'NO';
            } else {
                $reported = 'YES';
            }

            $p_outputs = 0;
            $p_completed_activities = 0;
            $p_activities = 0;

            // foreach ($proj_data as $pakey => $pavalue) {
            //     if ($pavalue->projectID == $prvalue->project_id) {
            //         $p_outputs = $pavalue->total_outputs;
            //         $p_completed_activities = $pavalue->completed_activities;

            //         $p_activities = $pavalue->total_activities;

            //     }
            // }

            if (!$prvalue->final_rating) {
                $project_rating = 'N/A';
                $fr = 0;
            } else {
                $f_rating = $prvalue->final_rating;
                $project_rating = array_search($f_rating, $unique_final_ratings) + 1;
                $fr = floatval(number_format((float) $prvalue->final_rating, 2, '.', ''));
            }
            //feed into scatter points -> consumable budget, rating
            $sp_scatter_points[] = [intval($prvalue->consumable_budget), $fr];

            // echo $fr;

            if ($fr >= 2.5) {
                //green
                $sp_scatter_points_green[] = [$fr, intval($prvalue->consumable_budget)];
            } elseif ($fr >= 1.5) {
                // yellow
                $sp_scatter_points_yellow[] = [$fr, intval($prvalue->consumable_budget)];

            } else {
                //red
                $sp_scatter_points_red[] = [$fr, intval($prvalue->consumable_budget)];
            }

            $sp_project_information[] = [
                'project_id' => $prvalue->project_id,
                'project_title' => $prvalue->project_title,
                'subprogramme' => $prvalue->subprogramme,
                'sp_number' => $prvalue->sp_number,
                'branch' => $prvalue->managing_branch,
                'division' => $prvalue->managing_division,
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
                'order' => array_search($prvalue->managing_branch, $sp_project_branch),
            ];
        }
    }

    $sp_division_projects = [];
    foreach ($unique_divisions as $div) {
        foreach ($unique_subprogramme_data as $skey => $svalue) {
            if ($svalue['subprogramme'] == $spvalue) {
                $d_projects = 0;
                foreach ($unique_subprogramme_data[$skey]["divisions"] as $dname) {
                    if (strtolower($dname) == $div) {
                        $d_projects += 1;
                    }
                }
                $sp_division_projects[] = [
                    'division' => $div,
                    'projects' => $d_projects,
                ];
            }

            // if ($svalue['subprogramme'] == $spvalue) {
            //     var_dump($unique_subprogramme_data[$skey]["divisions"]);
            //     echo '<br />';
            // }
        }
    }

    foreach ($sp_division_projects as $key => $spp) {
        if ($spp['projects'] < 1) {
            unset($sp_division_projects[$key]);
        }
    }

    foreach ($unique_subprogramme_data as $key => $value) {

        // if ($value['subprogramme'] == $sp_value) {
        //     var_dump($unique_subprogramme_data[$key]);
        //     echo '<br />';

        // }
        // $div_projects_count = 0;
        // foreach ($value['divisions'] as $udkey => $udvalue) {
        //     if ($udvalue == $dvalue) {
        //         $div_projects_count += 1;
        //     }
        // }
        //$sp_division_projects_distribution[$value['subprogramme_number']] = ["order" => $value['subprogramme_number'], "subprogramme" => $value['subprogramme'], "subprogramme_number" => $value['subprogramme_number'], "projects" => $sp_projects_count];
    }

    // usort($sp_subprogramme_projects_distribution, 'sortByOrder');
    foreach ($division_data as $key => $value) {
        if (strtolower($value->subprogramme) == $spvalue) {

            $startDate = strtotime($value->StartDate);
            $endDate = strtotime($value->EndDate);
            $datediff = $endDate - $startDate;
            $project_days_duration = round($datediff / (60 * 60 * 24));
            $sp_project_days += $project_days_duration;

            $startDatea = strtotime($value->StartDate);
            $endDatea = time();
            $datediffa = $endDatea - $startDatea;
            $project_days_age = round($datediffa / (60 * 60 * 24));
            // $project_days_age = getdaysbetween($startDate, null);

            // echo 'From ' . $value->StartDate . ' to Now, age by days -' . $project_days_age . ' <br />';

            if ($value->percentage_time_taken != null) {
                $sp_project_pctgtimetaken += $value->percentage_time_taken;
            } else {
                $sp_project_pctgtimetaken += 0;
            }

            $sp_projects += 1;
            $sp_consumable_budget += $value->consumable_budget;
            $sp_consumed_budget += $value->consumed_budget;
            $sp_percentage_budget_utilized += round($value->percentage_budget_utilized, 2);
            $sp_percentage_activities_completed += $value->percentage_activities_completed;

            $sp_projects_age += $project_days_age;

            if ($project_days_duration > 3648) {
                $sp_count_projects_duration_more10 += 1;

            } elseif ($project_days_duration > 1820) {
                $sp_count_projects_duration_between5_10 += 1;

            } elseif ($project_days_duration > 730) {
                $sp_count_projects_duration_between2_5 += 1;

            } else {
                $sp_count_projects_duration_between0_2 += 1;

            }
            if ($project_days_age > 3648) {
                $sp_count_projects_age_more10 += 1;

            } elseif ($project_days_age > 1820) {
                $sp_count_projects_age_between5_10 += 1;

            } elseif ($project_days_age > 728) {
                $sp_count_projects_age_between2_5 += 1;

            } else {
                $sp_count_projects_age_between0_2 += 1;

            }

            if ($value->final_rating) {
                $sp_reported_projects += 1;
                $sp_project_health += $value->final_rating;
            } else {
                $sp_project_health += 0;
            }

            if ($value->consumable_budget > 10000000) {
                $sp_count_projects_budget_more10 += 1;
                $sp_amount_projects_budget_more10 += $value->consumable_budget;

            } elseif ($value->consumable_budget > 5000000) {
                $sp_count_projects_budget_between5_10 += 1;
                $sp_amount_projects_budget_between5_10 += $value->consumable_budget;

            } elseif ($value->consumable_budget > 2000000) {
                $sp_count_projects_budget_between2_5 += 1;
                $sp_amount_projects_budget_between2_5 += $value->consumable_budget;

            } elseif ($value->consumable_budget > 1000000) {
                $sp_count_projects_budget_between1_2 += 1;
                $sp_amount_projects_budget_between1_2 += $value->consumable_budget;

            } else {
                $sp_count_projects_budget_between0_1 += 1;
                $sp_amount_projects_budget_between0_1 += $value->consumable_budget;
            }

            if ($value->days_past_due > 0) {
                //$sp_past_due_projects += 1;
            } else {
                if ($value->days_past_due > -174) {
                    $sp_projects_expiringin6 += 1;
                }
            }

            if ($value->manager_rating) {
                $sp_total_manager_rating += $value->manager_rating;
            } else {}

            if ($value->system_rating) {
                $sp_total_system_rating += $value->system_rating;
            } else {}

            if ($value->final_rating) {
                $sp_total_final_rating += $value->final_rating;
            } else {}

        }
    }
    $sp_percentage_projects_budget_between0_1 = round($sp_count_projects_budget_between0_1 / $sp_projects, 2) * 100;
    $sp_percentage_projects_budget_between1_2 = round($sp_count_projects_budget_between1_2 / $sp_projects, 2) * 100;
    $sp_percentage_projects_budget_between2_5 = round($sp_count_projects_budget_between2_5 / $sp_projects, 2) * 100;
    $sp_percentage_projects_budget_between5_10 = round($sp_count_projects_budget_between5_10 / $sp_projects, 2) * 100;
    $sp_percentage_projects_budget_more10 = round($sp_count_projects_budget_more10 / $sp_projects, 2) * 100;

    $sp_percentage_consumable_budget = round($sp_consumable_budget / $total_consumable_budget, 2) * 100;
    $sp_percentage_consumed_budget = round($sp_consumed_budget / $total_consumed_budget, 2) * 100;

    $sp_reporting_percentage = round(($sp_reported_projects / $sp_projects) * 100, 1);
    $sp_average_consumable = round($sp_consumable_budget / $sp_projects, 2);
    $sp_average_project_days_duration = round($sp_project_days / $sp_projects);
    $sp_average_project_years_duration = round($sp_average_project_days_duration / 365.25, 1);

    $sp_average_project_health = round($sp_project_health / $sp_projects, 1);

    $sp_average_percentage_budget_utilized = round($sp_percentage_budget_utilized / $sp_projects, 1);

    $sp_total_average_system_rating = round($sp_total_system_rating / $sp_projects, 1);
    $sp_total_average_manager_rating = round($sp_total_manager_rating / $sp_projects, 1);
    $sp_total_average_final_rating = round($sp_total_final_rating / $sp_projects, 1);

    $sp_percentage_of_budget_utilized = round($sp_consumed_budget / $sp_consumable_budget, 2) * 100;

    //$sp_overall_pctg_duration_used = round( $sp_projects_age / $sp_projects_duration , 2)*100;

    $sp_avg_project_pctgtimetaken_a = round($sp_project_pctgtimetaken / $sp_projects, 2) * 100;
    $sp_average_percentage_activities_completed = round($sp_percentage_activities_completed / $sp_projects, 2) * 100;

    if ($sp_overan_days == 0) {
        $sp_average_overan_days = 0;
        $sp_average_overan_months = 0;
    } else {
        $sp_average_overan_days = round($sp_overan_days / $sp_past_due_projects);
        $sp_average_overan_months = ceil($sp_average_overan_days / 30);
    }

    $G_d_staff_distribution = ["post" => 'GS', "filled" => 0, "filled_male" => 0, "filled_female" => 0, "vacant" => 0];

    $sp_post_status_distribution[] = $G_d_staff_distribution;

    $unsorted_posts = $sp_post_status_distribution;
    // $sp_post_status_distribution = [];

    foreach ($sp_post_status_distribution as $key => $value) {
        $position = intval(array_search($value['post'], $staff_order_array));
        $sp_post_status_distribution[$key]['order'] = $position;
    }

    usort($sp_post_status_distribution, 'sortByOrder');

    $sp_post_categories = array();
    $sp_post_filled = array();
    $sp_post_filled_male = array();
    $sp_post_filled_female = array();
    $sp_post_vacant = array();
    $sp_post_male = array();
    $sp_post_female = array();

    //CHANGE DISTRIBUTION
    // foreach ($sp_subprogramme_projects_distribution as $key => $value) {
    //     if (!$value['projects'] > 0) {
    //         unset($sp_subprogramme_projects_distribution[$key]);
    //     }
    // }

    // foreach ($sp_subprogramme_projects_distribution as $key => $value) {
    //     echo $value['subprogramme'] . ' subprogramme, ' . $value['projects'] . ' projects <br />';
    // }

    usort($sp_project_information, 'sortByOrder');

    // display the division name its and number of projects
    //echo '<br />_____________' . $dvalue . ' Division/Office ______________<br /><br />';
    //var_dump($sp_scatter_points);

    // foreach ($sp_project_information as $key => $value) {
    //     echo $value['project_id'] . ' - ' . $value['final_rating'] . ' - ' . $value['project_rank'] . '<br />';
    // }
    $sp_div_projects_distribution = [];
    $sp_div_array = [];
    $sp_div_array['division_names'] = [];
    $sp_div_array['division_projectcounts'] = [];

    //CHANGE TO DIVISION
    foreach ($sp_division_projects as $key => $value) {
        $sp_div_array['division_names'][] = ucwords($value['division']);
        $sp_div_array['division_projectcounts'][] = $value['projects'];

        // echo $value['order'] . ' ' . $value['subprogramme'] . ' subprogramme, ' . $value['projects'] . ' projects <br />';
    }

    $pctbudgetutilized = ($sp_consumed_budget * 100 / $sp_consumable_budget);
    // var_dump($sp_division_projects);
    // echo 'sp proj<br />';
    $processed_spdata[$spvalue] = array(
        "entity" => $spvalue,
        "totalprojects" => $sp_projects,
        "totalactivities" => $sp_activities,
        "totaloutputs" => $sp_outputs,
        "divisional_projects" => $sp_div_array,
        "healthcolor" => gethealthcolor($sp_average_project_health),
        "healthrating" => $sp_average_project_health,
        "consumablebudget" => $sp_consumable_budget,
        "pastdueprojects" => $sp_past_due_projects,
        "avgmonthspastdue" => $sp_average_overan_months,
        "in6monthexpiry" => $sp_projects_expiringin6,
        "pctconsumablebudget" => $sp_percentage_consumable_budget,
        "avgconsumablebudget" => $sp_average_consumable,
        "totalconsumedbudget" => $sp_consumed_budget,
        "avgbudgetutilized" => $sp_average_percentage_budget_utilized,
        "pctbudgetutilized" => $pctbudgetutilized,
        "avgactivitiescompleted" => $sp_average_percentage_activities_completed,
        "avgtimetaken" => $sp_average_project_days_duration,
        "avgprojecthealth" => $sp_average_project_health,
        "avgsystemrating" => $sp_total_average_system_rating,
        "avgmanagerrating" => $sp_total_average_manager_rating,
        "avgfinalrating" => $sp_total_average_final_rating,
        "reportedprojects" => $sp_reported_projects,
        "reportedprojectspct" => $sp_reporting_percentage,
        "pctgdurationused" => $sp_avg_project_pctgtimetaken_a,
        "pctcompletedactivities" => $sp_percentage_completed_activitiesA,
        "hrpostscategories" => $sp_post_categories,
        "hrpostsfilled" => $sp_post_filled,
        "hrpostsfilledmale" => $sp_post_filled_male,
        "hrpostsfilledfemale" => $sp_post_filled_female,
        "hrpostsvacant" => $sp_post_vacant,
        "hrpostsmale" => $sp_post_male,
        "hrpostsfemale" => $sp_post_female,
        "projectage" => array($sp_count_projects_age_between0_2, $sp_count_projects_age_between2_5, $sp_count_projects_age_between5_10, $sp_count_projects_age_more10),
        "grantfundingbygroup" => array($sp_amount_projects_budget_between0_1, $sp_amount_projects_budget_between1_2, $sp_amount_projects_budget_between2_5, $sp_amount_projects_budget_between5_10, $sp_amount_projects_budget_more10),
        "grantfundingcountbygroup" => array($sp_count_projects_budget_between0_1, $sp_count_projects_budget_between1_2, $sp_count_projects_budget_between2_5, $sp_count_projects_budget_between5_10, $sp_count_projects_budget_more10),
        "projectlisting" => $sp_project_information,
        "stafflisting" => array(),//$sp_staff_information,
        "projectsubprogramme" => $sp_div_array,
        "scatterpoints" => ["red" => $sp_scatter_points_red, "yellow" => $sp_scatter_points_yellow, "green" => $sp_scatter_points_green],
    );
    ?>

	<?php

//SWITCHING TO DIVISIONAL CALCULATIONS

}

// var_dump($processed_spdata);
//THE LATESRT

foreach ($processed_spdata as $sp) {
    //echo $sp["sub_programme"] . ' - ' . $sp["totalprojects"] . ' projects' . ' - ' . $sp["totalactivities"] . ' activities <br />';
    // foreach ($sp["divisional_projects"] as $dprojects) {
    //     echo $dprojects['division'] . " - " . $dprojects['projects'] . "<br />";
    // }

    //var_dump($sp["divisional_projects"]);

    //echo '--------------------------------------------------------------<br />';
}