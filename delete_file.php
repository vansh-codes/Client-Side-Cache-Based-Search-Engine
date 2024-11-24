<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['file'])) {
    $file = $_POST['file'];
    if (is_file($file)) {
        unlink($file);
        header('Location: notes.php');
        exit;
    }
}
