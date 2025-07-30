<?php
    require_once(__DIR__ . '/../classes/CardapioController.php');

    $cardapio = json_decode($_POST['cardapio'], true);
    $response = (new CardapioController())->salvarCardapioSemana($cardapio);

    if ($response) {
        echo json_encode(['status' => 'success', 'message' => 'Cardápio criado com sucesso!']); exit();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Problemas ao criar cardápio!']); exit();
    }
?>