<?php session_start();
    require '../Controller/CardapioController.php';
    $cardapio = (new CardapioController)->getCardapio();
    date_default_timezone_set('America/Sao_Paulo');
    $dataAtual = date('Y-m-d'); // Pode ser qualquer data no formato Y-M-D (por exemplo, '2021-12-08')
    $diaDaSemana = date('l', strtotime($dataAtual));
    $diaNumero = 0;

    switch ($diaDaSemana) {
        case "Monday": $diaDaSemana = "segunda"; break;
        case "Tuesday": $diaDaSemana = "terca"; $diaNumero = 1; break;
        case "Wednesday": $diaDaSemana = "quarta"; $diaNumero = 2; break;
        case "Thursday": $diaDaSemana = "quinta"; $diaNumero = 3; break;
        case "Friday": $diaDaSemana = "sexta"; $diaNumero = 4; break;
        default: break;
    }

    $cardapio = $cardapio[$diaNumero];

    // $_SESSION['diaSemana'] = $diaDaSemana;
    // echo $diaDaSemana; exit();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cardapio-reserva.css">
    <script type="module" src="js/index.js"></script>
    <title>Justificar Almoço</title>
</head>
<body>
    <header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img class="img-logo" src='assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>
    <?php include_once("navbar.php"); showNav("default"); ?>

    <div class="container">
        <h1>RESERVAR ALMOÇO</h1>
        <form action="../Controller/CardapioController.php" method="POST">
            <input type="text" name="diaDaSemana" id="diaDaSemana" value="<?= htmlspecialchars($diaDaSemana) ?>" hidden>
            <input type="text" name="idUser" id="idUser" value="<?= htmlspecialchars($_SESSION['id']) ?>" hidden>

            <table>
                <tr><th colspan="2"><?php echo ucfirst($diaDaSemana) . '-feira' ?></th></tr>
                <tr><td>Proteína</td><td><?php echo $cardapio['principal']; ?></td></tr>
                <tr><td>Acompanhamento</td><td><?php echo $cardapio['acompanhamento']; ?></td></tr>
                <tr><td>Sobremesa</td><td><?php echo $cardapio['sobremesa']; ?></td></tr>
            </table>

            <label for="justificativa">Justificativa:</label>
            <select id="justificativa" name="justificativa" required>
                <option value="" selected disabled hidden>Selecione uma opção...</option>
                <option value="contra-turno">Aula no Contra Turno</option>
                <option value="transporte">Transporte</option>
                <option value="projeto">Projeto, TCC</option>
                <option value="outro">Outro</option>
            </select><br>

            <label for="outro">Outro Motivo:</label>
            <input type="text" id="outro" name="outro" placeholder="Digite outro motivo..." disabled required><br>

            <div class="botao-container">
                <button class="cancelar" type="button" onclick="cancelarCardapio()"></button>
                <button class="validar" type="submit"></button>
            </div>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>