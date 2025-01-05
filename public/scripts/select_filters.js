document.getElementById('select_all').addEventListener('click', function () {
    document.querySelectorAll('.filter_checkbox').forEach(function (checkbox) {
        checkbox.checked = true;
    });
});

document.getElementById('deselect_all').addEventListener('click', function () {
    document.querySelectorAll('.filter_checkbox').forEach(function (checkbox) {
        checkbox.checked = false;
    });
});

document.getElementById('filter_form').addEventListener('submit', function (event) {
    const checkboxes = document.querySelectorAll('.filter_checkbox:checked');
    if (checkboxes.length === 0) {
        event.preventDefault();
        alert('Please select at least one filter option.');
    }
});

window.addEventListener('load', function () {
    const params = new URLSearchParams(window.location.search);
    const filters = params.getAll('filters[]');
    const sorting = params.get('sorting');
    console.log(1);
    console.log(filters);

    if (filters.length === 0) {
        document.querySelectorAll('.filter_checkbox').forEach(function (checkbox) {
            checkbox.checked = true;
        });
    } else {
        document.querySelectorAll('.filter_checkbox').forEach(function (checkbox) {
            if (filters.includes(checkbox.value)) {
                checkbox.checked = true;
            }
        });
    }

    if (sorting) {
        document.getElementById('sorting').value = sorting;
    } else {
        document.getElementById('sorting').value = 'Newest';
    }
});