<?php
// utils/file_indexer.php

// Path to content and notes folder
define('CONTENT_DIR', __DIR__ . '/../content/');
define('NOTES_DIR', __DIR__ . '/../notes/');
define('BASE_URL', 'http://localhost/');

// Search content files for query
function searchContent($query)
{
    $results = [];
    $directories = [CONTENT_DIR, NOTES_DIR];
    $fileTypes = '*.{html,txt,md}';

    foreach ($directories as $dir) {
        $files = glob($dir . $fileTypes, GLOB_BRACE);

        foreach ($files as $file) {
            // Check for cached content
            $content = getCachedFile($file);
            // If content is not cached, read the file
            if (!$content) {
                $content = file_get_contents($file);
            }

            // If the query is found in the content, cache and add to results
            if (stripos($content, $query) !== false) {
                if (!$content) {
                    cacheFileContent($file, $content); // Cache only matched files
                    error_log("Caching content for $file");
                } else {
                    error_log("Using cached content for $file");
                }

                // Convert the file path to a URL path
                $relativePath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $file);
                $results[] = [
                    'file' => basename($file),
                    'snippet' => highlightQuery(getSnippet($content, $query), $query),
                    'path' => BASE_URL . $relativePath,
                ];
            }
        }
    }

    return array_slice($results, 0, 10); // Return the first 10 results as a basic form of pagination
}

function highlightQuery($text, $query)
{
    $safeQuery = htmlspecialchars($query); // escape the query only
    return str_ireplace($safeQuery, "<strong>$safeQuery</strong>", $text);
}

// Extract snippet containing the keyword
function getSnippet($content, $query)
{
    $position = stripos($content, $query);
    return substr($content, max(0, $position - 30), 60) . '...';
}

// Check for cached version of a file
function getCachedFile($file)
{
    $cacheFile = __DIR__ . '/../cache/files/' . basename($file) . '.cache';
    if (file_exists($cacheFile) && filemtime($cacheFile) >= filemtime($file)) {
        return file_get_contents($cacheFile);
    }
    return false;
}

// Cache content to a cache file
function cacheFileContent($file, $content)
{
    $fileCacheDir = __DIR__ . '/../cache/files/';
    if (!is_dir($fileCacheDir)) mkdir($fileCacheDir, 0755, true);

    $cacheFile = $fileCacheDir . basename($file) . '.cache';
    file_put_contents($cacheFile, $content);
}