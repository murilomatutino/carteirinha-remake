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

export function showNotification(titulo, descricao, confirm) {
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

    if (confirm) {
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
                if (ajax.excluirCardapio()) {
                    window.location.href = 'cardapio.php?delete=success';
                    popup.classList.remove('close');
                    document.body.classList.remove('active');
                } else {
                    window.location.href = 'cardapio.php?delete=error';
                }
            }, 500);
        });
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
}
