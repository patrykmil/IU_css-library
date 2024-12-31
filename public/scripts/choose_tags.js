document.addEventListener('DOMContentLoaded', () => {
    const tagsInput = document.querySelector('#tags_input');
    const tagsContainer = document.querySelector('.tags');

    tagsInput.addEventListener('change', () => {
        const tagValue = tagsInput.value.trim();
        if (tagValue) {
            const tagButton = document.createElement('button');
            tagButton.textContent = tagValue;
            tagButton.classList.add('tag-button');
            tagButton.type = 'button';
            tagsContainer.appendChild(tagButton);
            tagsInput.value = '';
        }
    });

    tagsContainer.addEventListener('click', (event) => {
        if (event.target.classList.contains('tag-button')) {
            tagsContainer.removeChild(event.target);
        }
    });
});