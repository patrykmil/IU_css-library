document.addEventListener('DOMContentLoaded', function () {
    const colorModeSwitch = document.querySelector('#color_mode');
    const preview = document.querySelector('.preview-container');

    function updateBackgroundColor() {
        const isDarkMode = colorModeSwitch.checked;
        preview.style.backgroundColor = isDarkMode ? 'var(--background)' : '#e8e8e8';
    }

    colorModeSwitch.addEventListener('change', updateBackgroundColor);

    updateBackgroundColor();
});