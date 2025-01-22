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
    <?php require_once "navbar.php"; showNav("default"); ?>
    
    <div class="overlay" id="overlay"></div>
    <div class="popup" id="popup"></div>

    <div class="container">
        <h1>AGENDADOS</h1>
        <img src="assets/cozinheira.png" alt="Imagem do Boneco" class="image2" draggable="false">

        <table>
            <?php 
                $idUser = $_SESSION['id'];
                
                $sql = "SELECT * FROM refeicao WHERE id_usuario = '$idUser'";
                $result = $conn->query($sql);

                $refeicaoData = [];

                while ($row = mysqli_fetch_assoc($result)) {
                    $refeicaoData = $row;
                }

                if (count($refeicaoData) > 0) {

                    $cardapioId = $refeicaoData['id_cardapio'];

                    $sql = "SELECT data_refeicao, dia, principal, acompanhamento, sobremesa FROM cardapio WHERE id = $cardapioId";
                    $result = $conn->query($sql);

                    $cardapioData = [];

                    while ($row = mysqli_fetch_assoc($result)) {
                        $cardapioData = $row;
                    }

                    $dia = ucfirst($cardapioData['dia']) . "-feira";

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
                    echo "<td>{$dia}({$cardapioData['data_refeicao']})</td>";
                    echo "<td>{$cardapioData['principal']}</td>";
                    echo "<td>{$cardapioData['acompanhamento']}</td>";
                    echo "<td>{$cardapioData['sobremesa']}</td>";
                    echo "<td>";
                    // echo "<a href='cardapio-cancelar.php'>";
                    echo "<button class='vermelho' id='action'><img src='assets/cancelar.png' alt='none'></button>";
                    echo "</a>";
                    // echo "<a href='cardapio-disponibilizar.php'>";
                    echo "<button class='amarelo' id='action'><img src='assets/transferir.png' alt='none'></button>";
                    echo "</a>";
                    // echo "<button class='azul' onclick='window.location.href=\"qr-code.php\";'><img src='assets/qrcode.png' alt='none'></button>";
                    echo "</a>";
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