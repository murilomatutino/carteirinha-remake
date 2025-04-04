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
