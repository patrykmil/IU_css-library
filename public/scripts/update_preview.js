document.addEventListener('DOMContentLoaded', () => {
    const previewContainer = document.querySelector('.component-preview');
    const style_element = document.createElement('style');
    document.head.appendChild(style_element);

    if (htmlTextarea && cssTextarea && preview-container) {
        htmlTextarea.addEventListener('input', () => {
            previewContainer.innerHTML = htmlTextarea.value;
        });

        cssTextarea.addEventListener('input', () => {
            style_element.innerHTML = `.component-preview { ${cssTextarea.value} }`;
        });

    } else {
        console.error('Element not found: htmlTextarea or component-preview');
    }
});