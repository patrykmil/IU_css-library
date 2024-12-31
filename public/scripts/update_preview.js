document.addEventListener('DOMContentLoaded', () => {
    const preview_container = document.querySelector('.content');
    const style_element = document.createElement('style');
    document.head.appendChild(style_element);

    if (html_textarea && css_textarea && preview_container) {
        html_textarea.addEventListener('input', () => {
            preview_container.innerHTML = html_textarea.value;
        });

        css_textarea.addEventListener('input', () => {
            style_element.innerHTML = `.content { ${css_textarea.value} }`;
        });

    } else {
        console.error('Element not found: html_textarea or component_preview');
    }
});