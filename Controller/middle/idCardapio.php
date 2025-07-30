<?php
require_once(__DIR__ . "/../classes/CardapioController.php");

$dia = $_POST['diaSemana'];

$resoponse = (new CardapioController)->getIdCardapio($dia);

if ($resoponse !== null) {
    echo $resoponse;
}
?>