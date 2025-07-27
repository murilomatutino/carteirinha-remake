<?php
require_once "../CardapioController.php";

$dia = $_POST['diaSemana'];

$resoponse = (new CardapioController)->getIdCardapio($dia);

if ($resoponse !== null) {
    echo $resoponse;
}
?>