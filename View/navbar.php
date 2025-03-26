<?php
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    require_once "../Controller/config.php";
    require_once "../Controller/NotificationController.php";
?>

<?php
    function notificationIcon($path) {
        if (isset($_SESSION['logged_in'])) {
            $notController = new NotificationController();
            $result = $notController->hasNewNotification($_SESSION['id']);

            return $path . "/View/assets/" . ($result == 0 ? "notification2.png" : "notification.png");
        }
        return $path . "/View/assets/notification2.png";  // Caso o usuário não esteja logado
    }

    $notification_icon_path = notificationIcon(WPATH);
?>

<link rel="stylesheet" href="css/navbar.css">

<!-- NOTIFICAÇÃO DE ALERTAS -->
<div class="overlay"></div>
<div class="popup">
    <header><h1 class="title"></h1></header>
    <main><p class="desc"></p></main>
    <footer><button id="close">Entendido</button></footer>
</div>

<!-- NOTIFICAÇÃO DA NAVBAR -->
<div class="overlay2" id="overlay2"></div>
<div class="popup2" id="popup2"></div>

<!-- Templates de Notificação -->
<template class="notification" id="default-template">
    <header><h1 class="title"></h1></header>
    <main id="content"></main>
    <footer><button class="close-btn-2">Fechar</button></footer>
</template>

<template class="notification" id="open-template">
    <header><h2 class="title"></h2></header>
    <main id="content"><p></p></main>
    <footer><button id="back">Voltar</button></footer>
</template>

<template class="notification" id="feedback">
    <h2>Deixe seu feedback!</h2>
    <div class="estrelas" id="starRating">
        <div class="estrela" data-value="1">&#9733;</div>
        <div class="estrela" data-value="2">&#9733;</div>
        <div class="estrela" data-value="3">&#9733;</div>
        <div class="estrela" data-value="4">&#9733;</div>
        <div class="estrela" data-value="5">&#9733;</div>
    </div>
    <button id="feedback-btn">Enviar Feedback</button>
</template>

<!-- NOTIFICAÇÕES -->
<?php 
    $notController = new NotificationController();
    if (isset($_SESSION['logged_in'])) {
        if ($notController->hasNotification($_SESSION['id'])) {
            $response = $notController->getNotification($_SESSION['id']);
            usort($response, function($a, $b) {
                return ($a['lida'] == 0 && $b['lida'] == 1) ? -1 : (($a['lida'] == 1 && $b['lida'] == 0) ? 1 : 0);
            });

            foreach ($response as $value) {
                $type = $value['transferencia'] != 0 ? 'transfer' : 'default'; 
                $read = $value['lida'] === 1;
                $mensagem = (strlen($value['mensagem']) > 100) ? substr($value['mensagem'], 0, 40) . "..." : $value['mensagem'];
                $readImg = 'assets/envelope-open.svg';

                $readClass = $read ? 'lida' : '';
                echo "<div class='notification-item {$type} {$readClass}'>";
                echo "<img src='assets/alert.png' alt='icone de alerta'>";
                echo "<div class='notification-content' id='{$value['id']}'>";
                echo "<div class='assunto'><h2 class='title'>{$value['assunto']}</h2><span>Lida</span></div>";
                echo "<p id='notification-text'>{$mensagem}</p>";
                echo "</div>";
                if ($value['transferencia'] == 1) echo "<button class='validar' id='validar-transferencia'></button>";
                if (!$read) echo "<img class='mark-as-read' src='{$readImg}'>";
                echo "</div>";
            }
        }
    }
?>

<!-- Templates de Navbar -->
<template class='navbar' id='adm-right'>
    <div class='right'>
        <img alt='Notificações' id='navbar-notification' class='notification-icon' title='Notificações'>
        <button class='button-admin'>ADMIN</button>
        <div class='profile-dropdown'>
            <div class='profile-icon'>
                <img class='profile' alt='Perfil'>
                <span class='dropdown-arrow'></span>
            </div>
            <a class='profile-link'>Logado como <strong class='name'></strong></a>
            <div class='dropdown-menu'>
                <a class='logout'>Sair</a>
            </div>
        </div>
    </div>
</template>

