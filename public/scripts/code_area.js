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

css_textarea.addEventListener('input', () => {
    autoExpand(css_textarea);
});

html_textarea.addEventListener('input', () => {
    autoExpand(html_textarea);
});

html_textarea.addEventListener('keydown', enableTab);
css_textarea.addEventListener('keydown', enableTab);
