import {getRelatorioDiario} from './ajax.js';

const btn = document.querySelector('#btn-submit');

btn.addEventListener("click", function(e){
    const date = document.querySelector("#date").value;

    if (date.length !== 0)
    {
        console.log(date);

        const data = {
            date: date
        };

        getRelatorioDiario(data).then(result => {
            const container_filtro = document.getElementById("container-filtro");

            container_filtro.style.display = "none"; // tira o filtro

            const tablebody = document.getElementById("tablebody");
            console.log(tablebody);
            result.forEach(element => {
                const linha = document.createElement('tr');
                const coluna = document.createElement('td');
                const coluna2 = document.createElement('td');
                console.log(result[0]);
                coluna.innerHTML = result[0]["id_usuario"] ;
                coluna2.innerHTML = result[0]["hora_solicitacao"];

                linha.appendChild(coluna);
                linha.appendChild(coluna2);

                tablebody.appendChild(linha);
            });
        });
                    
    }
});