<?php
    require_once('../AuthController.php');

    $response = (new AuthController())->login($_POST['matricula'], $_POST['password']);

    if ($response['status']) {
        echo json_encode(['status' => 'success', 'message' => $response['message']]); exit();
    } else {
        echo json_encode(['status' => 'error', 'message' => $response['message']]); exit();
    }
?>