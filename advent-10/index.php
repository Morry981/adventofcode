<?php
$input = file_get_contents('input.txt');
if (!$input)
    return 0;

$sprite = [];

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

    // Seconda parte
    $sprite_line = floor($cycle / 40);
    if ($sprite_line > 5) break;

    $current_cycle = $cycle % 40;
    $sprite[$sprite_line][] = ($current_cycle == $x - 1
        || $current_cycle == $x
        || $current_cycle == $x + 1
    )
        ? '#'
        : '_';
}
echo ("Total sum: {$total_sum}");

// Seconda parte
echo (PHP_EOL);
foreach ($sprite as $line)
    echo (implode($line) . PHP_EOL);
