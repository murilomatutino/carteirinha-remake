<?php
session_start();
if (isset($_SESSION['diaSemana'])) {
    require('../../Model/connect.php');
    require('../../Controller/controller.php');
    $controller = new LoginController();
    global $conn;

    $justificativa = $_POST['justificativa'];
    $idUser = $_SESSION['id'];
    $idJustificativa = 0;

    if ($_POST["justificativa"] == "outro") {
        $idJustificativa = 4;
        $justificativa = $_POST["outro"];
    } else {
        switch ($_POST["justificativa"]) {
            case "contra-turno": $idJustificativa = 1; break;
            case "transporte": $idJustificativa = 2; break;
            case "projeto": $idJustificativa = 3; break;
        }
        $justificativa = null;
    }

    $diaDaSemana = $_SESSION['diaSemana'];
    $sql = "SELECT id FROM cardapio WHERE dia = '$diaDaSemana' AND ind_excluido = 0";
    // echo $diaDaSemana; exit;
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $idCardapio = $row['id'];
    $statusRef = 1;
    $dataSolicitacao = date("Y-m-d");
    $horaSolicitacao = date("H:i:s");
    // echo $dataSolicitacao;

    $result = $controller->setMeal($idUser, $idCardapio, $statusRef, $idJustificativa, $dataSolicitacao, $horaSolicitacao, $justificativa);

    if ($result == "Sem erros") {
        header("Location: ../cardapio.php?reserva=confirmada");
        exit();
    } else {
        echo $result;
    }
} else {
    var_dump($_SESSION);
}
?>