<template class='navbar' id='user-right'>
    <div class='right'>
        <img alt='Notificações' id='navbar-notification' class='notification-icon' title='Notificações'>
        <div class='profile-dropdown'>
            <div class='profile-icon'>
                <img class='profile' alt='Perfil'>
                <span class='dropdown-arrow'></span>
            </div>
            <a class='profile-link'>Logado como <strong class='name'></strong></a>
            <div class='dropdown-menu'>
                <a class='logout'>Sair</a>
            </div>
        </div>
    </div>
</template>

<nav class='nav'>
    <div class="nav-container">
        <div class="hamburger" id="hamburger-menu">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <ul class="nav-list" id="nav-list">
            <li><a class='inicio-menu'>Início</a></li>
            <li><a class='cardapio-menu'>Cardápio</a></li>
            <li><a class='sobre-menu'>Sobre</a></li>
            <li>
                <a class="qr-code-menu">
                    <img class='qr-code-icon' alt="">
                </a>
            </li>
        </ul>
        <div class="right">
        </div>
    </div>
</nav>

<script>
    const config = <?= json_encode([
        'loggedIn' => isset($_SESSION['logged_in']) ? $_SESSION['logged_in'] : null,
        'category' => $_SESSION['category'] ?? null,
        'name' => $_SESSION['name'] ?? null,
        'notificationIconPath' => $notification_icon_path,
        'adminLandpage' => LANDPAGEADM,
        'userLandpage' => LANDPAGE,
        'menu' => MENU,
        'about' => ABOUT,
        'qrcodeImg' => QRCODEIMG,
        'qrcodeAdm' => QRCODE,
        'qrcodeEstudante' => QRCODREAD,
        'profilePic' => PROFILEPIC,
        'profile' => PROFILE,
        'logout' => LOGOUT,
        'login' => LOGIN
    ]) ?>;

    const loggedIn = config.loggedIn;
    const category = loggedIn !== null ? config.category : null;
    const name = loggedIn !== null ? config.name : null;

    // Set Navigation Links
    document.querySelector('.nav').style.display = loggedIn ? 'block' : 'none';
    document.querySelector('.inicio-menu').href = category === 'adm' ? config.adminLandpage : config.userLandpage;
    document.querySelector('.cardapio-menu').href = config.menu;
    document.querySelector('.sobre-menu').href = config.about;
    document.querySelector('.qr-code-menu').href = category === 'adm' ? config.qrcodeAdm : config.qrcodeEstudante;
    document.querySelector('.qr-code-icon').setAttribute('src', config.qrcodeImg);

    let templateClone = null;

    // Helper Functions
    function setElementAttributes(element, attributes) {
        if (element) {
            for (const [key, value] of Object.entries(attributes)) {
                element.setAttribute(key, value);
            }
        }
    }

    function setTextContent(element, text) {
        if (element) element.textContent = text;
    }

    // Create Navbar Template
    if (loggedIn) {
        const template = document.querySelector(category === 'adm' ? '#adm-right' : '#user-right');
        if (template) {
            templateClone = document.importNode(template.content, true);

            const notificationIcon = templateClone.querySelector('#navbar-notification');
            setElementAttributes(notificationIcon, { src: config.notificationIconPath });

            const profilePicElement = templateClone.querySelector('.profile');
            setElementAttributes(profilePicElement, { src: config.profilePic });

            const profileElement = templateClone.querySelector('.profile-link');
            setElementAttributes(profileElement, { href: config.profile });

            const nameElement = templateClone.querySelector('.name');
            setTextContent(nameElement, name);

            const logoutElement = templateClone.querySelector('.logout');
            setElementAttributes(logoutElement, { href: config.logout });

            if (category === 'adm') {
                const buttonAdmin = templateClone.querySelector('.button-admin');
                buttonAdmin.addEventListener('click', () => window.location.href = config.adminLandpage);
            }
        }
    } else {
        templateClone = document.createElement('div');
        templateClone.classList.add('right');
        const a = document.createElement('a');
        a.href = config.login;
        a.textContent = 'LOGIN';
        templateClone.appendChild(a);
    }

    const navRight = document.querySelector('.nav .right');
    if (navRight) navRight.appendChild(templateClone);
</script>
