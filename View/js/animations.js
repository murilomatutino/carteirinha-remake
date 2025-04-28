import * as ajax from './ajax.js';

export function showNavbarNotification(popup2, overlay2, body) {
    overlay2.style.display = 'block';
    popup2.style.display = 'block';
    popup2.classList.add('open');
    body.classList.add('active');
}

export function closeNavbarNotification(popup2, overlay2, body) {
    popup2.classList.remove('open');
    popup2.classList.add('closed');
    setTimeout(() => {
        overlay2.style.display = 'none';
        popup2.style.display = 'none';
        popup2.classList.remove('closed')
        body.classList.remove('active');
    }, 500);
}

export function addContent(notificationItems, notificationContent) {
    notificationItems.forEach((item, index) => {
        let clone = item.cloneNode(true)
        clone.style.animationDelay = `${index * 0.2}s`;
        notificationContent.appendChild(clone);
        
        setTimeout(() => {
            clone.classList.add('visible');
        }, index * 200);
    });
}

export function showContent(popup2) {
    popup2.classList.remove('open');
    popup2.classList.add('expanded');
}

export function backContent(popup2) {
    popup2.classList.remove('expanded');
    popup2.classList.add('open');
}

export function showNotification(titulo, descricao, feedback, confirm) {
    const overlay = document.querySelector('.overlay'); 
    const popup = document.querySelector('.popup');
    const title = document.querySelector('.title');
    const desc = document.querySelector('.desc');
    const closeBtn = popup.querySelector('#close');
    const feedbackTemplate = document.querySelector('#feedback');
    
    overlay.classList.add('active');
    popup.classList.add('active');
    closeBtn.classList.remove('close-btn-2');
    closeBtn.textContent = 'Entendido';

    title.textContent = titulo;
    desc.textContent = descricao;

    document.body.classList.add('active');

    // Lógica para o tipo de popup
    if (feedback) {
        // Popup de feedback
        const section = document.createElement('section');
        section.classList.add('feedback');
        section.innerHTML = feedbackTemplate.innerHTML;

        popup.querySelector('main').appendChild(section);

        const stars = section.querySelectorAll('.estrela');
        const sendBtn = document.querySelector('#feedback-btn');
        let selectedRating = 0;

        sendBtn.addEventListener('click', () => {
            if (selectedRating !== 0) {
                ajax.getUserId().then(idUser => {
                    if (!idUser) {
                        console.error('ID do usuário não encontrado');
                        return;
                    }

                    getCardapioId()
                    .then(idCardapio => {
                        console.log('ID do cardápio:', idCardapio);
                        let dados = {
                            operacao: 'enviarFeedback',
                            nota: selectedRating,
                            idUser: idUser,
                            idCardapio: idCardapio,
                        };
                        
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

                    // ajax.getCardapioId().then(idCardapio => {
                    //     if (!idCardapio) {
                    //         console.error('ID do usuário não encontrado');
                    //         return;
                    //     }
                
                        
                    // });
                });

                return { status: true, nota: selectedRating };
            }

        });

        closeBtn.classList.add('close-btn-2');
        closeBtn.textContent = 'Fechar';

        // Lógica de avaliação com estrelas
        if (stars.length > 0) {
            stars.forEach((star, index) => {
                star.addEventListener('mouseover', () => {
                    updateStars(index + 1);
                });

                star.addEventListener('click', () => {
                    selectedRating = index + 1;
                    updateStars(selectedRating);
                });

                star.addEventListener('mouseout', () => {
                    updateStars(selectedRating);
                });
            });

            function updateStars(rating) {
                stars.forEach((star, index) => {
                    star.classList.toggle('filled', index < rating);
                });
            }
        }

    } else if (confirm) {
        if (document.querySelector('.confirm-btn')) {
            document.querySelector('.confirm-btn').remove();
        }

        closeBtn.textContent = '';
        const confirmBtn = document.createElement('button');
        confirmBtn.classList.add('validar');
        closeBtn.classList.add('cancelar');
        confirmBtn.classList.add('confirm-btn');
        popup.querySelector('footer').appendChild(confirmBtn);

        confirmBtn.addEventListener('click', () => {
            overlay.classList.remove('active');
            popup.classList.remove('active');
            popup.classList.add('close');
            setTimeout(() => {
                ajax.excluirCardapio();
                popup.classList.remove('close');
                document.body.classList.remove('active');
            }, 500);
        });

        return { status: true };
    }

    // Evento de fechamento do popup
    closeBtn.addEventListener('click', function() {
        overlay.classList.remove('active');
        popup.classList.remove('active');
        popup.classList.add('close');
        setTimeout(() => {
            popup.classList.remove('close');
            document.body.classList.remove('active');
        }, 500);
    });

    return { status: false };
}


// const openPopup = document.querySelector('#open-popup');
// const popup2 = document.querySelector('#popup2');

// if (popup2 && openPopup) {
//     openPopup.addEventListener('click', function() {
//         popup2.style.display = 'block';
//         popup2.classList.add('active');

//         document.querySelector('#close').addEventListener('click', function() {
//             popup2.classList.remove('active');
//             popup2.classList.add('showOff');
//             setTimeout(() => {
//                 popup2.style.display = 'none';
//                 popup2.classList.remove('showOff')
//             }, 500);
//         });
//     });
// }