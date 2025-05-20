import * as ajax from './ajax.js';

const tableBody = document.querySelector('tbody');
const diasSemana = ['Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira'];
const colunas = ['Proteína', 'Principal', 'Sobremesa'];
const dadosCardapio = {};

const mapTipos = {
    proteina: 'Proteína',
    principal: 'Principal',
    sobremesa: 'Sobremesa'
};

tags.forEach(item => {
    const tipoNormalizado = mapTipos[item.tipo.toLowerCase()];
    if (!tipoNormalizado) {
        console.warn(`Tipo não reconhecido: ${item.tipo}`);
        return;
    }
    if (!dadosCardapio[tipoNormalizado]) {
        dadosCardapio[tipoNormalizado] = [];
    }
    dadosCardapio[tipoNormalizado].push(item.nome);
});

let currentTipoCriacao = null;
let currentContainer = null;

const fecharPopup = (container = null) => {
    if (container !== null) {
        container.querySelector('.search-box').value = '';
        container.classList.remove('opened');
        document.body.classList.remove('dropdown-opened');
    } else {
        document.querySelector('#tagPopup').style.display = 'none';
    }
    document.querySelectorAll('.search-box').forEach(search => search.value = '');
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
    closeBtn.onclick = () => fecharPopup(container);

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
                    const tag_option = tags.find(tag =>
                        tag.nome.toLowerCase() === opcao.toLowerCase()
                    );

                    const inputElement = container.querySelector('.master-input');
                    inputElement.classList.remove('sem-restricoes', 'gluten', 'lactose', 'gluten-lactose');
                    inputElement.classList.add(tag_option.restricoes.trim());

                    input.value = opcao;
                    container.classList.remove('opened');
                    document.body.classList.remove('dropdown-opened');
                    container.querySelector('.search-box').value = '';

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
            cancelarBusca.onclick = () => fecharPopup(container);

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

    colunas.forEach(coluna => {
        const td = document.createElement('td');
        td.appendChild(criarDropdown(coluna));
        tr.appendChild(td);
    });

    tableBody.appendChild(tr);
});

function getInfoRestricao(info) {
    switch (info) {
        case 'Contém glúten': return 'gluten';
        case 'Contém lactose': return 'lactose';
        case 'Contém glúten e lactose': return 'gluten-lactose';
        default: return 'sem-restricoes';
    }
}

function getInfoRestricaoSub(info) {
    switch (info) {
        case 'G': return 'gluten';
        case 'L': return 'lactose';
        case 'GL': return 'gluten-lactose';
        default: return 'sem-restricoes';
    }
}

document.querySelector('#confirmCreate').onclick = async () => {
    const input = document.querySelector('#newTagName');
    const nome = input.value.trim();
    if (nome === '') return;

    if (!dadosCardapio[currentTipoCriacao].includes(nome)) {
        const selecionado = document.querySelector("input[name='restricao']:checked");
        const restricao = selecionado ? selecionado.value : null;

        const restricoesMapeadas = {
            'G':  { gluten: 1, lactose: 0 },
            'L':  { gluten: 0, lactose: 1 },
            'GL': { gluten: 1, lactose: 1 },
            'SR': { gluten: 0, lactose: 0 }
        };

        const tipoMapeado = {
            'Proteína': 'proteina',
            'Principal': 'principal',
            'Sobremesa': 'sobremesa'
        };

        const { gluten = 0, lactose = 0 } = restricoesMapeadas[restricao] || {};
        const tipoCriacao = tipoMapeado[currentTipoCriacao] || null;

        const data = {
            nome: nome,
            tipo: tipoCriacao,
            gluten: gluten,
            lactose: lactose,
            operacao: 'criarTag',
        };

        const resultado = await ajax.enviarNovaTag(data);

        if (resultado) {
            tags.push({
                nome: nome,
                tipo: tipoCriacao,
                restricoes: getInfoRestricaoSub(restricao),
                gluten: gluten,
                lactose: lactose
            });

            dadosCardapio[currentTipoCriacao].push(nome);

            if (selecionado) {
                const info = getInfoRestricaoSub(restricao);
                const inputElement = currentContainer.querySelector('.master-input');
                inputElement.classList.remove('sem-restricoes', 'gluten', 'lactose', 'gluten-lactose');
                inputElement.classList.add(info);
                document.querySelector('#default').checked = true;
            }

            fecharPopup();
            currentContainer.querySelector('.master-input').value = nome;
        } else {
            alert('Erro ao cadastrar a tag. Verifique os dados e tente novamente.');
        }
    }
};

document.querySelector('#cancelCreate').onclick = () => {
    document.querySelector('#tagPopup').style.display = 'none';
    document.querySelector('#newTagName').value = '';
};

document.querySelector('#save').onclick = () => {
    const linhas = tableBody.querySelectorAll('tr');
    const cardapio = [];

    let camposFaltando = false;

    linhas.forEach((linha, i) => {
        const celulas = linha.querySelectorAll('td');
        const registro = { dia: diasSemana[i] };

        colunas.forEach((coluna, j) => {
            const valor = celulas[j].querySelector('input').value.trim();
            registro[coluna] = valor;

            if ((coluna === 'Proteína' || coluna === 'Principal') && valor === '') {
                camposFaltando = true;
            }
        });

        cardapio.push(registro);
    });

    if (camposFaltando) {
        alert('Preencha todos os campos obrigatórios: Proteína e Principal para todos os dias.');
        return;
    }

    console.log(cardapio);
    const dados = {
        operacao: 'criarCardapio',
        cardapio: JSON.stringify(cardapio),
    }

    const resultado = ajax.enviarCardapio(dados);
    if (resultado) {
        alert('Cardápio criado com sucesso!');
        window.location.href = 'cardapio.php';
    } else {
        alert('Erro ao criar o cardápio. Tente novamente.');
    }    
};

document.addEventListener('click', function(event) {
    const tagPopup = document.querySelector('#tagPopup');
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