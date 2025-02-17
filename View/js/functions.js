export function check() {
    const submit = document.querySelector("#submit");
    const user = document.querySelector("#matricula");
    const password = document.querySelector("#password");

    const isValid = user.value && password.value;
    submit.disabled = !isValid;
    submit.classList.toggle("enabled", isValid);
}

export function adicionarCardapio() {
    window.location.href = "cardapio-criar.php";
}

export function cancelarCardapio() {
    window.location.href = "cardapio.php";
}

export function sendNotification(type) {
    const popup = document.querySelector('#notificationPopup');
    const popupList = document.querySelector('#notificationvList');
    const popupButtons = document.querySelector('.buttons');

    if (type === 1) {
        popupButtons.remove();
        popup.classList.add("transformPopup");
        popupList.innerHTML = '';

        const array = createSend();
        setTimeout(() => {
            array.forEach(element => popup.appendChild(element));
        }, 500);
    }
}

export function createElement(tag, attributes) {
    const element = document.createElement(tag);
    Object.assign(element, attributes);
    return element;
}

export function printCardapio() { window.print(); }