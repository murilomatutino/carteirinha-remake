<?php
    require_once('../CardapioController.php');

    $response = (new CardapioController)->excluirCardapio();

    if (is_array($response) && isset($response['status']) && $response['status'] === true) {
        echo json_encode(['status' => 'success', 'message' => $response['message']]); exit();
    } else {
        $message = is_array($response) && isset($response['message']) ? $response['message'] : 'Erro desconhecido ao excluir cardápio.';
        echo json_encode(['status' => 'error', 'message' => $message]); exit();
    }
?>