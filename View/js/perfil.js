const a = document.getElementById('link-mudar-senha');
const close = document.getElementById('popup-perfil-close');
const popup_wrapper = document.getElementById('popup-perfil-wrapper');
const infos = document.getElementById('infos');
const alerta = document.getElementById('popup-alerta');
const close_alerta = document.getElementById("popup-alerta-close");
const pai = document.getElementById('pai');

a.addEventListener('click', () =>{
    popup_wrapper.style.display = 'block';
    infos.style.display = 'none';
});

close.addEventListener('click', () =>{
    popup_wrapper.style.display = 'none';
    infos.style.display = 'flex';
});

if (alerta !== null)
{
    infos.style.display = 'none';
    popup_wrapper.style.display = 'none';

    close_alerta.addEventListener('click', () =>{
        pai.removeChild(alerta);

        popup_wrapper.style.display = 'none';
        infos.style.display = 'flex';
    });
}