<?php
$input = file_get_contents('input.txt');
if (!$input)
    return 0;

$trees = [];
foreach (explode(PHP_EOL, $input) as $line)
    $trees[] = str_split($line);
$row_trees = count($trees);
$column_trees = count($trees[0] ?? []);

$tree_score = [0, 0, 0];    // score, i, j
$visible_trees = $row_trees * 2
    + ($column_trees - 2) * 2;
for ($i = 1; $i < $row_trees - 1; $i++)
    for ($j = 1; $j < $column_trees - 1; $j++) {
        // Prima parte
        // if (
        //     checkDirection($i, $j, 'i', -1) ||
        //     checkDirection($i, $j, 'i', 1) ||
        //     checkDirection($i, $j, 'j', -1) ||
        //     checkDirection($i, $j, 'j', 1)
        // )
        //     $visible_trees++;

        // Seconda parte
        $actual_tree_score =
            checkDirection($i, $j, 'i', -1) *
            checkDirection($i, $j, 'i', 1) *
            checkDirection($i, $j, 'j', -1) *
            checkDirection($i, $j, 'j', 1);
        if ($actual_tree_score > $tree_score[0]) {
            $tree_score = [$actual_tree_score, $i, $j];
        }
    }
echo ("Visible trees: {$visible_trees}");
// Non è ottimizzato, bisognerebbe salvare ad es. la posizione dell'albero più alto
// per non controllare di nuovo tutti gli alberi in quella direzione

echo ('Max tree score: ');
print_r($tree_score);

function checkDirection(int $i, int $j, string $move, int $delta)
{
    global $trees, $row_trees, $column_trees;

    $prima_parte = false;

    $found_tree = 0;
    $actual_height = $trees[$i][$j];
    do {
        $found_tree++;
        $$move += $delta;
        $check_height = $move === 'i'
            ? $trees[$$move][$j]
            : $trees[$i][$$move];
        if ($actual_height <= $check_height)
            return $prima_parte ? false : $found_tree;
    } while (
        $$move > 0 &&
        $$move < ($move === 'i' ? $row_trees : $column_trees) - 1
    );

    return $prima_parte ? true : $found_tree;
}
