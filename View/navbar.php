<?php
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    require_once "../Controller/config.php";
    require_once "../Controller/NotificationController.php";
?>

<?php
    function notificationIcon() {
        if (isset($_SESSION['logged_in'])) {
            $notController = new NotificationController();
            $result = $notController->hasNotification($_SESSION['id']);

            if ($result == 0) {
                return WPATH . "/View/assets/notification2.png";
            } else {
                return WPATH . "/View/assets/notification.png";
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
        $notification_icon = "<a href='#' class='notification-icon' title='Notificações'><img src='$notification_icon_path' alt='Notificações'></a>";

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
