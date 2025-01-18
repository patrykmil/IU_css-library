import {deleteComponent} from './deleteComponent.js';

document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('.delete').addEventListener('click', async (event) => {
            const componentId = document.querySelector('.delete').getAttribute('data-component-id');
            await deleteComponent(componentId, null);
            window.location.replace('/collection');
        }
    );
});