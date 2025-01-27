document.addEventListener('DOMContentLoaded', () => {
    const preview_container = document.querySelector('.component-preview');
    const style_element = document.createElement('style');
    document.head.appendChild(style_element);

    if (htmlTextarea && cssTextarea && preview_container) {
        htmlTextarea.addEventListener('input', () => {
            preview_container.innerHTML = htmlTextarea.value;
        });

        cssTextarea.addEventListener('input', () => {
            style_element.innerHTML = `.component-preview { ${cssTextarea.value} }`;
        });

    } else {
        console.error('Element not found: htmlTextarea or component-preview');
    }
});