function validateEmail(email) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}

function validatePassword(password) {
    const passwordPattern = /^[A-Za-z0-9-?!%&$_=+#]*$/;
    return passwordPattern.test(password) && password.length >= 8;
}

function validateNickname(nickname) {
    const nicknamePattern = /^[A-Za-z0-9-?_]*$/;
    return nicknamePattern.test(nickname) && nickname.length >= 3;
}

function validateForm(event) {
    const emailInput = document.querySelector('input[name="email-input"]');
    const nicknameInput = document.querySelector('input[name="nickname-input"]');
    const passwordInput = document.querySelector('input[name="password-input"]');

    let isValid = true;

    if (!validateEmail(emailInput.value)) {
        emailInput.classList.add('invalid');
        isValid = false;
    } else {
        emailInput.classList.remove('invalid');
    }

    if (!validatePassword(passwordInput.value)) {
        passwordInput.classList.add('invalid');
        isValid = false;
    } else {
        passwordInput.classList.remove('invalid');
    }

    if (!validateNickname(nicknameInput.value)) {
        nicknameInput.classList.add('invalid');
        isValid = false;
    } else {
        nicknameInput.classList.remove('invalid');
    }

    if (!isValid) {
        event.preventDefault();
    }

    return isValid;
}

document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.login-form');
    form.addEventListener('submit', validateForm);
});