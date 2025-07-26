<?php
    require_once('NotificationController.php');

    $response = (new NotificationController)->getNotification($_POST['idUser'], $_POST['idNotificacao']);

    if ($response !== null) {
        echo json_encode(['status'=> 'success', 'array' => $response]); exit();
    } else {
        echo json_encode(['status'=> 'error', 'message' => 'Nenhuma notificação encontrada']); exit();
    }
?>