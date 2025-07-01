if (window.location.pathname.endsWith("feedbacks.php")) {
    const agrupado = {};

    feedbacks.forEach(item => {
        const id = item.id_cardapio;
        const nota = item.id_nota;

        if (!agrupado[id]) {
            agrupado[id] = {
                totalNota: 0,
                quantidade: 0,
                notas: { nota5: 0, nota4: 0, nota3: 0, nota2: 0, nota1: 0 },
                data: item.data_hora,
                registros: item.registros || 0 
            };
        } else {
            agrupado[id].registros = Math.max(agrupado[id].registros, item.registros || 0);
        }

        agrupado[id].totalNota += nota;
        agrupado[id].quantidade += 1;
        agrupado[id].notas[`nota${nota}`]++;
    });

    const cores = ['#2d7754', '#3f9969', '#84c181', '#c6e48b', '#fbd44c'];
    const container = document.getElementById('graficos-container');

    Object.entries(agrupado).forEach(([id, dados]) => {
        const chartId = `chart${id}`;
        const total = dados.quantidade;
        const confirmados = dados.registros;

        const porcentagens = [
            ((dados.notas.nota5 / total) * 100).toFixed(0),
            ((dados.notas.nota4 / total) * 100).toFixed(0),
            ((dados.notas.nota3 / total) * 100).toFixed(0),
            ((dados.notas.nota2 / total) * 100).toFixed(0),
            ((dados.notas.nota1 / total) * 100).toFixed(0)
        ];

        const legendaHTML = `
            <div id="legend">
                <div class="legend-item"><div class="legend-color" style="background:${cores[0]}"></div>5 estrelas - ${porcentagens[0]}%</div>
                <div class="legend-item"><div class="legend-color" style="background:${cores[1]}"></div>4 estrelas - ${porcentagens[1]}%</div>
                <div class="legend-item"><div class="legend-color" style="background:${cores[2]}"></div>3 estrelas - ${porcentagens[2]}%</div>
                <div class="legend-item"><div class="legend-color" style="background:${cores[3]}"></div>2 estrelas - ${porcentagens[3]}%</div>
                <div class="legend-item"><div class="legend-color" style="background:${cores[4]}"></div>1 estrela - ${porcentagens[4]}%</div>
            </div>`;

        const bloco = document.createElement('div');
        bloco.id = "expDiv";
        bloco.className = "container";
        bloco.innerHTML = `
            <div class="header">Refeição de boa qualidade (${new Date(dados.data).toLocaleDateString('pt-BR')})</div>
            <div class="content">
                <canvas id="${chartId}" width="200" height="200"></canvas>
                ${legendaHTML}
                <div>
                    <div class="details">
                        <p>Alunos que almoçaram: ${confirmados}</p>
                        <p>Alunos que deram feedback: ${total}</p>
                        <button class="more-details" id="menu${id}">Mais detalhes</button>
                    </div>
                </div>
            </div>
        `;
        container.appendChild(bloco);

        document.querySelectorAll('.more-details').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.id.replace('menu', '');
                function xorEncrypt(text, key) {
                    let result = '';
                    for (let i = 0; i < text.length; i++) {
                        result += String.fromCharCode(text.charCodeAt(i) ^ key.charCodeAt(i % key.length));
                    }
                    return btoa(result);
                }

                const key = "ledsifba";
                const encrypted = xorEncrypt(id, key);
                window.location.href = `relatorio-feedbacks.php?id=${encrypted}`;
            });
        });

        const ctx = document.getElementById(chartId).getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['5 estrelas', '4 estrelas', '3 estrelas', '2 estrelas', '1 estrela'],
                datasets: [{
                    data: [
                        dados.notas.nota5,
                        dados.notas.nota4,
                        dados.notas.nota3,
                        dados.notas.nota2,
                        dados.notas.nota1
                    ],
                    backgroundColor: cores,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: false }
                }
            }
        });
    });

    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll('.header').forEach(header => {
            header.addEventListener('click', () => {
                const content = header.nextElementSibling;
                content.classList.toggle('open');
                content.style.opacity = content.classList.contains('open') ? '1' : '0';
            });
        });
    });
} else {
    const tbody = document.querySelector("#relatorio-table tbody");
    feedbacksAll.forEach(item => {
        const tr = document.createElement("tr");

        tr.innerHTML = `
            <td data-label="Nome">${item.nome.charAt(0).toUpperCase() + item.nome.slice(1).toLowerCase()}</td>
            <td data-label="Matrícula">${item.matricula}</td>
            <td data-label="Data">${formatarData(item.data_refeicao)}</td>
            <td data-label="Dia">${item.dia}</td>
            <td data-label="Principal">${item.principal}</td>
            <td data-label="Acompanhamento">${item.acompanhamento}</td>
            <td data-label="Sobremesa">${item.sobremesa || '-'}</td>
            <td data-label="Nota">${item.id_nota}</td>
        `;

        tbody.appendChild(tr);
    });

    function formatarData(dataISO) {
        const [ano, mes, dia] = dataISO.split('-');
        return `${dia}/${mes}/${ano}`;
    }
}
