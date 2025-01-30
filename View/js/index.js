import * as events from './events.js';
import * as animations from './animations.js';
import * as functions from './functions.js';
import * as ajax from './ajax.js';

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

    const buttons = document.querySelectorAll('#action');
    for (let item of buttons) {
        item.addEventListener('click', doAction);
    }

    function doAction() {
        const popup = document.querySelector("#popup");
        const overlay = document.querySelector("#overlay");
        const type = this.classList.contains('vermelho') ? 1 : 2;
        popup.innerHTML = ""; 

        const h2 = document.createElement("h2");
        const inputMotivo = document.createElement("input");
        const divButtons = document.createElement("div");
        const btnConfirm = document.createElement("button");
        const btnCancel = document.createElement("button");
        const labelMotivo = document.createElement("label");

        inputMotivo.setAttribute("id", "outro");
        inputMotivo.setAttribute("name", "outro");
        inputMotivo.setAttribute("placeholder", "Digite o motivo...");

        divButtons.classList.add("botao-container");
        btnConfirm.setAttribute("type", "submit");
        btnConfirm.setAttribute("id", "confirmar");
        btnConfirm.classList.add("validar");
        btnCancel.classList.add("cancelar");

        divButtons.appendChild(btnCancel);
        divButtons.appendChild(btnConfirm);

        function closeAgendadosPopup() {
            const popup = document.querySelector("#popup");
            const overlay = document.querySelector("#overlay");
            popup.style.display = "none";
            overlay.style.display = "none";
            document.querySelector('.container').classList.remove("blur");
        }

        btnCancel.addEventListener("click", closeAgendadosPopup);
        if (type === 1) {
            btnConfirm.addEventListener("click", function() {      
                ajax.getUserId().then(idUser => {
                    if (!idUser) {
                        console.error('ID do usuário não encontrado');
                        return;
                    }
        
                    const data = {
                        operacao: "cancelarReserva",
                        motivo: document.querySelector("#outro").value,
                        idUser: idUser
                    };
        
                    ajax.cancelarReserva(data)
                        .then(result => {
                            window.location.href = "cardapio.php?reserva=cancelada";
                        })
                        .catch(error => {
                            window.location.href = "cardapio.php?reserva=erro"
                        });
                }).catch(error => {
                    console.error('Erro ao pegar ID do usuário:', error);
                });
            });
        }

        labelMotivo.textContent = "MOTIVO:";
        h2.textContent = type === 1 ? "CANCELAR RESERVA" : "DISPONIBILIZAR RESERVA";

        popup.appendChild(h2);
        popup.appendChild(labelMotivo);
        popup.appendChild(inputMotivo);

        if (type !== 1) {
            const labelMatricula = document.createElement("label");
            const inputMatricula = document.createElement("input");

            inputMatricula.setAttribute("id", "matricula");
            inputMatricula.setAttribute("name", "matricula");
            inputMatricula.setAttribute("placeholder", "Matrícula alvo");

            labelMatricula.textContent = "MATRÍCULA";

            popup.appendChild(labelMatricula);
            popup.appendChild(inputMatricula);

            btnConfirm.addEventListener('click', () => {
                ajax.getUserId().then(idUser => {
                    if (!idUser) {
                        console.error('ID do usuário não encontrado');
                        return;
                    }

                    let dados = {
                        operacao: "transferirReserva",
                        motivo: document.querySelector('#outro').value,
                        matriculaAlvo: document.querySelector('#matricula').value,
                        idUser: idUser
                    };
                    
                    // FAZER AJAX AQUI 
                    ajax.transferirReserva(dados)
                        .then(result => {
                            window.location.href = "cardapio.php?reserva=transferida";
                        })
                        .catch(error => {
                            window.location.href = "cardapio.php?reserva=erro";
                        });
                    });
            });

            // function showNotification(message, type) {
            //     const notification = document.createElement("div");
            //     notification.classList.add("notification", type);
            //     notification.innerText = message;

            //     document.body.appendChild(notification);

            //     setTimeout(() => {
            //         notification.remove();
            //     }, 5000);
            // }
        }

        popup.appendChild(divButtons);
        popup.style.display = "block";
        overlay.style.display = "block";

        document.querySelector('.container').classList.add("blur");
    }
}

