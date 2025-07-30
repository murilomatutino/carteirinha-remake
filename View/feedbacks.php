<?php
    require_once(__DIR__ . '/../Controller/classes/FeedbackController.php');
    require_once(__DIR__ . '/../Controller/classes/CardapioController.php');

    $feedbackController = new FeedbackController();
    $cardapioController = new CardapioController();

    $feedbacks = $feedbackController->getFeedback();
    $refeicoes_confirmadas = $cardapioController->getRefeicoesConfirmadas();

    $mapaRegistros = [];
    foreach ($refeicoes_confirmadas as $refeicao) {
        $mapaRegistros[$refeicao['data']] = $refeicao['registros'];
    }

    foreach ($feedbacks as &$feedback) {
        $dataFormatada = date('Y-m-d', strtotime($feedback['data_hora']));
        $feedback['registros'] = $mapaRegistros[$dataFormatada] ?? 0;
    }
    unset($feedback);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de feedbacks</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/feedbacks.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img class="img-logo" src='assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>
    <?php include_once("navbar.php"); ?>

    <header class="feedbacks">
        <h1>Relatório de feedbacks</h1>
        <div class="filter">
            <form>
                <div>
                    <label>Início <br><input type="date"></label>
                    <label>Fim <br><input type="date"></label>
                </div>
                <input type="submit" value="Filtrar">
            </form>
        </div>
    </header>

    <main id="graficos-container"></main>

    <script>
        const feedbacks = <?php echo json_encode($feedbacks); ?>;
    </script>
    <script src="js/feedbacks.js"></script>

    <?php include 'footer.php'; ?>
</body>
</html>
