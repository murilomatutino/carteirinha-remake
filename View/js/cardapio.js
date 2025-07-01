import * as ajax from './ajax.js';

/* ---------- Avaliação por estrelas -------------------*/
const starBoxs = document.querySelectorAll(".avaliacao");

// função auxíliar para não repetir código 
function f(i)
{
    starBoxs[i].addEventListener('click', function(e){
    const classStar = e.target.classList;
    const stars = starBoxs[i].children;
    let avaliado = false;

    // convertendo stars para lsita
    const stars_list = Array.from(stars);

    // verifica se o usuario já fez uma avaliação
    stars_list.forEach(function(star)
    {
        if (star.classList.contains("ativo"))
        {
            avaliado = true;
        }
    });

    if (classStar.contains("star-icon") && avaliado === false)
    {
        classStar.add("ativo"); 

        // pega o valor da avaliação
        let rate = e.target.getAttribute("data-avliacao"); 

        // percorre o DOM até retornar o dia associado a linha, ex. de retorno: Quinta-feira (24/05) 
        let dia_string_num = e.target.parentNode.parentNode.parentNode.children[0].innerHTML; 

        let dia = dia_string_num.split(" ")[0]; // Quinta-feira (24/05) -> Quinta-feira

        let data = {
            diaSemana: dia
        };
        
        /* --- envia os dados para o php --- */
        ajax.getUserId().then(idUser => {
            if (!idUser) {
                console.error('ID do usuário não encontrado');
                return;
            }

            ajax.getCardapioId(data)
            .then(idCardapio => {

                let dados = {
                    operacao: 'enviarFeedback',
                    nota: parseInt(rate),
                    idUser: parseInt(idUser),
                    idCardapio: parseInt(idCardapio)
                };

                console.log(dados);
                
                ajax.enviarFeedback(dados).then(result => {
                    window.location.href = 'cardapio.php?feedback=success';
                }).catch(error => {
                    window.location.href = 'cardapio.php?feedback=error';
                });
            })  
            .catch(error => {
                console.error('Erro ao buscar o cardápio:', error);
                return { status: false, nota: none };
            });
        });
    }
})
}

f(0);f(1);f(2);f(3);f(4);


/* ------- pega as avaliações já feitas ------- */

const dia_id = {
    "Segunda-feira": 0,
    "Terça-feira": 1,
    "Quarta-feira": 2,
    "Quinta-feira": 3,
    "Sexta-feira": 4
}

ajax.getUserId().then(idUser => {
    if (!idUser) {
        console.error('ID do usuário não encontrado');
        return;
    }

    const data = {
        idUser: idUser
    }

    ajax.getDadosFeedback(data).then(feedbacks => {
        
        let stars;

        feedbacks.forEach(function(feedback){

            const data = {
                idCardapio: feedback["id_cardapio"]
            }
            ajax.getDiaByID(data).then(resposta =>{
                if (resposta !== null)
                {
                    const dia = resposta[0]["dia"];
                    stars = Array.from(starBoxs[dia_id[dia]].children);
                    stars[5 - feedback["id_nota"]].classList.add("ativo");
                }
            })

            
        });
    });
});