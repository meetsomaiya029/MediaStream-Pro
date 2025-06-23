document.addEventListener('DOMContentLoaded', function () {
    const videosPerPage = 10;  // Number of videos per page
    let currentPage = 1;
    let videos = [];

    // Fetch videos data
    fetch('videos.php')
        .then(response => response.json())
        .then(data => {
            videos = data;
            console.log('Fetched Videos:', videos); // Debugging: Check fetched data
            displayVideos();
            setupPagination();
        })
        .catch(error => console.error('Error loading video data:', error));

    function displayVideos() {
        const videoContainer = document.querySelector('.video-container');
        if (!videoContainer) return; // Check if the container exists
        videoContainer.innerHTML = ''; // Clear any existing content

        // Calculate the range of videos to display
        const start = (currentPage - 1) * videosPerPage;
        const end = Math.min(start + videosPerPage, videos.length);
        const videosToShow = videos.slice(start, end);

        // Create video cards for the current page
        videosToShow.forEach(video => {
            const videoCard = document.createElement('div');
            videoCard.className = 'video-card';
            videoCard.onclick = () => openVideo(video.src);

            const thumbnailImg = document.createElement('img');
            thumbnailImg.src = video.thumbnail || 'default-thumbnail.jpg';
            thumbnailImg.alt = 'Video Thumbnail';

            const title = document.createElement('h3');
            title.textContent = video.title;

            videoCard.appendChild(thumbnailImg);
            videoCard.appendChild(title);
            videoContainer.appendChild(videoCard);
        });
    }

    function setupPagination() {
        const paginationContainer = document.querySelector('.pagination');
        if (!paginationContainer) return; // Check if the pagination container exists
        paginationContainer.innerHTML = ''; // Clear existing pagination buttons

        const totalPages = Math.ceil(videos.length / videosPerPage);
        console.log('Total Pages:', totalPages); // Debugging: Check total pages

        if (totalPages > 1) {
            // Create page numbers
            for (let i = 1; i <= totalPages; i++) {
                const pageButton = document.createElement('button');
                pageButton.textContent = i;
                pageButton.className = 'page-button';
                if (i === currentPage) {
                    pageButton.classList.add('active');
                }
                pageButton.onclick = () => {
                    currentPage = i;
                    displayVideos();
                    setupPagination();
                };
                paginationContainer.appendChild(pageButton);
            }
        } else {
            // No pagination needed if there's only one page
            paginationContainer.style.display = 'none';
        }
    }

    // Add search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const filter = this.value.toLowerCase();
            const videoCards = document.querySelectorAll('.video-card');

            videoCards.forEach(card => {
                const title = card.querySelector('h3')?.textContent.toLowerCase() || '';
                card.style.display = title.includes(filter) ? '' : 'none';
            });
        });
    }

    function openVideo(src) {
        const videoPlayer = document.getElementById('videoPlayer');
        const videoElement = document.getElementById('videoElement');
        const videoSource = document.getElementById('videoSource');

        if (videoPlayer && videoElement && videoSource) {
            videoSource.src = src;
            videoElement.load();
            videoPlayer.style.display = 'block';
        }
    }

    // Add close functionality
    const closeBtn = document.getElementById('closeBtn');
    if (closeBtn) {
        closeBtn.addEventListener('click', function () {
            const videoPlayer = document.getElementById('videoPlayer');
            if (videoPlayer) {
                videoPlayer.style.display = 'none';
            }
        });
    }
});
