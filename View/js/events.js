document.addEventListener('DOMContentLoaded', function() {
    if (window.innerWidth <= 768) {
        const hamburger = document.getElementById('hamburger-menu');
        const navList = document.getElementById('nav-list');

        hamburger.addEventListener('click', function() {
            navList.classList.toggle('show'); // Adiciona ou remove a classe "show"
        });

        document.addEventListener('click', function(event) {
            if (!navList.contains(event.target) && !hamburger.contains(event.target)) {
                navList.classList.remove('show'); // Remove a classe "show" ao clicar fora
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", () => {
    const changePasswordButton = document.querySelector('.alterar-senha-2');
    const popup = document.querySelector('#alterar-senha-popup-2');
    const closePopupButton = document.querySelector('#close-popup-2');

    if (changePasswordButton) {
        changePasswordButton.addEventListener('click', () => {
            popup.style.display = 'flex';
        });
    }

    if (closePopupButton) {
        closePopupButton.addEventListener('click', () => {
            popup.style.display = 'none';
        });
    }
});

export function showNotification(message, type) {
    const notification = document.querySelector("#notification");
    const inputUser = document.querySelector("#matricula");
    const inputPass = document.querySelector("#password");

    notification.innerHTML = message;
    notification.className = `notification ${type}`;
    notification.style.opacity = 1;

    inputUser.value = "";
    inputPass.value = "";
    // check();

    setTimeout(() => {
        notification.style.opacity = 0;
    }, 2500);

    setTimeout(() => {
        notification.className = "notification"; 
        notification.innerHTML = "";
    }, 3000);
}

export function addFields() {
    const data_inicio = document.querySelector('#data-inicio').value;
    const data_fim = document.querySelector('#data-fim').value;

    if (data_inicio || data_fim) {
        const inicio = new Date(data_inicio);
        const fim = new Date(data_fim);
        const component = document.querySelector('.content');
        component.innerHTML = "";
        fim.setDate(fim.getDate() + 1);

        const diaSemanaNomes = ['segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sábado', 'domingo'];
        const dias_da_semana_entre_datas = {};

        for (let data = inicio; data < fim; data.setDate(data.getDate() + 1)) {
            const dia_da_semana_numero = data.getDay();
            dias_da_semana_entre_datas[data.toISOString().slice(0, 10)] = diaSemanaNomes[dia_da_semana_numero];
        }

        for (const [data, dia_da_semana] of Object.entries(dias_da_semana_entre_datas)) {
            const divItem = document.createElement('div');
            divItem.classList.add('dia-semana');

            const createField = (labelText, placeholder, id) => {
                const label = document.createElement('label');
                label.setAttribute('for', id);
                label.textContent = labelText;

                const input = document.createElement('input');
                input.setAttribute('id', id);
                input.setAttribute('name', id);
                input.setAttribute('placeholder', placeholder);
                input.required = true;

                const div = document.createElement('div');
                div.appendChild(label);
                div.appendChild(input);
                return div;
            };

            divItem.appendChild(createField(dia_da_semana.charAt(0).toUpperCase() + dia_da_semana.slice(1) + '-feira', 'Proteína', dia_da_semana));
            divItem.appendChild(createField("‎", 'Acompanhamento', 'acompanhamento-' + dia_da_semana));
            divItem.appendChild(createField("‎", 'Sobremesa', 'sobremesa-' + dia_da_semana));

            component.appendChild(divItem);
        }

        const buttonContainer = document.querySelector('.botao-container');
        buttonContainer.style.display = "flex";
    }
}

export function cardapio_popup() {
    const deleteButton = document.querySelector('.excluir');
    const editButton = document.querySelector('.editar');
    const container = document.querySelector('.container');
    const div = document.createElement('div');
    const label = document.createElement('div');
    const confirmBtn = document.createElement('button');
    const cancelBtn = document.createElement('button');
    const divBtns = document.createElement('div');

    confirmBtn.classList.add('validar');
    cancelBtn.classList.add('cancelar');
    deleteButton.disabled = true;
    editButton.disabled = true;

    label.textContent = 'Excluir Cardápio?';

    confirmBtn.addEventListener('click', () => {
        fetch("cardapio.php", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ sinal: "Sinal enviado!" })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Erro ao enviar sinal");
            }
            document.body.classList.remove('popup-open');
            container.removeChild(div);
            location.reload();
        })
        .catch(error => {
            console.error("Erro ao enviar sinal: " + error);
        });
    });

    cancelBtn.addEventListener('click', () => {
        document.body.classList.remove('popup-open');
        container.removeChild(div);
        deleteButton.disabled = false;
        editButton.disabled = false;
    });

    div.classList.add('popup');
    divBtns.classList.add('botao-container');

    div.appendChild(label);
    divBtns.appendChild(cancelBtn);
    divBtns.appendChild(confirmBtn);
    div.appendChild(divBtns);
    container.appendChild(div);

    document.body.classList.add('popup-open');
}

