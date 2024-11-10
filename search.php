<?php
// search.php
require_once 'utils/cache_manager.php';
require_once 'utils/file_indexer.php';

$query = $_GET['query'] ?? '';
if (empty($query)) {
    header('Location: index.php');
    exit;
}

// Check if cached results exist
$cachedResults = getCachedResults($query);
if ($cachedResults) {
    // Display cached results
    include 'results.php';
} else {
    // If no cached results, perform search indexing
    $results = searchContent($query);

    // Cache results for future searches
    saveCache($query, $results);

    // Display results
    include 'results.php';
}
