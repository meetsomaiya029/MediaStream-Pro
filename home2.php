<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Streaming</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<header>
    <nav>
        <div class="logo">
            <span>MediaStream Pro</span>
        </div>
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Search videos...">
            <button id="searchButton"><i class="fas fa-search"></i></button>
        </div>
    </nav>
</header>
<main>
    <div class="video-container" id="videoContainer"></div>

    <!-- Pagination Controls -->
    <div class="pagination" id="pagination">
        <div class="page-numbers" id="pageNumbers"></div>
    </div>

    <div class="video-player" id="videoPlayer">
        <video controls id="videoElement" controlsList="nodownload">
            <source id="videoSource" src="" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <button class="closebtn" onclick="closeVideo()">Close</button>
    </div>
</main>

<script src="script.js"></script>
</body>
</html>
