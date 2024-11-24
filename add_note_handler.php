<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $directory = $_POST['directory'] ?? '';
    $noteTitle = $_POST['noteTitle'] ?? '';
    $noteContent = $_POST['noteContent'] ?? '';
    $fileType = $_POST['fileType'] ?? '';

    if (empty($directory) || empty($noteTitle) || empty($noteContent) || empty($fileType)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    // Validate directory
    if (!is_dir($directory) || strpos(realpath($directory), __DIR__) !== 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid directory.']);
        exit;
    }

    // Create note file
    $noteFile = rtrim($directory, '/') . '/' . preg_replace('/[^a-zA-Z0-9-_]/', '_', $noteTitle) . '.' . $fileType;
    if (file_put_contents($noteFile, $noteContent)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save note.']);
    }
}
