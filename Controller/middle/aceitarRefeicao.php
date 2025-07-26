<?php
    require_once('../NotificationController.php');

    $response = (new NotificationController)->aceitarRefeicao($_POST['idDestinatario']);
    if ($response['status']) {
        echo json_encode(['status' => 'success', 'message' => $response["message"]]); exit();
    } else {
        echo json_encode(['status' => 'error', 'message' => $response["message"]]); exit();
    }
?>