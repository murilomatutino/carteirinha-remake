<?php
    require_once('../CardapioController.php');

    $response = (new CardapioController())->criarTag($_POST['nome'], $_POST['tipo'], $_POST['gluten'], $_POST['lactose']);

    if ($response) {
        echo json_encode(['status' => 'success', 'message' => 'Tag criada com sucesso!']); exit();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Problemas ao criar tag!']); exit();
    }
?>