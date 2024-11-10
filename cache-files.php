<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$directory = __DIR__ . '/cache';
if (!is_dir($directory)) {
    echo json_encode([]);
    exit;
}

$files = scandir($directory);
if ($files === false) {
    // If scandir fails, return an empty JSON array
    echo json_encode([]);
    exit;
}

// Remove '.' and '..' entries
$files = array_diff($files, ['.', '..']);
// Map file names to their URLs
$fileUrls = array_map(function ($file) {
    return "/cache/{$file}";
}, $files);

// Output as JSON
header('Content-Type: application/json');
echo json_encode(array_values($fileUrls));
