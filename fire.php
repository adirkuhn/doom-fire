<?php

$cols = trim(shell_exec('tput cols'));
$lines = trim(shell_exec('tput lines'));


#$cols = 5;
#$lines = 5;
$fireArr = [];

$colorPallet = [
	0 => "\e[48;5;232m ",
	1 => "\e[48;5;52m ",
	2 => "\e[48;5;52m ",
	3 => "\e[48;5;53m ",
	4 => "\e[48;5;88m ",
	5 => "\e[48;5;89m ",
	6 => "\e[48;5;89m ",
	7 => "\e[48;5;90m ",
	8 => "\e[48;5;132m ",
	9 => "\e[48;5;130m ",
	10 => "\e[48;5;167m ",
	11 => "\e[48;5;167m ",
	12 => "\e[48;5;196m ",
	13 => "\e[48;5;196m ",
	14 => "\e[48;5;196m ",
	15 => "\e[48;5;202m ",
	16 => "\e[48;5;202m ",
	17 => "\e[48;5;203m ",
	18 => "\e[48;5;160m ",
	19 => "\e[48;5;160m ",
	20 => "\e[48;5;160m ",
	21 => "\e[48;5;162m ",
	22 => "\e[48;5;162m ",
	23 => "\e[48;5;166m ",
	24 => "\e[48;5;167m ",
	25 => "\e[48;5;168m ",
	26 => "\e[48;5;178m ",
	27 => "\e[48;5;178m ",
	28 => "\e[48;5;179m ",
	29 => "\e[48;5;179m ",
	30 => "\e[48;5;180m ",
	31 => "\e[48;5;142m ",
	32 => "\e[48;5;142m ",
	33 => "\e[48;5;144m ",
	34 => "\e[48;5;185m ",
	35 => "\e[48;5;228m ",
	36 => "\e[48;5;229m "
];

function clearScreen(): void {
	#echo "\033[2J\033[1;1H\e[3J";
	echo "\e[3J\033[1;1H";
	#shell_exec('tput reset');
}

function createFireArray($lines, $cols): array {
	$fireArr = [];

	for ($i = 0; $i < ($lines * $cols); $i++) {
		$fireArr[$i] = 0;
	}

	return $fireArr;
}

function createFireSource(array $fire, int $lines, int $cols): array {
	$size = ($lines * $cols) - $cols;
	for($col = 0; $col < $cols; $col++) {
		$fireSourceIndex = $size + $col;
		$fire[$fireSourceIndex] = 36;
	}

	return $fire;
}

function printFire($colorPallet, $fireArray, $lines, $cols): void {
	for($line = 0; $line < $lines; $line++) {
		for($col = 0; $col < $cols; $col++) {
			$pixelIndex = $col + ($line * $cols);
			echo $colorPallet[$fireArray[$pixelIndex]];
		}
	#	echo PHP_EOL;
	}
}

function updateFireIntensity(array $fire, int $lines, int $cols): array {
	$fireSize = ($lines * $cols);
	for($line = 0; $line < $lines; $line++) {
		for($col = 0; $col < $cols; $col++) {
			$pixelIndex = $col + ($line * $cols);
			$bellowPixel = $pixelIndex + $cols;

			if ($bellowPixel >= $fireSize) {
				continue;
			}

			$decay = rand(0, 2);
			$bellowFireIntensity = $fire[$bellowPixel];
			$newFireIntensity = $bellowFireIntensity - $decay;
			$newFireIntensity = ($newFireIntensity > 0) ? $newFireIntensity : 0;

			$fire[$pixelIndex-$decay] = $newFireIntensity;
		}
	}


	return $fire;
}

clearScreen();
$fireArray = createFireArray($lines, $cols);
$fireArray = createFireSource($fireArray, $lines, $cols);
while (true) {
	clearScreen();
	$fireArray = updateFireIntensity($fireArray, $lines, $cols);
	printFire($colorPallet, $fireArray, $lines, $cols);
	#sleep(1);
}
