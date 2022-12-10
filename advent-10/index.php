<?php
$input = file_get_contents('input.txt');
if (!$input)
    return 0;

$exec = [0];
$total_sum = 0;
$x = 1;
$lines = explode(PHP_EOL, $input);
for ($cycle = 0; $cycle < count($exec); $cycle++) {
    if ($cycle < count($lines)) {
        $line = $lines[$cycle];
        $exec[] = 0;
        if ($line !== 'noop') {
            [, $value] = explode(' ', $line);
            $exec[] = $value;
        }
    }

    if ($cycle === 20 || ($cycle - 20) % 40 === 0)
        $total_sum += $x * $cycle;
    $x += $exec[$cycle];
}
echo ("Total sum: {$total_sum}");
