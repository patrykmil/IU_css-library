export async function deleteComponent(componentId, componentElement) {
    try {
        const response = await fetch('/deleteComponent', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({componentID: componentId}),
        });
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const resp = await response.json();
        if (resp['success'] === true) {
            if (componentElement) {
                componentElement.style.display = 'none';
            }
        } else {
            console.error('Error deleting component');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}