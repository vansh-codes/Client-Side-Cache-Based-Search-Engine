<?php
session_start();
require_once 'cache_handler.php';

header('Content-Type: application/json');

$query = isset($_GET['query']) ? trim($_GET['query']) : '';

if (empty($query)) {
    echo json_encode(['error' => 'No search term provided.']);
    exit;
}

// Directories to search
$directories = ['content', 'notes'];

// Check if results exist in cache
$cachedResults = getCache($query);

if ($cachedResults) {
    // Return cached results
    echo json_encode([
        'source' => 'cache',
        'results' => $cachedResults
    ]);
    exit;
}

// Perform a fresh search
$results = performSearch($directories, $query);

// Save fresh results to cache
setCache($query, $results);

echo json_encode([
    'source' => 'live',
    'results' => $results
]);

/**
 * Function to perform a directory search
 */
function performSearch($directories, $query)
{
    $results = [];

    foreach ($directories as $dir) {
        // Include files with specified extensions
        foreach (glob("$dir/*.{html,txt,md}", GLOB_BRACE) as $file) {
            $content = file_get_contents($file);

            if (stripos($content, $query) !== false) {
                $results[] = [
                    'file' => basename($file),
                    'path' => $file,
                    'snippet' => getSnippet($content, $query)
                ];
            }
        }
    }

    return $results;
}

/**
 * Function to extract a snippet from file content
 */
function getSnippet($content, $query)
{
    $start = stripos($content, $query);

    if ($start === false) {
        return 'No snippet available.';
    }

    // Extract snippet with a 30-character context around the query
    return substr($content, max(0, $start - 30), 60) . '...';
}
