<?php

/*
 * Complete the 'countingValleys' function below.
 *
 * The function is expected to return an INTEGER.
 * The function accepts following parameters:
 *  1. INTEGER steps
 *  2. STRING path
 */

function countingValleys($steps, $path) {
    $position = 0;
    $valleys = 0;
    $path = str_split($path);

    foreach ($path as $step) {
        $before = $position;
        if ($step == "U") {
            $position++;
        } elseif ($step == "D") {
            $position--;
        }

        if ($before == 0 && $position == -1) {
            $valleys++;
            print_r("new valley\n");
        }
    }

    return $valleys;

}

$fptr = fopen(getenv("OUTPUT_PATH"), "w");

$steps = intval(trim(fgets(STDIN)));

$path = rtrim(fgets(STDIN), "\r\n");

$result = countingValleys($steps, $path);

fwrite($fptr, $result . "\n");

fclose($fptr);
