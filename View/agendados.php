<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/agendados.css">
    <title>Agendados</title>
</head>
<body>
    <header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img class="img-logo" src='assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>
    <?php require_once "navbar.php"; ?>
    
    <div class="overlay" id="overlay"></div>
    <div class="popup" id="popup"></div>

    <div class="container">
        <h1>AGENDADOS</h1>
        <img src="assets/cozinheira.png" alt="Imagem do Boneco" class="image2" draggable="false">

        <table>
            <?php 
                require_once "../Controller/CardapioController.php";
                $idUser = $_SESSION['id'];
                $refeicaoData = (new CardapioController)->getRefeicaoById($idUser);

                if (count($refeicaoData) > 0) {
                    $cardapioId = $refeicaoData['id_cardapio'];
                    $cardapioData = (new CardapioController)->getCardapioById($cardapioId);
                    $data_refeicao = date("d/m", strtotime($cardapioData['data_refeicao']));

                    $dia = ucfirst($cardapioData['dia']);

                    echo "
                        <thead>
                            <tr>
                                <th>Dia</th>
                                <th>Proteína</th>
                                <th>Acompanhamento</th>
                                <th>Sobremesa</th>
                                <th></th> <!-- Coluna extra para os botões -->
                            </tr>
                        </thead>
                        <tbody>";
                    
                    echo "<tr>";
                    echo "<td>{$dia}({$data_refeicao})</td>";
                    echo "<td>{$cardapioData['proteina']}</td>";
                    echo "<td>{$cardapioData['principal']}</td>";
                    echo "<td>{$cardapioData['sobremesa']}</td>";
                    echo "<td>";

                    if ((new CardapioController)->hasTransferencia($_SESSION['id'])) {
                        echo "<h3>Transferência em andamento...</h3>";
                    } else {
                        echo "<button class='vermelho' id='action'><img src='assets/cancelar.png' alt='none'></button>";
                        echo "<button class='amarelo' id='action'><img src='assets/transferir.png' alt='none'></button>";
                    }
                    // echo "<a href='cardapio-cancelar.php'>";
                    // echo "</a>";
                    // echo "<a href='cardapio-disponibilizar.php'>";
                    // echo "</a>";
                    // echo "<button class='azul' onclick='window.location.href=\"qr-code.php\";'><img src='assets/qrcode.png' alt='none'></button>";
                    // echo "</a>";
                    echo "</td>";
                    echo "</tr>";
                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "<h1 class='texto'>Sem refeição registrada</h1>";
                }
            ?>
        </table>
        <button class='editar' id="voltar">Voltar</button>
    </div>

    <?php require_once "footer.php"; ?>
</body>
</html>