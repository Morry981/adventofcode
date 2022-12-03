<?php
$input = file_get_contents('input.txt');
if (!$input)
    return 0;

$best_elves = [
    -1,
    -2,
    -3,
];
$elves = explode(PHP_EOL . PHP_EOL, $input);
for ($i = 0; $i < count($elves); $i++) {
    $calories = array_sum(explode(PHP_EOL, $elves[$i]));

    for ($j = 0; $j < count($best_elves); $j++) {
        if ($calories > $best_elves[$j]) {
            moveElves($best_elves, $j, $calories);
            break;
        }
    }

}
print_r($best_elves);
echo ('Total: ' . array_sum($best_elves));

function moveElves(&$best_elves, $start, $calories)
{
    array_pop($best_elves);
    array_splice($best_elves, $start, 0, $calories);
}