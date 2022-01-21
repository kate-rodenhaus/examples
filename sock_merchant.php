<?php

/*
 * Complete the 'sockMerchant' function below.
 * There is a large pile of socks that must be paired by color. Given an array of integers representing the color of each sock, determine how many pairs of socks with matching colors there are.
 * The function is expected to return an INTEGER.
 * The function accepts following parameters:
 *  1. INTEGER n
 *  2. INTEGER_ARRAY ar
 */

function sockMerchant($n, $ar) {
    $num_pairs = 0;

    while (!is_null($color = array_pop($ar))) {
        $match = array_search($color, $ar, true);
        if ($match !== false) {
            $num_pairs++;
            array_splice($ar, $match, 1);
        }
    }

    return $num_pairs;
}

$fptr = fopen(getenv("OUTPUT_PATH"), "w");

$n = intval(trim(fgets(STDIN)));

$ar_temp = rtrim(fgets(STDIN));

$ar = array_map('intval', preg_split('/ /', $ar_temp, -1, PREG_SPLIT_NO_EMPTY));

$result = sockMerchant($n, $ar);

fwrite($fptr, $result . "\n");

fclose($fptr);