// function agendadosPopup(type) {
//     const popup = document.querySelector("#popup");
//     const overlay = document.querySelector("#overlay");
//     popup.innerHTML = ""; 

//     const h2 = document.createElement("h2");
//     const inputMotivo = document.createElement("input");
//     const divButtons = document.createElement("div");
//     const btnConfirm = document.createElement("button");
//     const btnCancel = document.createElement("button");
//     const labelMotivo = document.createElement("label");

//     inputMotivo.setAttribute("id", "outro");
//     inputMotivo.setAttribute("name", "outro");
//     inputMotivo.setAttribute("placeholder", "Digite o motivo...");

//     divButtons.classList.add("botao-container");
//     btnConfirm.setAttribute("type", "submit");
//     btnConfirm.setAttribute("id", "confirmar");
//     btnConfirm.classList.add("validar");
//     btnCancel.classList.add("cancelar");

//     divButtons.appendChild(btnCancel);
//     divButtons.appendChild(btnConfirm);

//     btnCancel.addEventListener("click", closeAgendadosPopup);
//     if (type === 1) { btnConfirm.addEventListener("click", funcaoReserva); }

//     labelMotivo.textContent = "MOTIVO:";
//     h2.textContent = type === 1 ? "CANCELAR RESERVA" : "DISPONIBILIZAR RESERVA";

//     popup.appendChild(h2);
//     popup.appendChild(labelMotivo);
//     popup.appendChild(inputMotivo);

//     if (type !== 1) {
//         const labelMatricula = document.createElement("label");
//         const inputMatricula = document.createElement("input");

//         inputMatricula.setAttribute("id", "matricula");
//         inputMatricula.setAttribute("name", "matricula");
//         inputMatricula.setAttribute("placeholder", "Matrícula alvo");

//         labelMatricula.textContent = "MATRÍCULA";

//         popup.appendChild(labelMatricula);
//         popup.appendChild(inputMatricula);

//         btnConfirm.addEventListener('click', () => {
//             const motivo = document.querySelector('#outro').value;
//             const matricula = document.querySelector('#matricula').value;

//             let dados = {
//                 motivo: motivo,
//                 matricula: matricula
//             };

//             fetch('process/transferir-reserva.php', {
//                 method: 'POST',
//                 headers: {
//                     'Content-Type': 'application/x-www-form-urlencoded'
//                 },
//                 body: new URLSearchParams(dados).toString()
//             })
//             .then(response => response.json())
//             .then(result => {
//                 if (result.status === "sucesso") {
//                     showNotification(
//                         `Reserva transferida com sucesso para o usuário de matrícula ${result.matriculaDestino}!`,
//                         "success"
//                     );
//                 } else {
//                     showNotification(
//                         `Erro ao transferir a reserva: ${result.mensagem || "Tente novamente mais tarde."}`,
//                         "error"
//                     );
//                 }
//                 closeAgendadosPopup();
//             })
//             .catch(error => {
//                 console.error('Erro:', error);
//                 showNotification(
//                     "Ocorreu um erro inesperado ao transferir a reserva. Tente novamente mais tarde.",
//                     "error"
//                 );
//             });
//         });

//         function showNotification(message, type) {
//             const notification = document.createElement("div");
//             notification.classList.add("notification", type);
//             notification.innerText = message;

//             document.body.appendChild(notification);

//             setTimeout(() => {
//                 notification.remove();
//             }, 5000);
//         }
//     }

//     popup.appendChild(divButtons);
//     popup.style.display = "block";
//     overlay.style.display = "block";

//     document.querySelector('.container').classList.add("blur");
// }

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