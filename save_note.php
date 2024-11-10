<?php
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    http_response_code(400);
    exit("Invalid input data");
}

$title = $data["title"];
$content = $data["content"];
$fileType = $data["fileType"];
$date = $data["date"];
$time = $data["time"];
$fileName = $data["fileName"];

$filePath = __DIR__ . "/notes/$fileName";

// Save the note content to a file
file_put_contents($filePath, $content);

// Update notes.json with the note metadata
$notesJsonPath = __DIR__ . "/notes.json";
$notesData = file_exists($notesJsonPath) ? json_decode(file_get_contents($notesJsonPath), true) : [];
$notesData[] = [
    "title" => $title,
    "note" => $filePath,
    "date" => $date,
    "time" => $time,
];

file_put_contents($notesJsonPath, json_encode($notesData, JSON_PRETTY_PRINT));
http_response_code(200);
echo "Note saved successfully";
