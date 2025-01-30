document.addEventListener('DOMContentLoaded', () => {
    const setInput = document.querySelector('input[list="sets"]');
    setInput.addEventListener('input', () => {
        if (setInput.value === "+create new") {
            showPopup();
            setInput.value = '';
        }
    });
});

function showPopup() {
    const popup = document.querySelector('#popup');
    popup.style.display = 'flex';

    const closeBtn = document.querySelector('.close');
    closeBtn.onclick = () => {
        popup.style.display = 'none';
    };

    const createSetButton = document.querySelector('#createSetButton');
    createSetButton.onclick = async () => {
        const newSetName = document.querySelector('#newSetName').value;
        if (newSetName) {
            await createNewSet(newSetName);
        }
    };
}

async function createNewSet(setName) {
    try {
        const response = await fetch('/createSet', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({setName: setName}),
        });
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const sets = await response.json();
        console.log(sets);
        updateSetList(sets);
        document.querySelector('#popup').style.display = 'none';
    }
    catch (error) {
        console.error('Error:', error);
    }
}

function updateSetList(sets) {
    const datalist = document.querySelector('#sets');
    datalist.innerHTML = '';
    sets.forEach(set => {
        const option = document.createElement('option');
        option.value = set;
        datalist.appendChild(option);
    });
    const option = document.createElement('option');
    option.value = '+create new';
    datalist.appendChild(option);
}