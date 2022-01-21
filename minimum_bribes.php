<?php

/*
 * Complete the 'minimumBribes' function below.
 *
 * The function accepts INTEGER_ARRAY q as parameter.
 */

function minimumBribes($q) {
    $bribes = 0;
    // cycle the people
    foreach ($q as $place => $person){
        // has the person moved up 2 places?
        if ($person - ($place+1) > 2) {
            echo "Too chaotic\n";
            return;
        } elseif ($place != 0) {
            // cycle who is in front
            $possible_skippers = range($person,count($q),1);
            $skippers = array_slice($q,0,$place);
            $bribes += count(array_intersect($possible_skippers,$skippers));
        }
    }

    echo "{$bribes}\n";
    return;
}

$t = intval(trim(fgets(STDIN)));

for ($t_itr = 0; $t_itr < $t; $t_itr++) {
    $n = intval(trim(fgets(STDIN)));

    $q_temp = rtrim(fgets(STDIN));

    $q = array_map('intval', preg_split('/ /', $q_temp, -1, PREG_SPLIT_NO_EMPTY));

    minimumBribes($q);
}
