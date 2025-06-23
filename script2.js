document.getElementById('searchInput').addEventListener('input', function() {
    let filter = this.value.toLowerCase();
    let videos = document.querySelectorAll('.video-card');
    
    videos.forEach(video => {
        let title = video.querySelector('h3').textContent.toLowerCase();
        if (title.includes(filter)) {
            video.style.display = '';
        } else {
            video.style.display = 'none';
        }
    });
});
