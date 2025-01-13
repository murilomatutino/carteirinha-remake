export function check() {
    const submit = document.querySelector("#submit");
    const user = document.querySelector("#matricula");
    const password = document.querySelector("#password");

    const isValid = user.value && password.value;
    submit.disabled = !isValid;
    submit.classList.toggle("enabled", isValid);
}

export function enviarFormulario() {
    const formElement = document.querySelector("#form");
    const formData = new FormData(formElement);

    return fetch("../Controller/AuthController.php", {
        method: "POST",
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Erro na requisição: " + response.status);
        }
        return response.text(); 
    })
    .then(data => {
        console.log(data);
        if (data === "logged") {
            const resultDiv = document.querySelector(".result");
            resultDiv.style.display = "flex";
            resultDiv.style.opacity = "1";

            // resolve(data);
        } else {
            throw "error001";
        }
    })
    .catch(error => {
        console.error(error);
        throw error;
    });
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

export function createSend() {
    const items = {
        h3: document.createElement('h3'),
        inputAssunto: document.createElement('input'),
        labelMsg: document.createElement('label'),
        textarea: document.createElement('textarea'),
        labelMatricula: document.createElement('label'),
        input: document.createElement('input'),
        buttonConfirm: document.createElement('button'),
        buttonCancel: document.createElement('button'),
        divButtons: document.createElement('div')
    };

    // Configurações dos elementos
    items.buttonCancel.textContent = 'Cancelar';
    items.buttonCancel.classList.add('close');
    items.buttonCancel.addEventListener('click', () => {
        closeNotificationPopup();
        location.reload();
    });

    items.buttonConfirm.textContent = 'Enviar';
    items.buttonConfirm.classList.add('send');
    items.buttonConfirm.type = 'submit';

    items.divButtons.classList.add('buttons');
    items.h3.textContent = "Enviar Notificação";

    items.labelMsg.textContent = 'Mensagem:';
    items.labelMsg.setAttribute('for', 'notificationMessage');

    Object.assign(items.textarea, {
        id: 'notificationMessage',
        name: 'notificationMessage',
        rows: 4,
        placeholder: 'Digite a mensagem...',
        required: true
    });

    Object.assign(items.inputAssunto, {
        id: 'assunto',
        name: 'assunto',
        placeholder: 'Assunto',
        required: true
    });

    items.labelMatricula.setAttribute('for', 'notificationRecipient');
    items.labelMatricula.textContent = 'Matrícula (deixe em branco para enviar a todos):';
    Object.assign(items.input, {
        id: 'notificationRecipient',
        name: 'notificationRecipient',
        placeholder: 'Digite a matrícula...'
    });

    items.buttonConfirm.addEventListener('click', () => {
        const inputAssunto = document.querySelector('#assunto');
        const input = document.querySelector('#notificationRecipient');
        const msg = document.querySelector('#notificationMessage');
        const popup = document.querySelector('#notificationPopup');

        if (msg.value) {
            const dados = {
                matricula: input.value,
                assunto: inputAssunto.value,
                mensagem: msg.value
            };

            fetch('process/process-notification.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(dados)
            })
            .then(response => response.json())
            .then(data => {
                const h2 = document.createElement('h2');
                const button = document.createElement('button');

                h2.textContent = data.status === "success" ? 'Notificação Enviada!' : 'Notificação enviada a todos!';
                popup.innerHTML = '';
                popup.classList.add('enviado');
                
                button.classList.add('close');
                button.textContent = 'Fechar';
                button.addEventListener('click', () => {
                    closeNotificationPopup();
                    location.reload();
                });

                popup.appendChild(h2);
                popup.appendChild(button);
            })
            .catch(error => console.error('Erro:', error));
        }
    });

    items.divButtons.append(items.buttonConfirm, items.buttonCancel);

    return [items.h3, items.inputAssunto, items.labelMsg, items.textarea, items.labelMatricula, items.input, items.divButtons];
}

const data = {
    tipo: 'especifico',
    mensagem: 'john.doe@example.com',
    destino: ''
};


export function search() {
    const string = document.querySelector('#buscador').value.trim();
    const identifier = /^\d+$/.test(string) ? 'matricula' : 'nome';

    const body = JSON.stringify(string ? { type: identifier, value: string } : { type: 'all' });

    fetch('relatorio-diario.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: body
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => Promise.reject(`Network response was not ok: ${text}`));
        }
        return response.json();
    })
    .then(data => {
        console.log(data);
    })
    .catch(error => {
        console.error('Houve um problema com a requisição:', error);
    });
}

export function checkPass(event) {
    event.preventDefault();
    
    const input = document.querySelector("#current-password").value;
    const data = {
        sinal: "checkPass",
        pass: input
    };

    fetch('perfil.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => Promise.reject(`Network response was not ok: ${text}`));
        }
        return response.text();
    })
    .then(text => {
        document.querySelector("#current-password").value = "";
        const labelErro = document.querySelector('#error');
        
        try {
            const resultado = JSON.parse(text);
            labelErro.textContent = resultado.status === "sucesso" ? "" : resultado.mensagem || "";
            if (resultado.status === "sucesso") {
                passSection();
            }
        } catch (e) {
            console.error('Erro ao analisar JSON:', e);
            console.log('Resposta recebida:', text);
        }
    })
    .catch(error => {
        console.error('Houve um problema com a requisição:', error);
    });
}

export function createElement(tag, attributes) {
    const element = document.createElement(tag);
    Object.assign(element, attributes);
    return element;
}

export function printCardapio() { window.print(); }