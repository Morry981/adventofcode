<?php
$input = file_get_contents('input.txt');
if (!$input)
    return 0;

$moves = [
    'X' => 'Rock',
    'Y' => 'Paper',
    'Z' => 'Scissor',
    'A' => 'Rock',
    'B' => 'Paper',
    'C' => 'Scissor',
];
$moves_index = array_keys($moves);

$total_point = 0;
$matches = explode(PHP_EOL, $input);
for ($i = 0; $i < count($matches); $i++) {
    if (!$matches[$i])
        continue;

    [$opponent_move, $elv_move] = explode(' ', $matches[$i]);

    // Seconda parte
    if ($elv_move == 'Y') {
        if ($moves[$opponent_move] == 'Rock')
            $elv_move = 'X';
        else if ($moves[$opponent_move] == 'Scissor')
            $elv_move = 'Z';
        else if ($moves[$opponent_move] == 'Paper')
            $elv_move = 'Y';
    } else if ($elv_move == 'X') {
        if ($moves[$opponent_move] == 'Rock')
            $elv_move = 'Z';
        else if ($moves[$opponent_move] == 'Scissor')
            $elv_move = 'Y';
        else if ($moves[$opponent_move] == 'Paper')
            $elv_move = 'X';
    } else if ($elv_move == 'Z') {
        if ($moves[$opponent_move] == 'Rock')
            $elv_move = 'Y';
        else if ($moves[$opponent_move] == 'Scissor')
            $elv_move = 'X';
        else if ($moves[$opponent_move] == 'Paper')
            $elv_move = 'Z';
    }

    // Condivisa
    $total_point += array_search($elv_move, $moves_index) + 1;
    if ($moves[$elv_move] == $moves[$opponent_move]) {
        // draw
        $total_point += 3;
    } else if (winner($moves[$elv_move], $moves[$opponent_move])) {
        // win
        $total_point += 6;
    } else {
        // lose
        $total_point += 0;
    }
}
echo ("Total points: {$total_point}");

function winner($first_move, $second_move)
{
    return ($first_move == 'Rock' && $second_move == 'Scissor') ||
        ($first_move == 'Scissor' && $second_move == 'Paper') ||
        ($first_move == 'Paper' && $second_move == 'Rock');
}