<?php
    require_once(__DIR__ . '/../classes/NotificationController.php');

    $response = (new NotificationController)->cancelarTransferencia($_POST['idDestinatario']);
    if ($response) {
        echo json_encode(['status' => 'success']); exit();
    } else {
        echo json_encode(['status' => 'error']); exit();
    }
?>