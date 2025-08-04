<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/painel-administrador.css">
    <title>Painel Administrador</title>
</head>
<body>
<header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img class="img-logo" src='assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' 
draggable='false'> </a> </header>

<?php include_once("navbar.php"); ?>

    <h1>PAINEL ADMINISTRADOR</h1>


    <div class="container">
        <div class="button-adm"><button class='horario' id='horario'>
            <img src="assets/card-horario.png" alt="">
        </button></div>
        <div class="button-adm"><button class='historico' id='historico'>
            <img src="assets/card-historico.png" alt="">
        </button></div>
        <div class="button-adm"><button class='diario' id='diario'>
            <img src="assets/card-diario.png" alt="">
        </button></div>
        <div class="button-adm"><button class='feedback' id='feedback'>
            <img src="assets/card-feedback.png" alt="">
        </button></div>
        <div class="button-adm"><button class='cardapio' id='cardapio'>
            <img src="assets/card-cardapio.png" alt="">
        </button></div>
        <div class="button-adm"><button class='usuarios' id='usuarios'>
            <img src="assets/card-adc-usuario.png" alt="">
        </button></div>
    </div>

    <?php include 'footer.php'; ?>

    <script type="module">
        import { showNotification } from './js/index.js';
        const params = new URLSearchParams(window.location.search);
        let message = '';

        const base64 = params.get('message');
        if (base64) {
            try {
                message = atob(base64);
                console.log('Mensagem:', message);
                if (params.get('status') === 'success' && [...params.keys()].length > 1) {
                    showNotification('Sucesso', message);
                }
            } catch (e) {
                console.error('Erro ao decodificar mensagem:', e);
            }
        }        
    </script>

    <script>
        const buttons = document.querySelectorAll('.container .button-adm button');

        buttons.forEach(button => {
            button.addEventListener('click', function() {
                switch (button.id) {
                    case 'horario':
                        window.location.href = 'editar-horario.php'; break;
                    case 'historico':
                        window.location.href = 'historico.php'; break;
                    case 'diario':
                        window.location.href = 'relatorio-diario.php'; break;
                    case 'feedback':
                        window.location.href = 'feedbacks.php'; break;
                    case 'cardapio':
                        window.location.href = 'cardapio.php'; break;
                    case 'usuarios':
                        window.location.href = 'adicionarUsuarios.php'; break;
                }
            })
        });
    </script>
</body>
</html>