import {getRelatorioDiario, getNameById} from './ajax.js';

const btn = document.querySelector('#btn-submit');

btn.addEventListener("click", function(e){
    const date = document.querySelector("#date").value;

    if (date.length !== 0)
    {
        const data = {
            date: date
        };

        getRelatorioDiario(data).then(result => {
            const container_filtro = document.getElementById("container-filtro");

            container_filtro.style.display = "none"; // tira o filtro

            const tablebody = document.getElementById("tablebody");
            
            if (result.length == 0)
            {
                document.getElementById("container-filtro").style.display = "none";
                document.getElementsByTagName("table")[0].style.display = "none";
                document.getElementById("sem-agendamento").style.display = "block";
            }
            else
            {
                document.getElementsByTagName("table")[0].style.display = "table"; // deixando tabela visivel

                result.forEach(element => {
                    const linha = document.createElement('tr');
                    const coluna = document.createElement('td');
                    const coluna2 = document.createElement('td');
                    
                    const dados = {
                        id: element["id_usuario"]
                    };

                    getNameById(dados).then(retorno =>{
                        coluna.innerHTML = retorno["nome"];
                    });

                    coluna2.innerHTML = element["hora_solicitacao"];

                    linha.appendChild(coluna);
                    linha.appendChild(coluna2);

                    tablebody.appendChild(linha);
            });
            }
            
        });
                    
    }
});