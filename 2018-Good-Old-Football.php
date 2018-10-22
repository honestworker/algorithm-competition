<!-- this is answer of problem G -->
<?php
    if($_POST['input']){
        $input = $_POST['input'];
        $inputArray = explode(" ", $input);

        $friendNum = $inputArray[0];
        $playerNum = $inputArray[1];
        $time = $inputArray[2];
        $cycle = floor($time/5);

        $matchArray = array_fill(0, $playerNum, 0);
        $unmatchArray = array_fill(0, $friendNum - $playerNum, 0);

        $matchedNums = array_keys( array_slice($friends, 0, $playerNum));
        $unMatched = array_slice(array_keys($friends), $playerNum);

        for($i = 0; $i < $cycle; $i++){
            for($j = 0; $j < $playerNum ; $j++){
                $matchArray[$j] += 5;
            }

            $maxkey = array_search(max($matchArray), $matchArray);
            $minkey = array_search(min($unmatchArray), $unmatchArray);

            $tmp = $matchArray[$maxkey];
            $matchArray[$maxkey] = $unmatchArray[$minkey];
            $unmatchArray[$minkey] = $tmp;
        }

        for($j = 0; $j < $playerNum ; $j++){
            $matchArray[$j] += $time%5;
        }

        $result = array_merge($matchArray, $unmatchArray);
        $result = min($result) . ' ' . max($result);
        echo $result;
    }else{
        $result = '';
    }
    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Palindrome Checker</title>
    </head>
    <body>
        <form action="prog.php" method="post">
            Enter First Input(friends, players, time(min)): <input type="text" name="input" value="<?php echo $input ?>" />
            <br>
            Enter Second Input(least time, most time): <input type="text" value="<?php echo $result ?>">
            <br>
            <button type ="submit">Check</button>
        </form>

    </body>
</html>