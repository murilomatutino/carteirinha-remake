<?php
require_once "../Controller/CardapioController.php";

$dia = $_POST['diaSemana'];

$resoponse = (new CardapioController)->getIdCardapio($dia);

if ($resoponse !== null) {
    echo $resoponse;
}
?>