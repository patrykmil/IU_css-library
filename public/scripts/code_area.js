function autoExpand(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 'px';
}

function enableTab(e) {
    if (e.key === 'Tab') {
        e.preventDefault();
        const start = e.target.selectionStart;
        const end = e.target.selectionEnd;

        e.target.value = e.target.value.substring(0, start) + '\t' + e.target.value.substring(end);
        e.target.selectionStart = e.target.selectionEnd = start + 1;
    }
}

cssTextarea.addEventListener('input', () => {
    autoExpand(cssTextarea);
});

htmlTextarea.addEventListener('input', () => {
    autoExpand(htmlTextarea);
});

htmlTextarea.addEventListener('keydown', enableTab);
cssTextarea.addEventListener('keydown', enableTab);
