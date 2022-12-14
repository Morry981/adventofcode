<?php
$input = file_get_contents('input.txt');
if (!$input)
    return 0;

$all_packets = [
    [[2]],
    [[6]],
];

// Prima parte
$pairs  = explode(PHP_EOL . PHP_EOL, $input);
$pair_index = 1;
$total_sum = 0;
foreach ($pairs as $pair) {
    [$left_pair, $right_pair] = explode(PHP_EOL, $pair);

    $left = json_decode($left_pair);
    $right = json_decode($right_pair);

    $all_packets[] = $left;
    $all_packets[] = $right;

    $ordered = compare($left, $right);
    echo ($pair_index . PHP_EOL . ($ordered ? 'Ordinato' : 'Non ordinato') . PHP_EOL . PHP_EOL);
    if ($ordered === -1) $total_sum += $pair_index;
    $pair_index++;
}
echo ("Total sum of ordered: {$total_sum}" . PHP_EOL);

// Seconda parte
usort($all_packets, function ($a, $b) {
    return compare($a, $b);
});
$first_decoder = $second_decoder = $index = 0;
foreach ($all_packets as $packet) {
    $index++;
    $p = ($packet[0] ?? [])[0] ?? [];
    if (is_int($p) && count($packet) === 1 && count($packet[0]) === 1) {
        if ($p === 2)
            $first_decoder = $index;
        else if ($p === 6)
            $second_decoder = $index;
    }
}
echo ("{$first_decoder}*{$second_decoder} = " . $first_decoder * $second_decoder);

// Cercata (sbagliavo il secondo pair dove non controllavo che finissero gli elementi del secondo array)
// ed è anche migliore come gli standard sort (return -1/0/1)
function compare($left, $right): int
{
    if (is_int($left) && is_int($right)) {
        return $left <=> $right;
    }

    if (is_array($left) && is_array($right)) {
        for ($i = 0; $i < count($left); ++$i) {
            if (!isset($right[$i])) {
                return 1;
            }

            $compare = compare($left[$i], $right[$i]);

            if (0 === $compare) {
                continue;
            }

            return $compare;
        }

        if (isset($right[$i])) {
            return -1;
        }

        return 0;
    }

    if (is_array($left)) {
        return compare($left, [$right]);
    }

    if (is_array($right)) {
        return compare([$left], $right);
    }

    return 0;
}
