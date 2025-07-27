<?php
    require_once('CardapioController.php');

    $idJustificativa = 0;
    $justificativa = $_POST['justificativa'];
    $idUser = $_POST['idUser'];
    $diaDaSemana = $_POST['diaDaSemana'];

    if ($justificativa == "outro") {
        $idJustificativa = 4;
        $justificativa = $_POST["outro"];
    } else {
        $idJustificativa = match ($justificativa) {
            "contra-turno" => 1,
            "transporte"   => 2,
            "projeto"      => 3,
            default        => null,
        };
    }
    
    $response = (new CardapioController)->processarReserva($idUser, $idJustificativa, $justificativa, $diaDaSemana);

    if ($response['status']) {
        
        // enviar um e-mail de confirmação
        $return = (new CardapioController())->sendEmailLunch($_SESSION['email'], $_SESSION['name']);
        if (!$return){header("Location: ../View/cardapio.php?agendamento=emailerror"); exit();}

        header("Location: ../View/cardapio.php?agendamento=success"); exit();
    } else {
        header("Location: ../View/cardapio.php?agendamento=error"); exit();
    }

?>