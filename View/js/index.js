import * as events from './events.js';
import * as animations from './animations.js';
import * as functions from './functions.js';
import * as ajax from './ajax.js';

// LOGIN
const page = window.location.pathname.split('/').pop();
if (page === 'login.php') {
    const loginSubmit = document.querySelector('#form');
    const userCheck = document.querySelector('#matricula');
    const passwordCheck = document.querySelector('#password');

    userCheck.addEventListener('input', function() {
        functions.check();
    });

    passwordCheck.addEventListener('input', function() {
        functions.check();
    });

    loginSubmit.addEventListener('submit', function(event) {
        event.preventDefault();

        const formElement = document.querySelector('#form');
        const formData = new FormData(formElement);
        const data = Object.fromEntries(formData.entries());

        ajax.enviarFormulario(data)
        .then(response => {
            if (response) {
                const resultDiv = document.querySelector('.result');
                resultDiv.style.display = 'flex';
                resultDiv.style.opacity = '1';
                
                setTimeout(() => {
                    window.location.href = 'http://localhost/carteirinha-remake/index.php';
                }, 2000);
            } else {
                throw 'error001';
            }
        })
        .catch(error => {
            if (error === 'error001') {
                events.showNotification('Usuário inexistente ou credenciais inválidas!', 'error');
                functions.check();
            } else {
                console.error('Erro desconhecido:', error);
            }
        });
    });
}


// CARDAPIO
if (page === 'cardapio.php') {
    const btnExcluir = document.querySelector('.button-excluir');
    const btnEditar = document.querySelector('.button-editar');
    const btnImprimir = document.querySelector('.button-imprimir');

    if (btnEditar) btnEditar.addEventListener('click', () => window.location.href = 'cardapio-alterar.php');
    
}
{/* <button class='button-excluir' onclick='excluirCardapio()'>Excluir</button>
<a href='cardapio-alterar.php'><button class='button-editar'>Editar</button></a>
<button class='button-imprimir' onclick='imprimirCardapio();'>Imprimir Cardápio</button> */}

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
        window.location.href = 'cardapio.php';
    });
}

// AGENDADOS 
if (page === 'agendados.php') {
    document.querySelector('#voltar').addEventListener('click', function() {
        window.location.href = 'cardapio.php';
    });

    const buttons = document.querySelectorAll('#action');
    for (let item of buttons) {
        item.addEventListener('click', doAction);
    }

    function doAction() {
        const popup = document.querySelector('#popup');
        const overlay = document.querySelector('#overlay');
        const type = this.classList.contains('vermelho') ? 1 : 2;
        popup.innerHTML = ''; 

        const h2 = document.createElement('h2');
        const inputMotivo = document.createElement('input');
        const divButtons = document.createElement('div');
        const btnConfirm = document.createElement('button');
        const btnCancel = document.createElement('button');
        const labelMotivo = document.createElement('label');

        Object.assign(inputMotivo, { id: 'outro', name: 'outro', placeholder: 'Digite o motivo...' });

        divButtons.classList.add('botao-container');

        Object.assign(btnConfirm, { type: 'submit', id: 'confirmar', classList: 'validar' });

        btnCancel.classList.add('cancelar');

        divButtons.appendChild(btnCancel);
        divButtons.appendChild(btnConfirm);

        document.body.classList.add('active');

        function closeAgendadosPopup() {
            const popup = document.querySelector('#popup');
            const overlay = document.querySelector('#overlay');
            popup.style.display = 'none';
            overlay.style.display = 'none';
            document.querySelector('.container').classList.remove('blur');
            document.body.classList.remove('active');
        }

        btnCancel.addEventListener('click', closeAgendadosPopup);
        if (type === 1) {
            btnConfirm.addEventListener('click', function() {      
                ajax.getUserId().then(idUser => {
                    if (!idUser) {
                        console.error('ID do usuário não encontrado');
                        return;
                    }
        
                    const data = {
                        operacao: 'cancelarReserva',
                        motivo: document.querySelector('#outro').value,
                        idUser: idUser
                    };
        
                    ajax.cancelarReserva(data)
                        .then(result => {
                            window.location.href = 'cardapio.php?cancelamento=success';
                        })
                        .catch(error => {
                            window.location.href = 'cardapio.php?cancelamento=error'
                        });
                }).catch(error => {
                    console.error('Erro ao pegar ID do usuário:', error);
                });
            });
        }

        labelMotivo.textContent = 'MOTIVO:';
        h2.textContent = type === 1 ? 'CANCELAR RESERVA' : 'DISPONIBILIZAR RESERVA';

        popup.appendChild(h2);
        popup.appendChild(labelMotivo);
        popup.appendChild(inputMotivo);

        if (type !== 1) {
            const labelMatricula = document.createElement('label');
            const inputMatricula = document.createElement('input');

            Object.assign(inputMatricula, { id: 'matricula', name: 'matricula', placeholder: 'Matrícula alvo' });

            labelMatricula.textContent = 'MATRÍCULA';

            popup.appendChild(labelMatricula);
            popup.appendChild(inputMatricula);

            btnConfirm.addEventListener('click', () => {
                ajax.getUserId().then(idUser => {
                    if (!idUser) {
                        console.error('ID do usuário não encontrado');
                        return;
                    }

                    let dados = {
                        operacao: 'transferirReserva',
                        motivo: document.querySelector('#outro').value,
                        matriculaAlvo: document.querySelector('#matricula').value,
                        idUser: idUser
                    };
                    
                    ajax.transferirReserva(dados).then(result => {
                        window.location.href = 'cardapio.php?solicitacao=success';
                    }).catch(error => {
                        window.location.href = 'cardapio.php?solicitacao=error';
                    });
                });
            });
        }

        popup.appendChild(divButtons);
        popup.style.display = 'block';
        overlay.style.display = 'block';

        document.querySelector('.container').classList.add('blur');
    }
}


