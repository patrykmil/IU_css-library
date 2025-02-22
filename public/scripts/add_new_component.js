document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.new-component-form');
    const tagsContainer = document.querySelector('.tags');
    const htmlTextarea = document.querySelector('#htmlTextarea');
    const cssTextarea = document.querySelector('#cssTextarea');

    form.addEventListener('submit', async (event) => {
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
        for (const key of formData.keys()) {
            console.log(key, formData.getAll(key));
        }


        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log('Response:', data);

            if (data.url) {
                window.location.href = data.url;
            }
            else {
                alert(data.error);
            }
        } catch (error) {
            console.error("Error:", error);
            if (error.response) {
                console.log('Error response:', await error.response.json());
            }
        }
    });
});