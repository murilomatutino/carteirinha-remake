const a = document.getElementById('link-mudar-senha');
const close = document.getElementById('popup-perfil-close');
const popup_wrapper = document.getElementById('popup-perfil-wrapper');
const infos = document.getElementById('infos');

a.addEventListener('click', () =>{
    popup_wrapper.style.display = 'block';
    infos.style.display = 'none';
});

close.addEventListener('click', () =>{
    popup_wrapper.style.display = 'none';
    infos.style.display = 'flex';
});