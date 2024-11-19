<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['directory'])) {
    $directory = $_POST['directory'];
    if (is_dir($directory)) {
        array_map('unlink', glob("$directory/*.*")); // Delete all files
        rmdir($directory); // Remove directory
        header('Location: notes.php');
        exit;
    }
}
