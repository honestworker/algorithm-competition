<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Balanced Advertising</title>
    </head>
    <body>
        <form action="prob.php" method="post">
            <p>Enter Input:</p>
            <textarea type="text" name="inputs" rows="10"></textarea>
            <br>
            <button type ="submit">Check</button>
        </form>
        <?php
            $output_header_html = '<p>Output:</p>'
                            . '<textarea type=\"text\" name=\"outputs\" rows=\"10\">';
            $output_footer_html = '</textarea>';

            $first_company = array();
            function make_first_corperation($depth, $start_depth, $array, $count)
            {
                if ($depth > 0) {
                    if (count($array)) {
                        $start = $array[count($array) - 1];
                    } else {
                        $start = 0;
                    }
                    for ($index = $start + 1; $index <= $count; $index++) {
                        $array[$start_depth - $depth] = $index;
                        make_first_corperation($depth - 1, $start_depth, $array, $count);
                    }
                    return;
                } else if ($depth == 0) {
                    $GLOBALS['first_company'][] = $array;
                    return;
                }
                return;
            }
            $second_company = array();
            function make_second_corperation($depth, $start_depth, $array, $count)
            {
                if ($depth > 0) {
                    if (count($array)) {
                        $start = $array[count($array) - 1];
                    } else {
                        $start = 0;
                    }
                    for ($index = $start + 1; $index <= $count; $index++) {
                        $array[$start_depth - $depth] = $index;
                        make_second_corperation($depth - 1, $start_depth, $array, $count);
                    }
                    return;
                } else if ($depth == 0) {
                    $GLOBALS['second_company'][] = $array;
                    return;
                }
                return;
            }

            if ($_POST) {
                if (isset($_POST['inputs'])) {
                    if ($_POST['inputs']) {
                        $inputs = $_POST['inputs'];    
                        $inputs_arrays = explode(PHP_EOL, $inputs);
                        $vaild = 0;
                        if (count($inputs_arrays)) {
                            $temp_arrays = explode(' ', $inputs_arrays[0]);
                            if (count($temp_arrays) == 3) {
                                $user_count = $temp_arrays[0];
                                $sites_count = $temp_arrays[1];
                                $pairs_count = $temp_arrays[2];
                                if ($pairs_count == count($inputs_arrays) - 1) {
                                    for ($index = 1; $index <= $pairs_count; $index++) {
                                        $temp_arrays = explode(' ', $inputs_arrays[$index]);
                                        if (count($temp_arrays) != 2) {
                                            echo 'Please input the vaild values1.';
                                            break;
                                        }
                                        if ($temp_arrays[0] <= 0 || $temp_arrays[0] > $user_count) {
                                            echo 'Please input the vaild values2.';
                                            break;
                                        }
                                        if ($temp_arrays[1] <= 0 || $temp_arrays[1] > $sites_count) {
                                            echo 'Please input the vaild values3.';
                                            break;
                                        }

                                    }
                                    $vaild = 1;
                                }
                            }
                        }
                        if ($vaild) {
                            $output_result_html = '';
                            $output_ok = 0;
                            for ($first_count = $pairs_count; $first_count >= ($pairs_count + 1) / 2; $first_count--) {
                                $first_company = array();
                                make_first_corperation($first_count, $first_count, array(), $pairs_count);
                                for ($second_count = 0; $second_count <= $pairs_count - $first_count; $second_count++) {
                                    $second_company = array();
                                    if ($second_count) {
                                        make_second_corperation($second_count, $second_count, array(), $pairs_count);
                                    }
                                    for ($first_index = 0; $first_index < count($first_company); $first_index++) {
                                        for ($second_index = 0; $second_index <= count($second_company); $second_index++) {
                                            if ($second_index == count($second_company) && count($second_company)) continue;
                                            $second_real_company = array();
                                            $first_real_index = $second_real_index = $second_sub_index = 0;
                                            for ($paris_index = 1; $paris_index <= $pairs_count; $paris_index++) {
                                                $first_real_index_vaild = 0;
                                                if (isset($first_company[$first_index][$first_real_index])) {
                                                    if ($paris_index == $first_company[$first_index][$first_real_index]) {
                                                        $first_real_index = $first_real_index + 1;
                                                        $first_real_index_vaild = 1;
                                                    }
                                                }
                                                if ($first_real_index_vaild == 0) {
                                                    if (isset($second_company[$second_index][$second_real_index])) {
                                                        if ($paris_index == $second_company[$second_index][$second_real_index]) {
                                                            $second_real_index = $second_real_index + 1;
                                                            $second_real_company[] = $paris_index;
                                                        }
                                                    }
                                                }                                                
                                            }
                                            for ($index = 0; $index < count($first_company); $index++) {
                                                $first_users = $second_users = array();
                                                $first_sites = $second_sites = array();
                                                for ($pairs_index = 0; $pairs_index < $pairs_count; $pairs_index++) {
                                                    $user_site_array = explode(' ', $inputs_arrays[$pairs_index + 1]);
                                                    $user_id =  $user_site_array[0];
                                                    $site_id =  $user_site_array[1];
                                                    if (in_array($pairs_index + 1, $first_company[$first_index])) {
                                                        if (isset($first_users[$user_id])) {
                                                            $first_users[$user_id] = $first_users[$user_id] + 1;
                                                        } else {
                                                            $first_users[$user_id] = 1;
                                                        }
                                                        if (isset($first_sites[$site_id])) {
                                                            $first_sites[$site_id] = $first_sites[$site_id] + 1;
                                                        } else {
                                                            $first_sites[$site_id] = 1;
                                                        }
                                                    }
                                                    if (count($second_company)) {
                                                        if (in_array($pairs_index + 1, $second_real_company)) {
                                                            if (isset($second_users[$user_id])) {
                                                                $second_users[$user_id] = $second_users[$user_id] + 1;
                                                            } else {
                                                                $second_users[$user_id] = 1;
                                                            }
                                                            if (isset($second_sites[$site_id])) {
                                                                $second_sites[$site_id] = $second_sites[$site_id] + 1;
                                                            } else {
                                                                $second_sites[$site_id] = 1;
                                                            }
                                                        }
                                                    }
                                                }
                                                $result_vaild = 1;
                                                for ($user_index = 1; $user_index <= $user_count; $user_index++) {
                                                    if (isset($first_users[$user_index])) {
                                                        $first_copmany_user = $first_users[$user_index];
                                                    } else {
                                                        $first_copmany_user = 0;
                                                    }
                                                    if (isset($second_users[$user_index])) {
                                                        $second_company_user = $second_users[$user_index];
                                                    } else {
                                                        $second_company_user = 0;
                                                    }
                                                    if (abs($first_copmany_user - $second_company_user) > 1) {
                                                        $result_vaild = 0;
                                                        break;
                                                    }
                                                }
                                                if ($result_vaild == 0) {
                                                    break;
                                                }
                                                for ($site_index = 1; $site_index <= $sites_count; $site_index++) {
                                                    if (isset($first_sites[$site_index])) {
                                                        $first_copmany_site = $first_sites[$site_index];
                                                    } else {
                                                        $first_copmany_site = 0;
                                                    }
                                                    if (isset($first_sites[$site_index])) {
                                                        $second_copmany_site = $first_sites[$site_index];
                                                    } else {
                                                        $second_copmany_site = 0;
                                                    }
                                                    if (abs($first_copmany_site - $second_copmany_site) > 1) {
                                                        $result_vaild = 0;
                                                        break;
                                                    }
                                                }
                                                if ($result_vaild == 0) {
                                                    break;
                                                }
                                                $output_result_html = $first_count . ' ' . $second_count . PHP_EOL;
                                                for ($result_index = 0; $result_index < $first_count; $result_index++) {
                                                    if ($result_index)
                                                        $output_result_html = $output_result_html . ' ';
                                                    $output_result_html = $output_result_html . $first_company[$first_index][$result_index];
                                                }
                                                $output_result_html = $output_result_html . PHP_EOL;
                                                for ($result_index = 0; $result_index < $second_count; $result_index++) {
                                                    if ($result_index)
                                                        $output_result_html = $output_result_html . ' ';
                                                    $output_result_html = $output_result_html . $second_real_company[$result_index];
                                                }
                                                $output_ok = 1;
                                                break;
                                            }
                                            if ($output_ok == 1) {
                                                break;
                                            }
                                        }
                                        if ($output_ok == 1) {
                                            break;
                                        }
                                    }
                                    if ($output_ok == 1) {
                                        break;
                                    }
                                }
                            }
                            echo $output_header_html;
                            echo $output_result_html;
                            echo $output_footer_html;
                        } else {
                            echo $output_header_html;
                            echo 'Please input the vaild values.';
                            echo $output_footer_html;
                        }
                    } else {
                        echo $output_header_html;
                        echo 'Please input values.';
                        echo $output_footer_html;
                    }
                }
            }
        ?>
    </body>
</html>