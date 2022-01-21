<?php

/*
 * Complete the 'repeatedString' function below.
 *
 * The function is expected to return a LONG_INTEGER.
 * The function accepts following parameters:
 *  1. STRING s
 *  2. LONG_INTEGER n
 */

function repeatedString($s, $n) {
    $num_as = 0;

    if (strlen($s) > $n) {
        $num_as = substr_count($s,"a",0,$n);
    } else {
        $repeats = floor($n/strlen($s));
        $remainder = $n % strlen($s);

        $num_as = substr_count($s,"a",0) * (empty($repeats) ? 1 : $repeats);
        $num_as += substr_count($s,"a",0,$remainder);
    }
    return $num_as;
}

$fptr = fopen(getenv("OUTPUT_PATH"), "w");

$s = rtrim(fgets(STDIN), "\r\n");

$n = intval(trim(fgets(STDIN)));

$result = repeatedString($s, $n);

fwrite($fptr, $result . "\n");

fclose($fptr);