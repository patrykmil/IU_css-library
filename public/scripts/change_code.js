const cssTextarea = document.querySelector('#cssTextarea');
const htmlTextarea = document.querySelector('#htmlTextarea');
const cssButton = document.querySelector('#cssButton');
const htmlButton = document.querySelector('#htmlButton');

cssButton.addEventListener('click', () => {
    cssTextarea.classList.add('active');
    cssButton.classList.add('active');
    htmlTextarea.classList.remove('active');
    htmlButton.classList.remove('active');
});

htmlButton.addEventListener('click', () => {
    htmlTextarea.classList.add('active');
    htmlButton.classList.add('active');
    cssTextarea.classList.remove('active');
    cssButton.classList.remove('active');
});