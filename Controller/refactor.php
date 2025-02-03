<?php 
    if (isset($_POST['operacao'])) {
        if ($_POST['operacao'] === 'cancelarReserva') {
            require_once 'CardapioController.php';
            $idUser = $_POST['idUser'];
            $motivo = $_POST['motivo'];

            (new CardapioController)->cancelarReserva($idUser, $motivo);
        } else if ($_POST['operacao'] === 'transferirReserva') {
            require_once 'CardapioController.php';
            $idUser = $_POST['idUser'];
            $motivo = $_POST['motivo'];
            $matricula = $_POST['matriculaAlvo'];

            (new CardapioController)->transferirReserva($idUser, $motivo, $matricula);
        } else if ($_POST['operacao'] === 'aceitarRefeicao') {
            require_once 'NotificationController.php';
            $idDestinatario = $_POST['idDestinatario'];
            $response = (new NotificationController)->aceitarRefeicao($idDestinatario);

            if ($response['status']) {
                echo json_encode(['status' => 'success', 'message' => 'Refeição aceita com sucesso']); exit();
            } else {
                echo json_encode(['status' => 'error', 'message' => $response['message']]); exit();
            }
        }
    }
?>