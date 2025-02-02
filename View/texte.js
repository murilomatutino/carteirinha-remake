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

function adicionarConteudo() {
    const notificationItems = document.querySelectorAll('.notification-item');
    const notificationContent = document.querySelector('#content');
    notificationItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.2}s`;
        notificationContent.appendChild(item);
        
        setTimeout(() => {
            item.classList.add('visible');
        }, index * 200);
    });
}

function exibirConteudo() {
    const popup2 = document.querySelector('#popup2');
    const notificationItems = document.querySelectorAll('#content .notification-item');
    const notificationDefault = document.querySelector('#default');

    notificationItems.forEach(item => {
        item.addEventListener('click', function() {
            if (item.classList.contains('visible')) {
                popup2.innerHTML = '';
                popup2.classList.remove('open');
                popup2.classList.add('expanded');
                console.log(item.id);

                // Exibir conteúdo expandido
                setTimeout(() => {
                    const notificationOpen = document.querySelector('#open');
                    popup2.innerHTML = notificationOpen.innerHTML;

                    // Adicionar evento de voltar
                    document.querySelector('#back').addEventListener('click', function() {
                        popup2.innerHTML = notificationDefault.innerHTML;
                        popup2.classList.remove('expanded');
                        popup2.classList.add('open');

                        // Restaurar a lista de notificações
                        document.querySelector('#content').innerHTML = '';
                        adicionarConteudo();
                        botaoFechar();
                    });
                }, 500);
            }
        });
    });
}

if (notificationNavbar) {
    notificationNavbar.addEventListener('click', function() {
        const overlay2 = document.querySelector('#overlay2');
        const popup2 = document.querySelector('#popup2');
        const notificationDefault = document.querySelector('#default');
        
        animations.showNavbarNotification(popup2, overlay2, document.body);
        popup2.innerHTML = '';
        popup2.innerHTML = notificationDefault.innerHTML;

        botaoFechar();
        adicionarConteudo();
        setTimeout(() => {
            exibirConteudo();
        }, 1000);
    });
}


        // // Restaura o conteúdo de popup2 quando a notificação for fechada
        // document.querySelector('.close-btn-2').addEventListener('click', function() {
        //     popup2.innerHTML = originalPopup2Content; // Restaura o conteúdo original da lista de notificações
        // });


// copia original do arquivo View/js/index.js função de notificação
// const closePopup = document.querySelector('.close');
// const closeReload = document.querySelector('#reload');
// const notificationNavbar = document.querySelector('#navbar-notification');

// if (notificationNavbar) {
//     notificationNavbar.addEventListener('click', function() {
//         const overlay2 = document.querySelector('#overlay2');
//         const popup2 = document.querySelector('#popup2');
//         const notificationDefault = document.querySelector('#default');
//         const notificationOpen = document.querySelector('#open');

//         // Guardar o conteúdo original de popup2 (a lista de notificações)
//         const originalPopup2Content = popup2.innerHTML;

//         animations.showNavbarNotification(popup2, overlay2, document.body);
//         popup2.innerHTML = notificationDefault.innerHTML;

//         const notificationContent = document.querySelector('#content');
//         const notificationItems = document.querySelectorAll('.notification-item');

//         let originalItems = []; 

//         notificationItems.forEach(item => {
//             originalItems.push(item); // Guardar as referências dos itens originais
//         });

//         // Adicionar os itens originais ao conteúdo
//         originalItems.forEach(item => {
//             notificationContent.appendChild(item);
//         });

//         // Adicionar animação aos itens
//         setTimeout(() => {
//             notificationItems.forEach((item, index) => {
//                 item.style.animationDelay = `${index * 0.2}s`;

//                 setTimeout(() => {
//                     item.classList.add('visible');
//                 }, index * 200);

//                 item.addEventListener('click', function() {
//                     if (item.classList.contains('visible')) {
//                         popup2.innerHTML = '';
//                         popup2.classList.remove('open');
//                         popup2.classList.add('expanded');
//                         console.log(item.id);

//                         // Exibir conteúdo expandido
//                         setTimeout(() => {
//                             popup2.innerHTML = notificationOpen.innerHTML;

//                             // Adicionar evento de voltar
//                             document.querySelector('#back').addEventListener('click', function() {
//                                 // Restaurar o conteúdo original e a lista de notificações
//                                 popup2.innerHTML = notificationDefault.innerHTML;
//                                 popup2.classList.remove('expanded');
//                                 popup2.classList.add('open');

//                                 // Restaurar a lista de notificações
//                                 notificationContent.innerHTML = ''; // Limpar o conteúdo atual
//                                 originalItems.forEach(item => {
//                                     notificationContent.appendChild(item); // Restaurar os itens originais
//                                     item.classList.remove('visible'); // Remover a classe "visible"
//                                 });
//                             });
//                         }, 500);
//                     }
//                 });
//             });
//         }, 300);

//         // Fechar diretamente a notificação
//         const closePopup2 = document.querySelector('.close-btn-2');
//         if (closePopup2) {
//             closePopup2.addEventListener('click', function() {
//                 animations.closeNavbarNotification(popup2, overlay2, document.body);
//                 popup2.classList.remove('expanded');
//             });
//         }

//         // Restaura o conteúdo de popup2 quando a notificação for fechada
//         document.querySelector('.close-btn-2').addEventListener('click', function() {
//             popup2.innerHTML = originalPopup2Content; // Restaura o conteúdo original da lista de notificações
//         });
//     });
// }