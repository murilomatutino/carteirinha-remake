const alerta = document.getElementById('popup-alerta');
const main = document.getElementsByTagName('main');
const box = document.getElementsByClassName('container-sphere');
const close_alerta = document.getElementById("popup-alerta-close");
const animation = document.getElementsByClassName('contact-animation');

//se existir um popup de alerta será ocultado 
// as informções do usario e form de mudança de senha
if (alerta !== null)
{
    box[0].style.display = 'none';
    animation[0].style.display = 'none';

    // se o usuario fechar o popup de alerta, este popup será excluido
    // e a pagina voltara a ficar como no inicio
    close_alerta.addEventListener('click', () =>{
        main[1].removeChild(alerta);

        box[0].style.display = 'flex';
        animation[0].style.display = 'block';
        
    });
}