<?php
$input = file_get_contents('input.txt');
if (!$input)
    return 0;

$sections = explode(PHP_EOL, $input);
$total_pairs = 0;
for ($i = 0; $i < count($sections); $i++) {
    if (!$sections[$i])
        continue;

    [$pair1first, $pair1second, $pair2first, $pair2second] = preg_split('/(-|,)/', $sections[$i]);
    // Prima parte
    if (
        ($pair1first >= $pair2first && $pair1second <= $pair2second) ||
        ($pair1first <= $pair2first && $pair1second >= $pair2second)
    )
        $total_pairs++;
}
echo ("Total pairs: {$total_pairs}");