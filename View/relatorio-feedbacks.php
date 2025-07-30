<?php
    function xorDecrypt($encoded, $key) {
        $data = base64_decode($encoded);
        $result = '';
        for ($i = 0; $i < strlen($data); $i++) {
            $result .= chr(ord($data[$i]) ^ ord($key[$i % strlen($key)]));
        }
        return $result;
    }

    $id = isset($_GET['id']) ? xorDecrypt($_GET['id'], 'ledsifba') : '';

    require_once(__DIR__ . '/../Controller/classes/FeedbackController.php');
    $data = (new FeedbackController())->getFeedbackDetails($id);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mais detalhes - Feedbacks</title>
    <link rel="stylesheet" href="css/feedbacks.css">
</head>
<body>
    <h1>Relatório de Refeições</h1>
    <div class="table-container">
        <table id="relatorio-table">
        <thead>
            <tr>
            <th>Nome</th>
            <th>Matrícula</th>
            <th>Data</th>
            <th>Dia</th>
            <th>Principal</th>
            <th>Acompanhamento</th>
            <th>Sobremesa</th>
            <th>Nota</th>
            </tr>
        </thead>
        <tbody></tbody>
        </table>
    </div>

    <script>
        const feedbacksAll = <?php echo json_encode($data); ?>;

        // console.log(feedbacks);
    </script>
    <script src="js/feedbacks.js"></script>
</body>
</html>