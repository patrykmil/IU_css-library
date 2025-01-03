document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.new_component_form');
    const tagsContainer = document.querySelector('.tags');
    const htmlTextarea = document.querySelector('#html_textarea');
    const cssTextarea = document.querySelector('#css_textarea');

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        if (!validateInputs()) {
            console.error('Form submission prevented due to invalid inputs.');
            return;
        }

        const formData = new FormData(form);
        const tags = Array.from(tagsContainer.querySelectorAll('.tag-button')).map(button => button.textContent);
        formData.append('tags', JSON.stringify(tags));
        formData.append('html', htmlTextarea.value);
        formData.append('css', cssTextarea.value);

        console.log('Submitting form data:', formData);

        fetch(form.action, {
            method: 'POST',
            body: formData
        })
            .then(response => {
                console.log('Fetch response:', response);
            });
    });
});