export function agendar_popup() {
    const popupContainer = document.querySelector('.container');
    const div = document.createElement('div');
    const label = document.createElement('div');
    const confirmBtn = document.createElement('button');
    const cancelBtn = document.createElement('button');
    const divBtns = document.createElement('div');

    confirmBtn.classList.add('validar');
    cancelBtn.classList.add('cancelar');

    label.textContent = 'Deseja salvar as alterações?';

    confirmBtn.addEventListener('click', () => {
        fetch("agendados.php", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ sinal: "Sinal enviado!" })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Erro ao enviar sinal");
            }
            document.body.classList.remove('popup-open');
            popupContainer.removeChild(div);
            location.reload();
        })
        .catch(error => {
            console.error("Erro ao enviar sinal: " + error);
        });
    });

    cancelBtn.addEventListener('click', () => {
        document.body.classList.remove('popup-open');
        popupContainer.removeChild(div);
    });

    div.classList.add('popup');
    divBtns.classList.add('botao-container');

    div.appendChild(label);
    divBtns.appendChild(cancelBtn);
    divBtns.appendChild(confirmBtn);
    div.appendChild(divBtns);
    popupContainer.appendChild(div);

    document.body.classList.add('popup-open');
}

export function showIndexPopup() {
    const div = document.querySelector('.popup-index');

    div.style.display = "flex";

    setTimeout(() => {
        div.classList.add('hide-popup-index');
        setTimeout(() => {
            div.style.display = "none";
        }, 500);
    }, 3500);
}

export function passSection() {
    const form = document.querySelector("#alterar-senha-form-2");
    form.innerHTML = "";

    const items = {
        label1: createElement('label', { for: 'new-password-2', textContent: 'Nova Senha:' }),
        input1: createElement('input', { type: 'password', id: 'new-password-2', name: 'new-password', required: true }),
        label2: createElement('label', { for: 'confirm-password-2', textContent: 'Confirmar Senha:' }),
        input2: createElement('input', { type: 'password', id: 'confirm-password-2', name: 'confirm-password', required: true }),
        labelError: createElement('div', { id: 'error-2' }),
        submit: createElement('button', { textContent: 'Confirmar' })
    };

    items.submit.addEventListener('click', function (event) {
        event.preventDefault();
        const input1 = document.querySelector('#new-password-2');
        const input2 = document.querySelector('#confirm-password-2');

        if (input1.value && input2.value) {
            if (input1.value === input2.value) {
                fetch('perfil.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ sinal: 'changePass-confirm', dado: input2.value })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => Promise.reject(`Network response was not ok: ${text}`));
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'sucesso') {
                        window.location.href = 'perfil.php?id=1';
                    } else {
                        console.log('Resposta inesperada:', data);
                    }
                })
                .catch(error => console.error('Houve um problema com a requisição:', error));
            } else {
                items.labelError.textContent = 'Senhas não coincidem';
            }
        } else {
            items.labelError.textContent = 'Os campos não podem estar vazios';
        }
    });

    Object.values(items).forEach(item => form.appendChild(item));
}

export function imprimirCardapio() {
    // Obter o innerHTML da tabela
    const tableHTML = document.querySelector('.print-content').outerHTML;

    // Abrir uma nova janela para impressão
    const printWindow = window.open(
        'imprimir-cardapio.php', 
        'imprimirJanela', 
        'width=1024,height=768,top=100,left=100,scrollbars=yes,resizable=yes'
    );

    // Enviar o conteúdo da tabela para a nova janela
    printWindow.onload = () => {
        printWindow.postMessage(tableHTML, '*');
    };
}