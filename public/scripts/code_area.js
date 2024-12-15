const css_textarea = document.getElementById('css_textarea');
const html_textarea = document.getElementById('html_textarea');
const css_button = document.getElementById('css_button');
const html_button = document.getElementById('html_button');

function autoExpand(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 'px';
}

css_button.addEventListener('click', () => {
    css_textarea.classList.add('active');
    css_button.classList.add('active');
    html_textarea.classList.remove('active');
    html_button.classList.remove('active');
});

html_button.addEventListener('click', () => {
    html_textarea.classList.add('active');
    html_button.classList.add('active');
    css_textarea.classList.remove('active');
    css_button.classList.remove('active');
});

css_textarea.addEventListener('input', () => autoExpand(css_textarea));
html_textarea.addEventListener('input', () => autoExpand(html_textarea));
