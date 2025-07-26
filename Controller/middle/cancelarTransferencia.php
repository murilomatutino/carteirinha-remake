<?php
    require_once('../NotificationController.php');

    $response = (new NotificationController)->cancelarTransferencia($_POST['idDestinatario']);
    if ($response) {
        echo json_encode(['status' => 'success']); exit();
    } else {
        echo json_encode(['status' => 'error']); exit();
    }
?>