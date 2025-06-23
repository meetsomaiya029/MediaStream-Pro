<?php
$videoDir = 'videos/';
$thumbDir = 'thumbnails/';
$filename = basename($_GET['file']);
$videoPath = $videoDir . $filename;
$thumbPath = $thumbDir . pathinfo($filename, PATHINFO_FILENAME) . '.jpg';

// Ensure the thumbnail directory exists
if (!is_dir($thumbDir)) {
    mkdir($thumbDir, 0777, true);
}

// Generate thumbnail if it doesn't already exist
if (!file_exists($thumbPath)) {
    $cmd = "ffmpeg -i \"$videoPath\" -ss 00:00:01.000 -vframes 1 \"$thumbPath\"";
    exec($cmd);
}

// Return the thumbnail path
header('Content-Type: application/json');
echo json_encode(array('thumbnail' => $thumbPath));
?>
