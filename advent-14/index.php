<?php
$input = file_get_contents('input.txt');
if (!$input)
    return 0;

$space = [];
$max_y = $max_x = -999;
$lines = array_unique(explode(PHP_EOL, $input));
foreach ($lines as $line) {
    $rocks_position = explode(' -> ', $line);
    for ($i = 0; $i < count($rocks_position) - 1; $i++) {
        [$rock1x, $rock1y] = explode(',', $rocks_position[$i]);
        [$rock2x, $rock2y] = explode(',', $rocks_position[$i + 1]);

        $first = true;
        do {
            if (!$first) {
                $rock1x -= $rock1x <=> $rock2x;
                $rock1y -= $rock1y <=> $rock2y;
            } else $first = false;
            $space[$rock1x][$rock1y] = '|';
            if ($rock1y > $max_y)
                $max_y = $rock1y;
            if ($rock1x > $max_x)
                $max_x = $rock1x + 2;
        } while ($rock1x != $rock2x || $rock1y != $rock2y);
    }
}

$sand = -1;
do {
    $sand++;
    $x = 500;
    $y = 0;
} while (tryPosition($x, $y) !== 'end');

// Result
for ($i = 0; $i < $max_y + 5; $i++) {
    for ($j = 480; $j < $max_x + 5; $j++) {
        echo ($space[$j][$i] ?? '.');
    }
    echo (PHP_EOL);
}
echo ($sand . PHP_EOL);

function tryPosition($x, $y)
{
    global $space, $max_x, $max_y;

    if ($x > $max_x && $y > $max_y)
        return 'end';

    if (!block($x, $y + 1))
        return tryPosition($x, $y + 1);

    if (!block($x - 1, $y + 1))
        return tryPosition($x - 1, $y + 1);

    if (!block($x + 1, $y + 1))
        return tryPosition($x + 1, $y + 1);

    $space[$x][$y] = 'o';
}
function block($x, $y)
{
    global $space;

    return in_array($space[$x][$y] ?? '.', ['|', 'o']);
}
