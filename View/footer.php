<?php 
    $css = 'css/style.css';
    $img = '../assets/1b1210fdf4454600bea220983da0cc63.png';
    $script = 'index.js';
    $relativePath = '/' . basename($_SERVER['SCRIPT_FILENAME']); 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $css; ?>">
    <title>FOOTER</title>
    <script type="module" src="<?php echo $script; ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="overlay" id="notificationOverlay"></div>
    <div class="popup" id="notificationPopup"></div>

    <!-- Novo Popup 2 (Este é o que queremos abrir acima) -->
    <div class="overlay2" id="overlay2"></div>
    <div class="popup2" id="popup2">
        <h2>Detalhes da Notificação</h2>
        <p id="popupContent">Aqui vai o conteúdo do popup.</p>
        <button class="close-btn-2" onclick="closePopup2()">Fechar</button>
    </div>

    <template id="show">
        <h2>Notificações</h2>
        <div id="notificationList">
            <?php
            if (isset($_SESSION['logged_in'])) {
                global $controller;
                $userId = $_SESSION['id'];
                $result = $controller->hasNotification($userId);

                if ($result) {
                    $assuntos = $controller->getAssunto($userId);
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
            <?php if ($_SESSION['category'] == 'adm'): ?>
                <button class='send'>Enviar notificação</button>
            <?php endif; ?>
            <button class="close" onclick="closeNotificationPopup()">Fechar</button>
        </div>
    </template>

    <template id="send">
        <h3>Enviar Notificação</h3>
        <input type="text" id="assunto" name="assunto" placeholder="Assunto" required>
        <textarea name="notificationMessage" id="notificationMessage" placeholder="Digite a mensagem..." rows="4" required></textarea>
        <input type="text" id="notificationRecipient" name="notificationRecipient" placeholder="Digite a matrícula...">
        <div class="buttons">
            <button class="confirm">Enviar</button>
            <button class="close" onclick="closeNotificationPopup(); location.reload();">Fechar</button>
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
            <img src="<?php echo $img; ?>" alt="logo-ifba-seabra" class="logo img-logo" draggable="false">
        </div>
        <div class="copyright">
            <p>&copy; 2024 | IFBA - Instituto Federal de Educação, Ciência e Tecnologia da Bahia Campus Seabra</p>
        </div>
    </footer>

    <script>
        // Função para abrir o pop-up de notificações
        function openNotificationPopup() {
            document.getElementById('notificationPopup').style.display = 'block';
            document.getElementById('notificationOverlay').style.display = 'block';
        }

        // Função para fechar o pop-up de notificações
        function closeNotificationPopup() {
            document.getElementById('notificationPopup').style.display = 'none';
            document.getElementById('notificationOverlay').style.display = 'none';
        }

        // Adiciona o evento de clique no ícone de notificações
        document.querySelector('.notification-icon').addEventListener('click', openNotificationPopup);

        // Mudando de Telas na Área de Notificação
        document.querySelector('#notificationPopup').innerHTML = document.querySelector('#show').innerHTML;
        const send = document.querySelector('.send');

        if (send) {
            send.addEventListener('click', () => {
                document.querySelector('#notificationPopup').innerHTML = document.querySelector('#send').innerHTML;
                
                document.querySelector('.confirm').addEventListener('click', () => {
                    if (document.querySelector('#notificationRecipient').value != '') {
                        const matricula = document.querySelector('#notificationRecipient').value;
                        document.querySelector('#notificationPopup').innerHTML = document.querySelector('#oneconfirm').innerHTML;
                        

                        fetch('process/process-oneconfirm.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: new URLSearchParams({
                                'matricula': matricula
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                document.querySelector('.nome').innerText = data.data.nome;
                                document.querySelector('.email').innerText = data.data.email;
                                document.querySelector('.matricula').innerText = data.data.matricula;
                                document.querySelector('.telefone').innerText = data.data.telefone;

                            } else {
                                alert(data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Erro ao enviar o sinal:', error);
                        });
                    } else {
                        document.querySelector('#notificationPopup').innerHTML = document.querySelector('#allconfirm').innerHTML;
                    }
                });
            });
        }

        // Função para abrir o popup 2
        function openPopup2() {
            document.getElementById('overlay2').style.display = 'block';
            document.getElementById('popup2').style.display = 'block';
        }

        // Função para fechar o popup 2
        function closePopup2() {
            document.getElementById('overlay2').style.display = 'none';
            document.getElementById('popup2').style.display = 'none';
        }
    </script>
</body>
</html>