// Funções de notificações na navbar
const closePopup = document.querySelector('.close');
const closeReload = document.querySelector('#reload');
const notificationNavbar = document.querySelector('#navbar-notification');

function botaoFechar() {
    const overlay2 = document.querySelector('#overlay2');
    const popup2 = document.querySelector('#popup2');
    const closePopup2 = document.querySelector('.close-btn-2');
    if (closePopup2) {
        closePopup2.addEventListener('click', function() {
            animations.closeNavbarNotification(popup2, overlay2, document.body);
            popup2.classList.remove('expanded');
        });
    }
}

function botaoConfirmar(button) {
    button.addEventListener('click', function() {
        ajax.getUserId().then(idUser => {
            if (!idUser) {
                console.error('ID do usuário não encontrado');
                return;
            }

            const data = {
                operacao: 'aceitarRefeicao',
                idDestinatario: idUser
            };

            ajax.acceptTransferencia(data)
                .then(result => {
                    window.location.href = 'cardapio.php?transferencia=success';
                })
                .catch(error => {
                    window.location.href = 'cardapio.php?transferencia=error';
                });
        }).catch(error => {
            console.error('Erro ao pegar ID do usuário:', error);
        });
    });
}

function adicionarConteudo() {
    const notificationItems = document.querySelectorAll('.notification-item');
    const notificationContent = document.querySelector('#content');
    animations.addContent(notificationItems, notificationContent);
    const confirmBtn = document.querySelector('#validar-transferencia');

    if (confirmBtn) botaoConfirmar(confirmBtn); 
}

function exibirConteudo() {
    const popup2 = document.querySelector('#popup2');
    const notificationItems = document.querySelectorAll('#content .notification-item');
    const notificationContent = document.querySelectorAll('#content .notification-content');
    const notificationDefault = document.querySelector('#default-template');

    notificationContent.forEach((item, index) => {
        item.addEventListener('click', function() {
            if (notificationItems[index].classList.contains('visible')) {
                popup2.innerHTML = '';
                animations.showContent(popup2);

                setTimeout(() => {
                    const notificationOpen = document.querySelector('#open-template');
                    const confirmBtn = document.createElement('button');

                    Object.assign(confirmBtn, { id: 'validar-transferencia-in', classList: 'validar' });
                    popup2.innerHTML = notificationOpen.innerHTML;

                    ajax.getUserId().then(idUser => {
                        if (!idUser) {
                            console.error('ID do usuário não encontrado');
                            return;
                        }

                        const dados = {
                            operacao: 'getNotification',
                            idUser: idUser,
                            idNotificacao: this.id,
                        }

                        ajax.getNotification(dados).then(notifications => {
                            if (notifications.transferencia === 1) {
                                popup2.querySelector('footer').appendChild(confirmBtn);
                                if (confirmBtn) botaoConfirmar(confirmBtn); 
                            }
                    
                            popup2.querySelector('.title').textContent = notifications.assunto;
                            popup2.querySelector('#content').textContent = notifications.mensagem;

                            const dadosNoti = {
                                operacao: 'readNotification',
                                idDestinatario: idUser,
                                idNotificacao: this.id,
                            }

                            ajax.readNotification(dadosNoti).then(response => {

                            }).catch(error => {
                                console.log('Erro ao ler a notificação', error);
                            });
                        }).catch(error => {
                            console.error('Erro ao pegar notificação:', error);
                        });
                    }).catch(error => {
                        console.error('Erro ao pegar ID do usuário:', error);
                    });

                    // Adicionar evento de voltar
                    document.querySelector('#back').addEventListener('click', function() {
                        popup2.innerHTML = notificationDefault.innerHTML;
                        animations.backContent(popup2);
                        adicionarConteudo();
                        exibirConteudo();
                        botaoFechar();
                    });
                }, 400);
            }
        });
    });
}

