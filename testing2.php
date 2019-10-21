<?php

require_once '/var/web/core/vendor/autoload.php';

$a = [1,2,3,4,5];
$d = 4;

if (count($a) > $d) {
	$popped_value = array_splice($a, 0, $d);
	var_dump(array_merge($a, $popped_value));
} else {
	$remainder = $d % count($a);
	$popped_value = array_splice($a, 0, $remainder);
	var_dump(array_merge($a, $popped_value));
}

$a = [1,2,3,4,5];
$d = 104;

if (count($a) > $d) {
	$popped_value = array_splice($a, 0, $d);
	var_dump(array_merge($a, $popped_value));
} else {
	$remainder = $d % count($a);
	$popped_value = array_splice($a, 0, $remainder);
	var_dump(array_merge($a, $popped_value));
}