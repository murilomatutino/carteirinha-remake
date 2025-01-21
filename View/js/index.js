import * as events from './events.js';
import * as animations from './animations.js';
import * as functions from './functions.js';

// LOGIN
// Área onde é feita a verificação dos campos de login
const page = window.location.pathname.split('/').pop();
if (page === "login.php") {
    const loginSubmit = document.querySelector("#form");
    const userCheck = document.querySelector("#matricula");
    const passwordCheck = document.querySelector("#password");

    userCheck.addEventListener("input", function() {
        functions.check();
    });

    passwordCheck.addEventListener("input", function() {
        functions.check();
    });

    loginSubmit.addEventListener("submit", function(event) {
        event.preventDefault();

        functions.enviarFormulario()
        .then(data => {
            setTimeout(() => {
                window.location.href = "landpage.php";
            }, 2000);
        })
        .catch(error => {
            if (error === "error001") {
                events.showNotification("Usuário inexistente ou credenciais inválidas!", "error");
                functions.check();
            } else {
                console.error("Erro desconhecido:", error);
            }
        });
    });
}

// CARDAPIO RESERVA
if (page === 'cardapio-reserva.php') {
    document.querySelector('#justificativa').addEventListener('change', function() {
        const outroInput = document.querySelector('#outro');
        console.log("mudou")

        if (this.value === 'outro') {
            outroInput.disabled = false;
        } else {
            outroInput.value = '';
            outroInput.disabled = true;
        }
    });

    document.querySelector('.cancelar').addEventListener('click', function() {
        window.location.href = "cardapio.php";
    });
}

// CARDAPIO
if (page === 'cardapio.php') {
    const params = new URLSearchParams(window.location.search);
    const reserva = params.get('reserva');
    if (reserva === 'confirmada') {
        document.getElementById('popup').style.display = 'block';
        document.getElementById('overlay').style.display = 'block';
    }
}

// AGENDADOS 
if (page === 'agendados.php') {
    document.querySelector('#voltar').addEventListener('click', function() {
        window.location.href = "cardapio.php";
    });
}

// Funções de notificações no footer
const closePopup = document.querySelector('.close');
const closePopup2 = document.querySelector('.close-btn-2');
const closeReload = document.querySelector('#reload');

if (closePopup) {
    closePopup.addEventListener('click', function() {
        document.querySelector('#notificationPopup').style.display = 'none';
        document.querySelector('#notificationOverlay').style.display = 'none';
        document.querySelector('#overlay').style.display = 'none';
        document.querySelector('#popup').style.display = 'none';
        if (closeReload) { location.reload(); }
    });
}

if (closePopup2) {
    closePopup2.addEventListener('click', function() {
        document.querySelector('#overlay2').style.display = 'none';
        document.querySelector('#popup2').style.display = 'none';
    });
}