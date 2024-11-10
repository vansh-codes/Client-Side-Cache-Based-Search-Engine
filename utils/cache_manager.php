<?php
// utils/cache_manager.php

// Path to cache folder
define('CACHE_DIR', __DIR__ . '/../cache/');

// Fetch cached results if available
function getCachedResults($query)
{
    $cacheFile = CACHE_DIR . 'queries/' . md5($query) . '.json';
    return file_exists($cacheFile) ? json_decode(file_get_contents($cacheFile), true) : null;
}

// Save results to cache
function saveCache($query, $results)
{
    $cacheDir = CACHE_DIR . 'queries/';
    if (!is_dir($cacheDir)) mkdir($cacheDir, 0755, true);

    $cacheFile = $cacheDir . md5($query) . '.json';
    file_put_contents($cacheFile, json_encode($results));
}

function logError($errorMessage) {
    $logFile = __DIR__ . '/../logs/error_log.txt';
    file_put_contents($logFile, date('[Y-m-d H:i:s] ') . $errorMessage . PHP_EOL, FILE_APPEND);
}
