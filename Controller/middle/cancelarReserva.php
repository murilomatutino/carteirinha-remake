<?php
    require_once('../CardapioController.php');

    $response = (new CardapioController)->cancelarReserva($_POST['idUser'], $_POST['motivo']);

    if ($response['status']) {
        echo json_encode(['status' => 'success', 'message' => $response['message']]); exit();
    } else {
        echo json_encode(['status' => 'error', 'message' => $response['message']]); exit();
    }
?>