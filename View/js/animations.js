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