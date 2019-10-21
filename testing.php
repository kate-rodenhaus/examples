<?php

require_once '/var/web/core/vendor/autoload.php';

$hourglasses =
[
	[1,1,1,0,0,0],
	[0,1,0,0,0,0],
	[1,1,1,0,0,0],
	[0,0,2,4,4,0],
	[0,0,0,2,0,0],
	[0,0,1,2,4,0]
];

$hour_glass_totals = [];

for ($i=0; $i < 4; $i++) {
	for ($j=0; $j <= 4; $j++) {
		$hour_glass_totals[] = $hourglasses[$i][$j] + $hourglasses[$i][$j+1] + $hourglasses[$i][$j+2] +
			$hourglasses[$i+1][$j] + $hourglasses[$i+1][$j+1] + $hourglasses[$i+1][$j+2] +
			$hourglasses[$i+2][$j] + $hourglasses[$i+2][$j+1] + $hourglasses[$i+2][$j+2];
	}
}

echo "Max total is " . max($hour_glass_totals);
