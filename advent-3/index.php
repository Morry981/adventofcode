<?php
$input = file_get_contents('input.txt');

if (!$input)
    return 0;

$rucksacks = explode(PHP_EOL, $input);
$total_point = 0;
for ($i = 0; $i < count($rucksacks); $i++) {
    if (!$rucksacks[$i])
        continue;

    $items = str_split($rucksacks[$i]);
    $middle = count($items) / 2;
    $compartment1 = array_slice($items, 0, $middle);
    $compartment2 = array_slice($items, $middle);
    $item = implode(
        '',
        get_duplicates(
            array_merge(array_unique($compartment1), array_unique($compartment2))
        )
    );

    if (!$item)
        continue;

    echo ($item . ' ');
    $value = ord($item) - (preg_match('~^\p{Lu}~u', $item) ? 38 : 96);
    echo (ord($item) . ' - ' . $value . PHP_EOL);
    $total_point += $value;
}
echo ('Total points: ' . $total_point);

function get_duplicates($array)
{
    return array_unique(
        array_diff_assoc($array, array_unique($array))
    );
}