import {deleteComponent} from './deleteComponent.js';

document.addEventListener('DOMContentLoaded', () => {
    const deleteButton = document.querySelector('.delete');
    if (deleteButton) {
        deleteButton.addEventListener('click', async (event) => {
                const componentId = deleteButton.getAttribute('data-component-id');
                await deleteComponent(componentId, null);
                window.location.replace('/collection');
            }
        );
    }
});