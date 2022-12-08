<?php
$input = file_get_contents('input.txt');
if (!$input)
    return 0;

$containers = [
    ['F', 'C', 'J', 'P', 'H', 'T', 'W'],
    ['G', 'R', 'V', 'F', 'Z', 'J', 'B', 'H'],
    ['H', 'P', 'T', 'R', '', '', '', ''],
    ['Z', 'S', 'N', 'P', 'H', 'T'],
    ['N', 'V', 'F', 'Z', 'H', 'J', 'C', 'D'],
    ['P', 'M', 'G', 'F', 'W', 'D', 'Z'],
    ['M', 'V', 'Z', 'W', 'S', 'J', 'D', 'P'],
    ['N', 'D', 'S'],
    ['D', 'Z', 'S', 'F', 'M'],
];

$moves = explode(PHP_EOL, $input);
for ($i = 0; $i < count($moves); $i++) {
    if (!$moves[$i])
        continue;

    preg_match_all('/\s\d+/', $moves[$i], $instruction);
    [$move, $from, $to] = $instruction[0];

    // Prima parte
    // for (; $move > 0; $move--) {
    //     $crave = array_pop($containers[$from - 1]);
    //     $containers[$to - 1][] = $crave;
    // }

    // Seconda parte
    $craves = array_slice($containers[$from - 1], -$move);
    $containers[$from - 1] = array_slice($containers[$from - 1], 0, count($containers[$from - 1]) - $move);
    $containers[$to - 1] = array_merge($containers[$to - 1], $craves);
}
echo ('Last items:' . PHP_EOL);
for ($i = 0; $i < count($containers); $i++)
    echo (array_pop($containers[$i]));

// Starting point
//     [H]         [D]     [P]        
// [W] [B]         [C] [Z] [D]        
// [T] [J]     [T] [J] [D] [J]        
// [H] [Z]     [H] [H] [W] [S]     [M]
// [P] [F] [R] [P] [Z] [F] [W]     [F]
// [J] [V] [T] [N] [F] [G] [Z] [S] [S]
// [C] [R] [P] [S] [V] [M] [V] [D] [Z]
// [F] [G] [H] [Z] [N] [P] [M] [N] [D]
//  1   2   3   4   5   6   7   8   9 