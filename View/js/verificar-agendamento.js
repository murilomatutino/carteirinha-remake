const botao_fechamneto = document.getElementById('popup-alerta-close');

// redireciona se apertar no x
botao_fechamneto.addEventListener('click', function(e){
    window.location.href = "landpage.php";
});

const tempo = 120000; // em milisegundos

// redireciona após um determinado tempo
setTimeout( function(){
    window.location.href = "landpage.php";
} , tempo);