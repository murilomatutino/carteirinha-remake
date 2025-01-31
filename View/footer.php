<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script type="module" src="js/index.js"></script>
</head>
<body>
    <!-- DIVS para notificaçãoes -->
    <div class="overlay" id="notificationOverlay"></div>
    <div class="popup" id="notificationPopup"></div>


    <!-- <div class="overlay2" id="overlay2"></div>
    <div class="popup2" id="popup2">
        <h2>Detalhes da Notificação</h2>
        <p id="popupContent">Aqui vai o conteúdo do popup.</p>
        <button class="close-btn-2">Fechar</button>
    </div> -->

    <template id="show">
        <h2>Notificações</h2>
        <div id="notificationList">
            <?php
                if (isset($_SESSION['logged_in'])) {
                    require_once '../Controller/NotificationController.php';
                    $notController = new NotificationController;
                    $userId = $_SESSION['id'];
                    $hasNotification = $notController->hasNotification($userId);

                    if ($hasNotification) {
                        $assuntos = $notController->getAssunto($userId);
                        foreach ($assuntos as $assunto) {
                            // Exibe a notificação com o botão de detalhes
                            echo "<div class='notification-item'>" . htmlspecialchars($assunto, ENT_QUOTES, 'UTF-8') . 
                                " <button class='button' data-assunto='" . htmlspecialchars($assunto, ENT_QUOTES, 'UTF-8') . 
                                "' onclick='openPopup2()'>Exibir detalhes</button></div>";
                        }
                    } else {
                        echo "<h3 class='notification-item null'>Sem notificações.</h3>";
                    }
                }
            ?>
        </div>
        <div class="buttons">
            <?php 
                if ($_SESSION['category'] === 'adm') {
                    echo "<button class='send'>Enviar notificação</button>";
                }
            ?>
            <button class="close">Fechar</button>
        </div>
    </template>

    <template id="send">
        <h3>Enviar Notificação</h3>
        <input type="text" id="assunto" name="assunto" placeholder="Assunto" required>
        <textarea name="notificationMessage" id="notificationMessage" placeholder="Digite a mensagem..." rows="4" required></textarea>
        <input type="text" id="notificationRecipient" name="notificationRecipient" placeholder="Digite a matrícula...">
        <div class="buttons">
            <button class="confirm">Enviar</button>
            <button class="close" id="reload">Fechar</button>
        </div>
    </template>

    <template id="allconfirm">
        <h1>ALLCONFIRM</h1>
    </template>

    <template id="oneconfirm">
        <h1>Essa é a pessoa que deve receber?</h1>
        <h2>Nome: <span class="nome"></span></h2>
        <h2>E-mail: <span class="email"></span></h2>
        <h2>Matricula: <span class="matricula"></span></h2>
        <h2>Telefone: <span class="telefone"></span></h2>
    </template>

    <footer class="rodape">
        <div>
            <img src="assets/1b1210fdf4454600bea220983da0cc63.png" alt="logo-ifba-seabra" class="logo img-logo" draggable="false">
        </div>
        <div class="copyright">
            <p>&copy; 2024 | IFBA - Instituto Federal de Educação, Ciência e Tecnologia da Bahia Campus Seabra</p>
        </div>
    </footer>
</body>
</html>