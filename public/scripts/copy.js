function decodeHtmlSpecialChars(str) {
    const textarea = document.createElement('textarea');
    textarea.innerHTML = str;
    return textarea.value;
}

function stripOuterQuotes(str) {
    if (str.startsWith('"') && str.endsWith('"')) {
        return str.slice(1, -1);
    }
    return str;
}

function copy(html, css) {
    console.log('Copy function called');
    html = stripOuterQuotes(decodeHtmlSpecialChars(decodeURIComponent(html)));
    css = stripOuterQuotes(decodeHtmlSpecialChars(decodeURIComponent(css)));
    console.log('HTML:', html);
    console.log('CSS:', css);
    const content = '<style>\n' + css + '\n</style>\n\n' + html;
    navigator.clipboard.writeText(content).then(function () {
        console.log('Copied to clipboard successfully!');
    }, function (err) {
        console.error('Could not copy text: ', err);
    });
}