document.addEventListener('DOMContentLoaded', () => {
    const nameInput = document.querySelector('input[name="name"]');
    const typeInput = document.querySelector('input[name="type"]');
    const setInput = document.querySelector('input[name="set"]');
    const colorInput = document.querySelector('input[name="color"]');


    const validateList = (input) => {
        const datalist = document.getElementById(input.getAttribute('list'));
        const value = input.value;
        const options = datalist.options;
        let isValid = false;
        for (let option of options) {
            if (value === option.value) {
                isValid = true;
                break;
            }
        }
        return [input, isValid];
    }

    const validateName = (input) => {
        const value = input.value;
        return [input, value.length > 0];
    }

    const validateColor = (input) => {
        const value = input.value;
        return [input, /^#[0-9A-F]{6}$/i.test(value)];
    }

    const validateInputs = () => {
        let allValid = true;
        const results = [validateName(nameInput), validateList(typeInput), validateList(setInput), validateColor(colorInput)];
        results.forEach(([input, isValid]) => {
            if (!isValid) {
                allValid = false;
                input.classList.add('invalid');
            } else {
                input.classList.remove('invalid');
            }
        });
        return allValid;
    };
    window.validateInputs = validateInputs;
});