<?php session_start();
    require '../Controller/CardapioController.php';
    $cardapioRaw = (new CardapioController)->getCardapio();
    date_default_timezone_set('America/Sao_Paulo');
    $dataAtual = date('Y-m-d');
    $diaDaSemana = date('l', strtotime($dataAtual));
    $diaNumero = 0;

    switch ($diaDaSemana) {
        case "Monday": $diaDaSemana = "Segunda"; break;
        case "Tuesday": $diaDaSemana = "Terça"; $diaNumero = 1; break;
        case "Wednesday": $diaDaSemana = "Quarta"; $diaNumero = 2; break;
        case "Thursday": $diaDaSemana = "Quinta"; $diaNumero = 3; break;
        case "Friday": $diaDaSemana = "Sexta"; $diaNumero = 4; break;
        default: break;
    }

    $cardapioRaw = $cardapioRaw[$diaNumero];
    $cardapio['dia'] = $cardapioRaw['dia'];  
    $cardapio['data_hora_cardapio'] = $cardapioRaw['data_hora_cardapio'];

    foreach ($cardapioRaw as $key => $data) {
        $tempData = json_decode($data, true);

        if (is_array($tempData)) {
            $sufixo = '';
            $gluten = $tempData['gluten'] == 1;
            $lactose = $tempData['lactose'] == 1;

            if ($gluten && $lactose) {
                $sufixo = ' +++';
            } elseif ($gluten) {
                $sufixo = ' +';
            } elseif ($lactose) {
                $sufixo = ' ++';
            }

            $tempData['nome'] = $tempData['nome'] . $sufixo;
            $cardapio[$key] = $tempData;
        }
    }
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
    <?php include_once("navbar.php"); ?>

    <div class="container">
        <h1>RESERVAR ALMOÇO</h1>
        <form action="../Controller/refactor.php" method="POST">
            <input type="text" name="diaDaSemana" id="diaDaSemana" value="<?= htmlspecialchars($diaDaSemana) . '-feira'?>" hidden>
            <input type="text" name="idUser" id="idUser" value="<?= htmlspecialchars($_SESSION['id']) ?>" hidden>

            <table>
                <tr><th colspan="2"><?php echo ucfirst($diaDaSemana) . '-feira' ?></th></tr>
                <tr><td>Proteína</td><td><?php echo $cardapio['proteina']['nome']; ?></td></tr>
                <tr><td>Principal</td><td><?php echo $cardapio['principal']['nome']; ?></td></tr>
                <tr><td>Sobremesa</td><td><?php echo $cardapio['sobremesa']['nome']; ?></td></tr>
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
                <button class="cancelar" type="button"></button>
                <button class="validar" type="submit"></button>
            </div>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>