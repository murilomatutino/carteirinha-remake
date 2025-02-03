<?php
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    require_once "../Controller/config.php";
    require_once "../Controller/NotificationController.php";
?>

<?php
    function notificationIcon($path) {
        if (isset($_SESSION['logged_in'])) {
            $notController = new NotificationController();
            $result = $notController->hasNotification($_SESSION['id']);

            if ($result == 0) {
                return (string) $path . "/View/assets/notification2.png";
            } else {
                return (string) $path . "/View/assets/notification.png";
            }
        }
    }

    function showNav($call) {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $cardapio = WPATH . "/View/cardapio.php";
        $home = WPATH . "/View/landpage.php";
        $logout = WPATH . "/View/logout.php";
        $login = WPATH . "/View/login.php";
        $sobre = WPATH . "/View/sobre.php";
        $admin = WPATH . "/View/painel-administrador.php";
        $perfil = WPATH . "/View/perfil.php";
        $qrcode = WPATH . "/View/assets/qr-code.png";
        $qrcodeLink = WPATH . "/View/qr-code.php"; 
        $qrcodeEstudanteLink = WPATH . "/View/qr-code-estudante.php";
        $profilePic = WPATH . "/View/assets/Victor Hugo.jpg";
        $notification_icon_path = notificationIcon(WPATH);
        $notification_icon = "<img src='$notification_icon_path' alt='Notificações' id='navbar-notification' class='notification-icon' title='Notificações'>";

        if (isset($_SESSION['logged_in'])) {
            if ($_SESSION['logged_in'] && $_SESSION['category'] == "adm") {
                $nome = $_SESSION['name'];
                $text = "<div class='right'>
                            $notification_icon
                            <a class='button-admin' href='$admin'>ADMIN</a>
                            <div class='profile-dropdown'>
                                <div class='profile-icon'>
                                    <img src='$profilePic' alt='Perfil'>
                                    <span class='dropdown-arrow'></span>
                                </div>
                                <a href='$perfil'>Logado como <strong>$nome!</strong></a>
                                <div class='dropdown-menu'>
                                    <a href='$logout'>Sair</a>
                                </div>
                            </div>
                        </div>";
            } else if ($_SESSION['logged_in']) {
                $nome = $_SESSION['name'];
                $text = "<div class='right'>
                            $notification_icon
                            <div class='profile-dropdown'>
                                <div class='profile-icon'>
                                    <img src='$profilePic' alt='Perfil'>
                                    <span class='dropdown-arrow'></span>
                                </div>
                                <a href='$perfil'>Logado como <strong>$nome!</strong></a>
                                <div class='dropdown-menu'>
                                    <a href='$logout'>Sair</a>
                                </div>
                            </div>
                        </div>";
            } else {
                $text = "<div class='right'><a href='$login'>LOGIN</a></div>";
            }
        }

        if ($call == "login") {
            echo "<nav><div></div></nav>";
        } else {
            echo '
            <nav>
                <div class="nav-container">
                    <div class="hamburger" id="hamburger-menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <ul class="nav-list" id="nav-list">
                        <li><a href="' . $home . '">Início</a></li>
                        <li><a href="' . $cardapio . '">Cardápio</a></li>
                        <li><a href="' . $sobre . '">Sobre</a></li>
                        <li><a href="' . ($_SESSION['category'] == "adm" ? $qrcodeLink : $qrcodeEstudanteLink) . '">
                            <img src="' . $qrcode . '" alt="qr-code">
                        </a></li>
                    </ul>
                    <div class="right">
                        ' . ($text ?? '') . '
                    </div>
                </div>
            </nav>';
        }
    }
?>

<link rel="stylesheet" href="css/navbar.css">
<!-- NOTIFICAÇÃO DA NAVBAR -->
<div class="overlay2" id="overlay2"></div>
<div class="popup2" id="popup2">
</div>

<template class="notification" id="default">
    <header>
        <h1>Notificações</h1>
    </header>

    <main id="content"></main>

    <footer>
        <button class="close-btn-2">Fechar</button>
    </footer>
</template>

<template class="notification" id="open">
    <header>
        <h2 class="title">Transferencia de reserva</h2>
    </header>

    <main id="content">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Incidunt dolorum molestiae iste nulla non cum praesentium pariatur ex itaque, voluptate facilis repudiandae temporibus! Quisquam deserunt nam dolor ipsum ipsa accusamus!</p>
    </main>

    <footer>
        <button id="back">Voltar</button>
    </footer>
</template>

<div class="notification-item" id="transfer">
    <img src="assets/alert.png" alt="icone de alerta">
    <div class="notification-content">
        <h2 class="title">Transferencia de reserva</h2>
        <p id="notification-text">Requisição de transferencia de reserva</p>
    </div>
    <button class="validar" id="validar-transferencia"></button>
</div>

<div class="notification-item" id="update">
    <img src="assets/alert.png" alt="icone de alerta">
    <div class="notification-content">
        <h2 class="title">Atualização</h2>
        <p id="notification-text">Detalhes da Atualização</p>
    </div>
</div>