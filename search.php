<?php
session_start();
header('Content-Type: application/json');

// Get query from URL
$query = $_GET['query'] ?? '';
if (empty($query)) {
    echo json_encode([]);
    exit;
}

// Fetch all directories, excluding specific ones
$baseDir = __DIR__;
$excludedDirs = ['assets', 'templates', 'parsedown-master', 'dfd'];
$allDirs = array_filter(glob("$baseDir/*"), function ($path) use ($excludedDirs) {
    return is_dir($path) && !in_array(basename($path), $excludedDirs);
});

$results = [];

foreach ($allDirs as $dir) {
    foreach (glob("$dir/*.{html,txt,md}", GLOB_BRACE) as $file) {
        $content = file_get_contents($file);
        if (stripos($content, $query) !== false) {
            $results[] = [
                'file' => basename($file),
                'snippet' => getSnippet($content, $query),
                'path' => $file,
            ];
        }
    }
}

echo json_encode($results);

function getSnippet($content, $query)
{
    $start = stripos($content, $query);
    return substr($content, max(0, $start - 30), 60) . '...';
}
