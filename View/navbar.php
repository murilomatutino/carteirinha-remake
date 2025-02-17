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

<!-- NOTIFICAÇÃO DE ALERTAS -->
<div class="overlay"></div>
  <div class="popup">
    <header><h1 class="title"></h1></header>
    <main><p class="desc"></p></main>
    <footer><button id="close">Entendido</button></footer>
  </div>
</div>

<!-- NOTIFICAÇÃO DA NAVBAR -->
<div class="overlay2" id="overlay2"></div>
<div class="popup2" id="popup2"></div>

<template class="notification" id="default-template">
    <header>
        <h1 class="title"></h1>
    </header>

    <main id="content"></main>

    <footer>
        <button class="close-btn-2">Fechar</button>
    </footer>
</template>

<template class="notification" id="open-template">
    <header>
        <h2 class="title"></h2>
    </header>

    <main id="content"><p></p></main>

    <footer>
        <button id="back">Voltar</button>
    </footer>
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

<?php 
    $notController = new NotificationController();

    if (isset($_SESSION['logged_in'])) {
        if ($notController->hasNotification($_SESSION['id'])) {
            $response = $notController->getNotification($_SESSION['id']);
            usort($response, function($a, $b) {
                return ($a['lida'] == 0 && $b['lida'] == 1) ? -1 : (($a['lida'] == 1 && $b['lida'] == 0) ? 1 : 0);
            });

            foreach ($response as $key => $value) {
                $type = $value['transferencia'] != 0 ? 'transfer' : 'default'; 
                $read = $value['lida'] == 1 ? true : false;
                $mensagem = (strlen($value['mensagem']) > 100) ? substr($value['mensagem'], 0, 40) . "..." : $value['mensagem'];
                $readimg = 'assets/envelope-open.svg';

                if ($read) { echo "<div class='notification-item {$type} lida'>"; }
                else { echo "<div class='notification-item {$type}'>"; }
                
                echo "<img src='assets/alert.png' alt='icone de alerta'>";
                echo "<div class='notification-content' id='{$value['id']}'>";
                echo "<div class='assunto'><h2 class='title'>{$value['assunto']}</h2><span>Lida</span></div>";
                echo "<p id='notification-text'>{$mensagem}</p>";
                echo "</div>";
                if ($value['transferencia'] == 1) echo "<button class='validar' id='validar-transferencia'></button>";
                if ($read) echo " <img class='mark-as-read' src='{$readimg}'>";

                echo "</div>";
            }
        } else {
            echo "<h1>Sem notificações</h1>"; 
        } 
    }
?>

<!-- <div class="notification-item transfer">
    <img src="assets/alert.png" alt="icone de alerta">
    <div class="notification-content">
        <h2 class="title">Transferencia de reserva</h2>
        <p id="notification-text">Requisição de transferencia de reserva</p>
    </div>
    <button class="validar" id="validar-transferencia"></button>
</div>

<div class="notification-item default">
    <img src="assets/alert.png" alt="icone de alerta">
    <div class="notification-content">
        <h2 class="title">Atualização</h2>
        <p id="notification-text">Detalhes da Atualização</p>
    </div>
</div> -->