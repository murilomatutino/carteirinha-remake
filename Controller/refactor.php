<?php 
    require_once 'CardapioController.php';
    require_once 'NotificationController.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['operacao'])) {
        if ($_POST['operacao'] === 'cancelarReserva') {
            $idUser = $_POST['idUser'];
            $motivo = $_POST['motivo'];

            $response = (new CardapioController)->cancelarReserva($idUser, $motivo);

            if ($response['status']) {
                echo json_encode(['status' => 'success', 'message' => $response['message']]); exit();
            } else {
                echo json_encode(['status' => 'error', 'message' => $response['message']]); exit();
            }
        } else if ($_POST['operacao'] === 'transferirReserva') {
            require_once 'CardapioController.php';
            $idUser = $_POST['idUser'];
            $motivo = $_POST['motivo'];
            $matricula = $_POST['matriculaAlvo'];

            $response = (new CardapioController)->transferirReserva($idUser, $motivo, $matricula);

            if ($response['status']) {
                echo json_encode(['status' => 'success', 'message' => $response['message']]); exit();
            } else {
                echo json_encode(['status' => 'error', 'message' => $response['message']]); exit();
            }
        } else if ($_POST['operacao'] === 'aceitarRefeicao') {
            $idDestinatario = $_POST['idDestinatario'];
            $response = (new NotificationController)->aceitarRefeicao($idDestinatario);

            if ($response['status']) {
                echo json_encode(['status' => 'success', 'message' => $response['message']]); exit();
            } else {
                echo json_encode(['status' => 'error', 'message' => $response['message']]); exit();
            }
        } else if ($_POST['operacao'] === 'getNotification') {
            $idUser = $_POST['idUser'];
            $idNotification = $_POST['idNotificacao'];
            $response = (new NotificationController)->getNotification($idUser, $idNotification);

            if ($response !== null) {
                echo json_encode(['status'=> 'success', 'array' => $response]); exit();
            } else {
                echo json_encode(['status'=> 'error', 'message' => 'Nenhuma notificação encontrada']); exit();
            }
        }
    } else {
        $idJustificativa = 0;
        $justificativa = $_POST['justificativa'];
        $idUser = $_POST['idUser'];
        $diaDaSemana = $_POST['diaDaSemana'];

        if ($justificativa == "outro") {
            $idJustificativa = 4;
            $justificativa = $_POST["outro"];
        } else {
            $idJustificativa = match ($justificativa) {
                "contra-turno" => 1,
                "transporte"   => 2,
                "projeto"      => 3,
                default        => null,
            };
        }
        
        $response = (new CardapioController)->processarReserva($idUser, $idJustificativa, $justificativa, $diaDaSemana);

        if ($response['status']) {
            header("Location: ../View/cardapio.php?reserva=success"); exit();
        } else {
            header("Location: ../View/cardapio.php?reserva=error"); exit();
        }
    }
?>