<?php
$input = file_get_contents('input.txt');
if (!$input)
    return 0;

$lines = explode(PHP_EOL, $input);
$monkey = 0;
$monkeys = [];
foreach ($lines as $line) {
    $line = trim($line);
    if (!$line)
        continue;

    $instruction = explode(' ', $line);
    switch ($instruction[0]) {
        case 'Monkey':
            $monkey = str_replace(':', '', $instruction[1]);
            break;
        case 'Starting':
            [, $items] = explode('Starting items: ', $line);
            $monkeys[$monkey]['items'] = explode(', ', $items);
            break;
        case 'Operation:':
            [, $operation] = explode('Operation: ', $line);
            $monkeys[$monkey]['operation'] = str_replace(
                ['new', 'old'],
                ['$new', '$old'],
                $operation
            ) . ';';
            break;
        case 'Test:':
            [, $divisible] = explode('Test: divisible by ', $line);
            $monkeys[$monkey]['divisible'] = $divisible;
            break;
        case 'If':
            [, $state,,,, $to] = explode(' ', $line);
            $monkeys[$monkey][str_replace(':', '', $state)] = $to;
            break;
    }
}

$moves = 20;
while ($moves--) {
    foreach ($monkeys as &$monkey) {
        if (!isset($monkey['round']))
            $monkey['round'] = 0;
        $monkey['round'] += count($monkey['items']);
        foreach ($monkey['items'] as $item) {
            $old = $item;
            eval($monkey['operation']);
            $new = floor($new / 3);
            $divisible = $new % $monkey['divisible'] === 0
                ? 'true'
                : 'false';
            $monkeys[$monkey[$divisible]]['items'][] = $new;
        }
        $monkey['items'] = [];
    }
}

uasort($monkeys, function ($a, $b) {
    return $a['round'] > $b['round'];
});
print_r($monkeys);
echo ($monkeys[5]['round'] * $monkeys[7]['round']);
