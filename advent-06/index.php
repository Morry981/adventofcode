<?php
$input = file_get_contents('input.txt');
if (!$input)
    return 0;

// Prima parte: 4
const REQUIRED_CHARS = 14;

$stream = str_split($input);
$found = -1;
$index = 0;
while ($found < 0 && $index < count($stream)) {
    $chars = array_slice($stream, $index, REQUIRED_CHARS);
    if (count(array_unique($chars)) === REQUIRED_CHARS)
        $found = $index + REQUIRED_CHARS;
    $index++;
}
echo ($found < 0
    ? 'Not found'
    : "Found at: {$found}"
);