document.addEventListener('DOMContentLoaded', () => {
    const banButton = document.querySelector('.ban');
    const banMessagesModal = document.getElementById('ban-messages');
    const closeModal = document.querySelector('.close');
    const confirmBanButton = document.getElementById('ban-button');
    const banSelect = document.getElementById('ban-select');

    if (banButton) {
        banButton.addEventListener('click', () => {
            banMessagesModal.style.display = 'flex';
        });
    }

    if (closeModal) {
        closeModal.addEventListener('click', () => {
            banMessagesModal.style.display = 'none';
        });
    }

    if (confirmBanButton) {
        confirmBanButton.addEventListener('click', async () => {
            const componentId = banButton.getAttribute('data-component-id');
            const messageId = banSelect.value;
            await adminDeleteComponent(componentId, messageId);
        });
    }
});

async function adminDeleteComponent(componentId, messageId) {
    try {
        const response = await fetch('/adminDeleteComponent', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({componentID: componentId, messageID: messageId}),
        });
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const resp = await response.json();
        console.log(resp);
        if (resp['success'] === true) {
            window.location.href = '/browse';
        }
    } catch (error) {
        console.error('Error:', error);
    }
}