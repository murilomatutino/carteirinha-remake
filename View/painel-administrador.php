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

<?php include_once("navbar.php"); showNav("default"); ?>

    <h1>PAINEL ADMINISTRADOR</h1>

    <div class="container">
        <div class="button-adm"><button class='horario' id='horario'></button></div>
        <div class="button-adm"><button class='historico' id='historico'></button></div>
        <div class="button-adm"><button class='diario' id='diario'></button></div>
        <div class="button-adm"><button class='feedback' id='feedback'></button></div>
        <div class="button-adm"><button class='cardapio' id='cardapio'></button></div>
    </div>

    <?php include 'footer.php'; ?>
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
                        window.location.href = 'relatorio-feedbacks.php'; break;
                    case 'cardapio':
                        window.location.href = 'cardapio'; break;
                }
            })
        });
    </script>
</body>
</html>