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
    createSetButton.onclick = () => {
        const newSetName = document.querySelector('#newSetName').value;
        if (newSetName) {
            createNewSet(newSetName);
        }
    };
}

function createNewSet(setName) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/createSet', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const sets = JSON.parse(xhr.responseText);
            updateSetList(sets);
            document.querySelector('#popup').style.display = 'none';
        }
    };
    xhr.send('setName=' + encodeURIComponent(setName));
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