if (notificationNavbar) {
    notificationNavbar.addEventListener('click', function() {
        const overlay2 = document.querySelector('#overlay2');
        const popup2 = document.querySelector('#popup2');
        const notificationDefault = document.querySelector('#default-template');
        
        animations.showNavbarNotification(popup2, overlay2, document.body);
        popup2.innerHTML = '';
        popup2.innerHTML = notificationDefault.innerHTML;

        botaoFechar();
        adicionarConteudo();
        exibirConteudo();
    });
}

if (closePopup) {
    closePopup.addEventListener('click', function() {
        document.querySelector('#notificationPopup').style.display = 'none';
        document.querySelector('#notificationOverlay').style.display = 'none';
        document.querySelector('#overlay').style.display = 'none';
        document.querySelector('#popup').style.display = 'none';
        if (closeReload) { location.reload(); }
    });
}

if (page === 'sobre.php') {
    const button = document.querySelector('#open-form'); 
    const contactForm = document.querySelector('.contact-form');
    const contactAnimation = document.querySelector('.contact-animation');

    button.addEventListener('click', function() {
        contactAnimation.classList.toggle('expanded');
        contactForm.classList.toggle('show');            

        if (contactAnimation.classList.contains('expanded')) {
            setTimeout(() => {
                window.scrollTo({
                    top: contactAnimation.getBoundingClientRect().top + window.scrollY,
                    behavior: 'smooth'
                });
            }, 400);

            setTimeout(() => {
                contactForm.innerHTML = document.querySelector('#form-template').innerHTML;
                button.querySelector('img').classList.toggle('rotated');
            }, 800);
        } else {
            contactForm.innerHTML = '';
        }
    });
}

function sendFeedback(nota) {
    ajax.getUserId().then(idUser => {
        if (!idUser) {
            console.error('ID do usuário não encontrado');
            return;
        }

        let dados = {
            operacao: 'enviarFeedback',
            nota: nota,
            idUser: idUser
        };
        
        ajax.enviarFeedback(dados).then(result => {
            window.location.href = 'cardapio.php?feedback=success';
        }).catch(error => {
            window.location.href = 'cardapio.php?feedback=error';
        });
    });
}

// Notificações
export function showNotification(titulo, descricao, feedback = false) { 
    if (feedback) {
        const section = document.createElement('section');

        section.classList.add('feedback');
        section.innerHTML = document.querySelector('#feedback').innerHTML;

        const popup = document.querySelector('.popup');
        const closeBtn = popup.querySelector('#close');
        const stars = section.querySelectorAll('.estrela');
        const sendBtn = document.querySelector('#feedback-btn');
        let selectedRating = 0;

        closeBtn.classList.add('close-btn-2');
        closeBtn.textContent = 'Fechar';

        popup.querySelector('main').appendChild(section);

        if (stars.length > 0) {
            stars.forEach((star, index) => {
                star.addEventListener('mouseover', () => {
                  updateStars(index + 1);
                });
          
                star.addEventListener('click', () => {
                    selectedRating = index + 1;
                    updateStars(selectedRating);
                
                    sendFeedback(selectedRating);

                    // sendBtn.addEventListener('click', () => {
                    //     console.log(selectedRating);
                    // });
                });
          
                star.addEventListener('mouseout', () => {
                  updateStars(selectedRating);
                });
              });

            //   sendBtn.addEventListener('click', () => {
            //     sendFeedback(selectedRating);
            //   })

            // console.log(selectedRating);
          
            function updateStars(rating) {
                stars.forEach((star, index) => {
                    star.classList.toggle('filled', index < rating);
                });
            }
        }
    }

    // console.log(selectedRating);

    animations.showNotification(titulo, descricao, feedback); 
}