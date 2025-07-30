<?php
    require_once(__DIR__ . '/../classes/FeedbackController.php');

    $response = (new FeedbackController)->sendFeedback($_POST['nota'], $_POST['idUser'], $_POST['idCardapio']);

    if ($response) {
        echo json_encode(['status'=> 'success']); exit();
    } else {
        echo json_encode(['status'=> 'error']); exit();
    }
?>