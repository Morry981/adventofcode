<?php
$input = file_get_contents('input.txt');
if (!$input)
    return 0;

$positions = ['0,0'];
$head = $tail = [0, 0];
foreach (explode(PHP_EOL, $input) as $line) {
    [$direction, $moves] = explode(' ', $line);
    // echo ("{$direction} => {$moves}" . PHP_EOL);
    for (; $moves--; $moves >= 0) {
        moveObject($head, $direction);

        // print_r($head);

        if (abs($head[0] - $tail[0]) > 1 || abs($head[1] - $tail[1]) > 1) {
            if (($direction === 'R' || $direction === 'L') && $head[1] != $tail[1])
                $tail[1] = $head[1];
            else if (($direction === 'U' || $direction === 'D') && $head[0] != $tail[0])
                $tail[0] = $head[0];

            moveObject($tail, $direction);

            $positions[] = "{$tail[0]},{$tail[1]}";

            // echo ('--' . PHP_EOL);
            // print_r($tail);
            // echo ('Positions: ' . count(array_unique($positions)) . PHP_EOL . PHP_EOL);
        }
        // if (count($positions) > 3) {
        // print_r($positions);
        // die();
        // }
    }
}
// print_r(array_unique($positions));
echo ('Positions: ' . count(array_unique($positions)));

function moveObject(array &$object, string $direction): void
{
    if ($direction === 'R')
        $object[0] += 1;
    else if ($direction === 'L')
        $object[0] -= 1;
    else if ($direction === 'U')
        $object[1] += 1;
    else if ($direction === 'D')
        $object[1] -= 1;
}