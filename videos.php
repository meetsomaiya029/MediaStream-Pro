<?php
// Set directories
$videoDir = 'D:\\XAMPP\\htdocs\\video_streaming_web\\videos\\';
$thumbDir = 'D:\\XAMPP\\htdocs\\video_streaming_web\\thumbnails\\';

// URL paths for web access
$videoUrlPath = '/video_streaming_web/videos/';
$thumbUrlPath = '/video_streaming_web/thumbnails/';

// Ensure the thumbnail directory exists
if (!is_dir($thumbDir)) {
    mkdir($thumbDir, 0777, true);
}

// Path to FFmpeg executable
$ffmpegPath = 'D:\\FFMPEG\\ffmpeg-7.0.2-essentials_build\\bin\\ffmpeg.exe';

// Scan for video files
$files = array_diff(scandir($videoDir), array('.', '..'));

$videos = array();
foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) === 'mp4') {
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $thumbnailPath = $thumbDir . $filename . '.jpg';
        $videoPath = $videoDir . $file;
        
        // Generate thumbnail if it doesn't exist
        if (!file_exists($thumbnailPath)) {
            // FFmpeg command to generate thumbnail
            $cmd = "\"$ffmpegPath\" -i \"$videoPath\" -ss 00:00:01.000 -vframes 1 \"$thumbnailPath\" 2>&1";
            $output = array();
            $return_var = 0;
            exec($cmd, $output, $return_var);

            // Log FFmpeg output for debugging
            $logfile = 'ffmpeg_log.txt';
            $logdata = "Command: $cmd\nOutput:\n" . implode("\n", $output) . "\nReturn var: $return_var\n\n";
            file_put_contents($logfile, $logdata, FILE_APPEND);

            // Check if FFmpeg command was successful
            if ($return_var !== 0) {
                error_log("FFmpeg failed to generate thumbnail for: $videoPath\nOutput: " . implode("\n", $output));
                $thumbnailPath = 'default-thumbnail.jpg'; // Use a default thumbnail if generation fails
            }
        }

        $videos[] = array(
            'title' => $filename,
            'src' => $videoUrlPath . $file,
            'thumbnail' => file_exists($thumbnailPath) ? $thumbUrlPath . $filename . '.jpg' : 'default-thumbnail.jpg'
        );
    }
}

// Set JSON header and return video data
header('Content-Type: application/json');
echo json_encode($videos);
?>
