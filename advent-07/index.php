<?php
$input = file_get_contents('input.txt');
if (!$input)
    return 0;

$commands = explode(PHP_EOL, $input);
$split = false;
$structure = [];
$keys = [];
foreach ($commands as $command) {
    if ($command == '$ ls')
        continue;
    else if ($command == '$ cd ..')
        array_pop($keys);
    else if ($current_dir = split_command($command, '/\$ cd /'))
        $keys[] = $current_dir;
    else if ($dir_name = split_command($command, '/dir /')) {
        $temp_keys = $keys;
        $temp_keys[] = $dir_name;
        add_filesize($structure, $temp_keys);
    } else {
        [$size, $file_name] = explode(' ', $command);
        $temp_keys = $keys;
        $temp_keys[] = $file_name;
        add_filesize($structure, $temp_keys, $size);
    }
}
print_r($structure);

// Prima parte
$total_sum_small_folders = 0;
array_walk_recursive($structure, function ($size, $key) use (&$total_sum_small_folders) {
    if ($key == 'total' && $size <= 100000)
        $total_sum_small_folders += $size;
});
echo ("Total size: {$total_sum_small_folders}" . PHP_EOL);

// Seconda parte
$actual_free_space = 70000000 - $structure['total'];
$required_space = 30000000 - $actual_free_space;
$delete_dirs = [];
array_explore($structure, function ($item, $key) use ($required_space, &$delete_dirs) {
    if ($item['total'] >= $required_space)
        $delete_dirs[] = $item['total'];
});
echo ('Delete dir: ' . min($delete_dirs));


function split_command(string $command, string $regex): string
{
    $split = preg_split($regex, $command);
    $value = false;
    if (count($split) == 2)
        [, $value] = $split;
    return $value;
}
function add_filesize(array &$arr, array $keys, int $size = 0)
{
    $ref = & $arr;
    foreach ($keys as $key) {
        if ($size > 0)
            $ref['total'] = ($ref['total'] ?? 0) + $size;
        $ref = & $ref[$key];
    }

    $ref = $size > 0 ? $size : [];
    unset($ref);
    return true;
}
// https://www.php.net/manual/en/function.array-walk.php#122991 edited
function array_explore(array &$array, callable $callback)
{
    array_walk($array, function (&$value, $key) use (&$array, $callback) {
        if (is_array($value)) {
            $callback($value, $key);
            array_explore($value, $callback);
        }
    });
}