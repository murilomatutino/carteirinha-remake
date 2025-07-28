<?php
    require_once('../AdmController.php');

    $response = (new AdmController)->editarHorario($_POST['hora']);
    $encodedMessage = base64_encode($response['message']);

    if ($response !== null && $response['status']) {
        header("Location: ../../View/painel-administrador.php?status=success&message=" . urlencode($encodedMessage)); exit();
    } else {
        header("Location: ../../View/editar-horario.php?status=error&message=" . urlencode($encodedMessage)); exit();
    }
?>