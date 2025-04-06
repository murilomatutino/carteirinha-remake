const tableBody = document.querySelector('tbody');
const diasSemana = ['Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira'];
const colunas = ['Proteína', 'Principal', 'Sobremesa'];

// Dados que virão do backend
// const dadosCardapio = {
//     Proteína: ['Frango', 'Carne', 'Peixe'],
//     Principal: ['Arroz', 'Macarrão', 'Feijão', 'Purê'],
//     Sobremesa: ['Fruta', 'Gelatina', 'Bolo', 'Iogurte']
// };

let currentTipoCriacao = null;
let currentContainer = null;

const fecharPopup = (container = null) => {
    if (container !== null) {
        container.classList.remove('opened');
        document.body.classList.remove('dropdown-opened');
    } else {
        document.querySelector('#tagPopup').style.display = 'none';
    }

    document.querySelectorAll('.search-box').forEach(search => {
        search.value = '';
    });
};

const criarDropdown = (tipo) => {
    const container = document.createElement('div');
    container.className = 'dropdown-container';

    const input = document.createElement('input');
    input.className = 'master-input';
    input.readOnly = true;
    input.placeholder = 'Selecione';

    const dropdown = document.createElement('div');
    dropdown.className = 'dropdown';

    const search = document.createElement('input');
    search.className = 'search-box';
    search.placeholder = 'Buscar...';

    const wrapper = document.createElement('div');
    wrapper.className = 'options-wrapper';

    const closeBtn = document.createElement('button');
    closeBtn.className = 'close-dropdown';
    closeBtn.textContent = 'Cancelar';
    closeBtn.onclick = () => { fecharPopup(container); };

    function atualizarOpcoes(filtro = '') {
        wrapper.innerHTML = '';

        const opcoesFiltradas = dadosCardapio[tipo].filter(opcao =>
            opcao.toLowerCase().includes(filtro.toLowerCase())
        );

        if (opcoesFiltradas.length > 0) {
            opcoesFiltradas.forEach(opcao => {
                const div = document.createElement('div');
                div.className = 'option';
                div.textContent = opcao;
                div.onclick = () => {
                    input.value = opcao;
                    container.classList.remove('opened');
                    document.body.classList.remove('dropdown-opened');
                };
                wrapper.appendChild(div);
            });
        } else {
            const criarNova = document.createElement('div');
            criarNova.className = 'create-option';
            criarNova.textContent = 'Criar nova tag';
            criarNova.onclick = () => {
                document.querySelector('#tagPopup').style.display = 'flex';
                document.querySelector('#newTagName').focus();
                document.querySelector('#newTagName').value = filtro;
                document.querySelector('#tagTitle').textContent = `Criar novo(a) ${tipo}`;
                currentTipoCriacao = tipo;
                currentContainer = container;
            };

            const cancelarBusca = document.createElement('div');
            cancelarBusca.className = 'cancel-option';
            cancelarBusca.textContent = 'Cancelar';
            cancelarBusca.onclick = () => { fecharPopup(container); };

            wrapper.appendChild(criarNova);
            wrapper.appendChild(cancelarBusca);
        }
    }

    search.addEventListener('input', () => atualizarOpcoes(search.value));

    dropdown.appendChild(search);
    dropdown.appendChild(closeBtn);
    dropdown.appendChild(wrapper);
    container.appendChild(input);
    container.appendChild(dropdown);

    input.onclick = () => {
        const isMobile = window.innerWidth <= 600;
        if (isMobile) document.body.classList.add('dropdown-opened');
        container.classList.toggle('opened');
        container.querySelector('.search-box').focus();
        atualizarOpcoes();
    };

    return container;
};

diasSemana.forEach((dia, index) => {
    const tr = document.createElement('tr');
    const th = document.createElement('th');
    th.classList.add('dia-semana');
    th.textContent = dia;
    tr.appendChild(th);

    colunas.forEach((coluna) => {
        const td = document.createElement('td');
        td.appendChild(criarDropdown(coluna));
        tr.appendChild(td);
    });

    tableBody.appendChild(tr);
});

function getInfoRestricao(info) {
    switch (info) {
      case 'Contém glúten':
        return 'gluten';
      case 'Contém lactose':
        return 'lactose'
      case 'Contém glúten e lactose':
        return 'gluten-lactose';
      default:
        return 'sem-restricoes';
    }
}

document.querySelector('#confirmCreate').onclick = () => {
    if (document.querySelector('#newTagName').value === '') return;

    const nome = document.querySelector('#newTagName').value.trim();
    if (nome && !dadosCardapio[currentTipoCriacao].includes(nome)) {
        dadosCardapio[currentTipoCriacao].push(nome);
        const selecionado = document.querySelector("input[name='restricao']:checked");

        if (selecionado) {
            const valor = selecionado.value;
            const info = getInfoRestricao(valor);
            currentContainer.querySelector('.master-input').classList.add(info);

            const radioDefault = document.querySelector('#default');
            radioDefault.checked = true;
        } else {
            console.log('Nenhuma opção selecionada.');
        }
    }

    fecharPopup();
    currentContainer.querySelector('.master-input').value = nome;

    if (currentContainer) {
        const dropdown = currentContainer.querySelector('.dropdown');
        dropdown.querySelector('.search-box').value = '';
        currentContainer.classList.add('opened');
        const wrapper = dropdown.querySelector('.grupo-opcoes-wrapper');
        wrapper.innerHTML = '';
        dadosCardapio[currentTipoCriacao].forEach(opcao => {
            const div = document.createElement('div');
            div.className = 'option';
            div.textContent = opcao;
            div.onclick = () => {
                currentContainer.querySelector('input').value = opcao;
                currentContainer.classList.remove('opened');
                document.body.classList.remove('dropdown-opened');
            };
            wrapper.appendChild(div);
        });
    }
};

document.querySelector('#cancelCreate').onclick = () => {
    document.querySelector('#tagPopup').style.display = 'none';
    document.querySelector('#newTagName').value = '';
};

document.querySelector('#save').onclick = () => {
    const linhas = tableBody.querySelectorAll('tr');
    const dados = [];

    linhas.forEach((linha, i) => {
        const celulas = linha.querySelectorAll('td');
        const registro = { dia: diasSemana[i] };
        colunas.forEach((coluna, j) => {
            const valor = celulas[j].querySelector('input').value;
            registro[coluna] = valor;
        });
        dados.push(registro);
    });
};

document.addEventListener('click', function(event) {
    const tagPopup = document.querySelector('#tagPopup');
    const confirmarBtn = document.querySelector('#confirmCreate');
    const input = tagPopup?.querySelector('#newTagName'); 

    const clicouDentroTagPopup = tagPopup && tagPopup.contains(event.target);
    const clicouConfirmar = event.target.closest('#confirmCreate') !== null;
    const inputPreenchido = input && input.value.trim() !== '';

    if (clicouDentroTagPopup && !(clicouConfirmar && inputPreenchido)) return;

    document.querySelectorAll('.dropdown-container.opened').forEach(container => {
        if (!container.contains(event.target)) {
            fecharPopup(container);
        }
    });
});
