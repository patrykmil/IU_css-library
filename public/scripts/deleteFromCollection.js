import {deleteComponent} from './deleteComponent.js';
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.delete').forEach((button) => {
        button.addEventListener('click', async (event) => {
            event.preventDefault();
            const componentId = button.getAttribute('data-component-id');
            const componentElement = document.getElementById(`component-${componentId}`).closest('.browse_item');
            await deleteComponent(componentId, componentElement);
        });
    });
});