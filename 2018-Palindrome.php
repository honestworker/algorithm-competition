<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Palindrome Checker</title>
    </head>
    <body>
        <form action="proa.php" method="post">
            Enter First Input(Array Length): <input type="text" name="elements_length"/>
            <br>
            Enter Second Input(Array Elements): <input type="text" name="elements_array"/>
            <br>
            <button type ="submit">Check</button>
        </form>
        <?php
            function array_insert($array, $index, $val)
            {
                $size = count($array); //because I am going to use this more than one time
                if (!is_int($index) || $index < 0 || $index > $size)
                {
                    return -1;
                }
                else
                {
                    $temp   = array_slice($array, 0, $index);
                    $temp[] = $val;
                    return array_merge($temp, array_slice($array, $index, $size));
                }
            }
            if ($_POST) {
                if (isset($_POST['elements_length']) && isset($_POST['elements_array'])) {
                    if ($_POST['elements_length'] && $_POST['elements_array']) {
                        $elements_length = str_replace(' ', '', $_POST['elements_length']);

                        $elements_array = trim($_POST['elements_array']);
    
                        $elements_arrays = explode(' ', $elements_array);
                        $elements_counted_length = count($elements_arrays);
                        $elements_length = $elements_counted_length > $elements_length ? $elements_length : $elements_counted_length;
                        $valid_value = 0;
                        if ($elements_length % 2 == 0) {
                            $valid_value = 1;
                            for ($temp_index = 0; $temp_index <= $elements_length / 2; $temp_index++) {
                                if ($elements_arrays[$temp_index] != $elements_arrays[$elements_length - $temp_index - 1]) {
                                    $valid_value = 0;
                                    break;
                                }
                            }
                            if ($valid_value == 1) {
                                echo "<br/>";
                                echo "<p>" . $elements_length / 2 . " 2018</p>";
                            }
                        }
                        if ($valid_value == 0) {
                            for ($index = 0; $index <= $elements_length; $index++) {
                                $temp_elements_arrays = array_insert($elements_arrays, $index, 2018);
                                if (($elements_length + 1) % 2 == 1 && $index == $elements_length / 2) {
    
                                } else {
                                    $temp_elements_arrays[$index] = $temp_elements_arrays[$elements_length - $index];
                                }
                                $valid_value = 1;
                                for ($temp_index = 0; $temp_index <= ($elements_length + 1) / 2; $temp_index++) {
                                    if ($temp_elements_arrays[$temp_index] != $temp_elements_arrays[$elements_length - $temp_index]) {
                                        $valid_value = 0;
                                        break;
                                    }
                                }
                                if ($valid_value == 1) {
                                    echo "<br/>";
                                    echo "<p>" . $index . " " . $temp_elements_arrays[$index] . "</p>";
                                    break;
                                }
                            }
                        }
                        if ($valid_value == 0) {
                            echo "<br/>";
                            echo "<p>-1</p>";
                        }
                    }
                }
            }
        ?>
    </body>
</html>