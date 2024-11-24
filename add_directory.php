<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['directoryName'])) {
    $directoryName = basename($_POST['directoryName']);
    $path = __DIR__ . "/$directoryName";
    if (!is_dir($path)) {
        mkdir($path);
        header('Location: notes.php');
        exit;
    } else {
        echo "<script>
        alert('Directory already exists.');
        setTimeout(function() {
            window.location.href = 'notes.php';
        }, 200);
        </script>";
        exit;
    }
}
