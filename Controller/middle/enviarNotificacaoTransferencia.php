<?php
    require_once(__DIR__ . '/../classes/CardapioController.php');
    require_once(__DIR__ . '/../classes/NotificationController.php');
    
    $idAlvo = (new CardapioController())->getIdByMatricula($_POST['matriculaAlvo']);

    $return = (new NotificationController())->createNotificacao($_POST['idUser'], $idAlvo, 'Transferencia de almoço', "Motivo da transferência: " . $_POST['motivo'], 1);
    
    if ($idAlvo === false) {
        echo json_encode(['status'=> 'error', 'message' => 'Erro ao pegar id por matricula']); exit();
    }
    else if ($return === false) {
        echo json_encode(['status'=> 'error', 'message' => 'Erro ao criar notificação']); exit();
    }
    else {
        echo json_encode(['status'=> 'success', 'message' => 'sucesso ao criar notificação']); exit();
    }
?>