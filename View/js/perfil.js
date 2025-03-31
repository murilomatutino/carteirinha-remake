// vai pegar os elementos
const a = document.getElementById('link-mudar-senha');
const close = document.getElementById('popup-perfil-close');
const popup_wrapper = document.getElementById('popup-perfil-wrapper');
const infos = document.getElementById('infos');
const alerta = document.getElementById('popup-alerta');
const close_alerta = document.getElementById("popup-alerta-close");
const pai = document.getElementById('pai');


// caso o usuario clique no link 'mudar senha',
// será ocultado a parte de vizualização dos dados
// e irá mostrar um form para mudar a senha
a.addEventListener('click', () =>{
    popup_wrapper.style.display = 'block';
    infos.style.display = 'none';
});

// caso o usario clique no x do form de mudar senha,
//  a pagina voltarar a ficar como no inicio
close.addEventListener('click', () =>{
    popup_wrapper.style.display = 'none';
    infos.style.display = 'flex';
});

// se existir um popup de alerta será ocultado 
// as informções do usario e form de mudança de senha
if (alerta !== null)
{
    infos.style.display = 'none';
    popup_wrapper.style.display = 'none';

    // se o usuario fechar o popup de alerta, este popup será excluido
    // e a pagina voltara a ficar como no inicio
    close_alerta.addEventListener('click', () =>{
        pai.removeChild(alerta);

        popup_wrapper.style.display = 'none';
        infos.style.display = 'flex';
    });
}