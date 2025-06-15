import {getCardapioByInterval} from './ajax.js';

const btn = document.querySelector('#btn-submit');

btn.addEventListener("click", function(e){
    const inicio = document.querySelector("#inicio").value;
    const fim = document.querySelector("#fim").value;

    if (inicio.length !== 0 && fim.length !== 0)
    {
        document.getElementsByTagName("table")[0].style.display = "table"; // deixando tabela visivel

        const data = {
            inicio: inicio,
            fim: fim
        };

        getCardapioByInterval(data).then(result => {
            const container_filtro = document.getElementById("container-filtro");

            container_filtro.style.display = "none"; // tira o filtro
            
            const tablebody = document.getElementById("tablebody");
            result.forEach(element => {
                const linha = document.createElement('tr');
                
                let coluna = document.createElement('td');
                coluna.innerHTML = element["data_cardapio"];
                linha.appendChild(coluna);

                coluna = document.createElement('td');
                coluna.innerHTML = element["dia"];
                linha.appendChild(coluna);

                coluna = document.createElement('td');
                coluna.innerHTML = element["proteina"];
                linha.appendChild(coluna);

                coluna = document.createElement('td');
                coluna.innerHTML = element["principal"];
                linha.appendChild(coluna);

                coluna = document.createElement('td');
                coluna.innerHTML = element["sobremesa"];
                linha.appendChild(coluna);

                tablebody.appendChild(linha);
            });
        });
                    
    }
});