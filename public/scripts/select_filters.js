document.querySelector('#selectAll').addEventListener('click', function () {
    document.querySelectorAll('.filter-checkbox').forEach(function (checkbox) {
        checkbox.checked = true;
    });
});

document.querySelector('#deselectAll').addEventListener('click', function () {
    document.querySelectorAll('.filter-checkbox').forEach(function (checkbox) {
        checkbox.checked = false;
    });
});

document.querySelector('#filter-form').addEventListener('submit', function (event) {
    const checkboxes = document.querySelectorAll('.filter-checkbox:checked');
    if (checkboxes.length === 0) {
        event.preventDefault();
        alert('Please select at least one filter option.');
    }
});

window.addEventListener('load', function () {
    const params = new URLSearchParams(window.location.search);
    const filters = params.getAll('filters[]');
    const sorting = params.get('sorting');
    const search = params.get('search');

    if (filters.length === 0) {
        document.querySelectorAll('.filter-checkbox').forEach(function (checkbox) {
            checkbox.checked = true;
        });
    } else {
        document.querySelectorAll('.filter-checkbox').forEach(function (checkbox) {
            if (filters.includes(checkbox.value)) {
                checkbox.checked = true;
            }
        });
    }

    if (sorting) {
        document.querySelector('#sorting').value = sorting;
    } else {
        document.querySelector('#sorting').value = 'Most likes';
    }

    if (search) {
        document.querySelector('.search-bar').value = search;
    }
});

const toggleMobileFilters = document.querySelector('#toggleMobileFilters');
const mobile_filters = document.querySelector('.filter');

toggleMobileFilters.addEventListener('click', function () {
    mobile_filters.classList.toggle('active');
});