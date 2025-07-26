<?php
    require_once('../NotificationController.php');

    $response = (new NotificationController)->readNotification($_POST['idDestinatario'], $_POST['idNotificacao']);

    if ($response['status']) {
        echo json_encode(['status' => 'success', 'message' => $response['message']]); exit();
    } else {
        echo json_encode(['status' => 'error', 'message' => $response['message']]); exit();
    }
?>