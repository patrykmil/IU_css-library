document.querySelectorAll('.no-redirect').forEach(element => {
    element.addEventListener('click', event => {
        event.preventDefault();
    });
});