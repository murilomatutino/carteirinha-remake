<?php 
    require_once 'CardapioController.php';
    require_once 'NotificationController.php';

    function cancelarReserva($idUser, $motivo) {
        $response = (new CardapioController)->cancelarReserva($idUser, $motivo);

        if ($response['status']) {
            echo json_encode(['status' => 'success', 'message' => $response['message']]); exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => $response['message']]); exit();
        }
    }

    function transferirReserva($idUser, $motivo, $matriculaAlvo) {
        $response = (new CardapioController)->transferirReserva($idUser, $motivo, $matriculaAlvo);

        if ($response['status']) {
            echo json_encode(['status' => 'success', 'message' => $response['message']]); exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => $response['message']]); exit();
        }
    }

    function aceitarRefeicao($idDestinatario) {
        $response = (new NotificationController)->aceitarRefeicao($idDestinatario);

        if ($response['status']) {
            echo json_encode(['status' => 'success', 'message' => $response['message']]); exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => $response['message']]); exit();
        }
    }

    function getNotification($idUser, $idNotification) {
        $response = (new NotificationController)->getNotification($idUser, $idNotification);

        if ($response !== null) {
            echo json_encode(['status'=> 'success', 'array' => $response]); exit();
        } else {
            echo json_encode(['status'=> 'error', 'message' => 'Nenhuma notificação encontrada']); exit();
        }
    }

    function readNotification($idDestinatario, $idNotification) {
        $response = (new NotificationController)->readNotification($idDestinatario, $idNotification);

        if ($response['status']) {
            echo json_encode(['status' => 'success', 'message' => $response['message']]); exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => $response['message']]); exit();
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['operacao'])) {
        switch ($_POST['operacao']) {
            case 'cancelarReserva': cancelarReserva($_POST['idUser'], $_POST['motivo']); break;
            case 'transferirReserva': transferirReserva($_POST['idUser'], $_POST['motivo'], $_POST['matriculaAlvo']); break;
            case 'aceitarRefeicao': aceitarRefeicao($_POST['idDestinatario']); break;
            case 'getNotification': getNotification($_POST['idUser'], $_POST['idNotificacao']); break;
            case 'readNotification': readNotification($_POST['idDestinatario'], $_POST['idNotificacao']); break;
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