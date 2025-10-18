document.querySelectorAll('a.noReload').forEach(anchor => {
    anchor.addEventListener('click', function(event) {
        event.preventDefault();
        showProgressBar();
        setTimeout(() => {
            window.location.href = this.href;
        }, 500); // Simulate delay, adjust as needed
    });
});

function showProgressBar() {
    const progressBar = document.getElementById('progress-bar');
    progressBar.style.width = '0%';
    setTimeout(() => {
        progressBar.style.width = '100%';
    }, 10); // Slight delay to trigger CSS transition
}