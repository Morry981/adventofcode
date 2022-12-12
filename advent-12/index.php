<?php
$input = file_get_contents('input.txt');
if (!$input)
    return 0;

$lines = explode(PHP_EOL, $input);
foreach ($lines as &$line) {
    $line = str_split($line);
    foreach ($line as &$letter) {
        $letter = ($letter === 'S')
            ? 1
            : (($letter === 'E')
                ? 26
                : ord($letter) - 96);
        echo ($letter . ' ');
    }
    echo (PHP_EOL);
}

$graph = [];
$rows = count($lines);
$cols = count($lines[0] ?? []);
for ($r = 0; $r < $rows; $r++)
    for ($c = 0; $c < $cols; $c++) {
        $current = $lines[$r][$c];

        $key = "{$r},{$c}";
        $found = false;
        if ($r < $rows - 1) {
            $found |= addNode($r + 1, $c, $current, $graph[$key]);
        }

        if ($c < $cols - 1) {
            $found |= addNode($r, $c + 1, $current, $graph[$key]);
        }

        if ($r > 0) {
            $found |= addNode($r - 1, $c, $current, $graph[$key]);
        }

        if ($c > 0) {
            $found |= addNode($r, $c - 1, $current, $graph[$key]);
        }

        if (!$found)
            echo ($key . PHP_EOL);
    }

function addNode($r, $c, $current, &$graph)
{
    global $lines;

    $next = $lines[$r][$c];
    if ($next <= $current + 1) {
        $graph[] = "{$r},{$c}";
        return true;
    }
    return false;
}

print_r(bfs_path($graph, '20,0', '20,68'));

// Cercata
function bfs_path($graph, $start, $end)
{
    $queue = new SplQueue();
    # Enqueue the path
    $queue->enqueue([$start]);
    $visited = [$start];
    while ($queue->count() > 0) {
        $path = $queue->dequeue();
        # Get the last node on the path
        # so we can check if we're at the end
        $node = $path[sizeof($path) - 1];

        if ($node === $end) {
            return $path;
        }
        foreach ($graph[$node] ?? [] as $neighbour) {
            if (!in_array($neighbour, $visited)) {
                $visited[] = $neighbour;
                # Build new path appending the neighbour then and enqueue it
                $new_path = $path;
                $new_path[] = $neighbour;
                $queue->enqueue($new_path);
            }
        }
        ;
    }
    return false;
}



die();


// Mia versione originale (controlla tutte le possibilità, troppi tentativi)
$found = false;
$possibles = [
    ['0,0'],
];
$rows = count($lines);
$cols = count($lines[0] ?? []);
$current_possible = 0;
while (!$found) {
    foreach ($possibles as $possible) {
        [$r, $c] = explode(',', end($possible));
        $current = $lines[$r][$c];

        if ($current > 26) {
            echo ($current . PHP_EOL);
            print_r([$r, $c]);
            $found = true;
            break;
        }

        if ($r < $rows - 1) {
            addPossibility($r + 1, $c, $current, $possible);
        }

        if ($c < $cols - 1) {
            addPossibility($r, $c + 1, $current, $possible);
        }

        if ($r > 0) {
            addPossibility($r - 1, $c, $current, $possible);
        }

        if ($c > 0) {
            addPossibility($r, $c - 1, $current, $possible);
        }

        unset($possibles[$current_possible]);
        $current_possible++;
    }
}
print_r(array_shift($possibles));


function addPossibility($r, $c, $current, $possible)
{
    global $lines, $possibles;

    $next = $lines[$r][$c];
    if ($next === $current || $next === $current + 1) {
        $key = "{$r},{$c}";
        if (!in_array($key, $possible)) {
            // Tentativo
            // array_splice($possibles, 1, 0, [array_merge($possible, [$key])]);
            $possibles[] = array_merge($possible, [$key]);
        }
    }
}