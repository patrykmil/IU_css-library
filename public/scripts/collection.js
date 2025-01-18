document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.btn-group .btn');
    const components = document.querySelectorAll('.components');

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            buttons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            components.forEach(component => component.classList.remove('active'));
            const targetClass = button.id;
            document.querySelector(`.components.${targetClass}`).classList.add('active');
        });
    });
});