<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar agendamento</title>
    <link rel="stylesheet" href="./css/verificar-agendamento.css">
</head>
<body>
    <header class="session-1">
        <a href='https://portal.ifba.edu.br/seabra' target='_blank'>
            <img class="img-logo" src='assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'>
        </a>
    </header>

    <?php include('navbar.php')?>

    <main>
        <?php
            include '../Controller/AgendamentoController.php';
            $controller = new AgendamentoController();

            date_default_timezone_set('America/Sao_Paulo');
            $dataAtual = date('Y-m-d');
            
            $situacao = $controller->hasAgendamento($dataAtual, $_SESSION["id"]);

            if ($situacao)
            {
                echo "
                    <div class='popup-alerta agendado'>
                        <div id='popup-alerta-close'>X</div>
                        <p>Almoço retirado com sucesso!</p>
                    </div>";
                //$controller->retirarAlmoco($dataAtual, $_SESSION["id"]);
            }
            else
            {
                echo "
                    <div class='popup-alerta nao-agendado'>
                        <div id='popup-alerta-close'>X</div>
                        <p>Você não tem nenhum almoço agendado para hoje</p>
                    </div>";
            }
        ?>
    </main>

    <?php include('footer.php')?>
    <script type="text/javascript" src="js/verificar-agendamento.js"></script>
</body>
</html>