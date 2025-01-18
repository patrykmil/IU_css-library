document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('.share').addEventListener('click', (event) => {
        event.preventDefault();
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            console.log('Link copied to clipboard successfully!');
        }).catch((error) => {
            console.error('Error copying link:', error);
        });
    });
});