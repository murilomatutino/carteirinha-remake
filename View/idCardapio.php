<?php
session_start();
require_once "../Controller/CardapioController.php";
date_default_timezone_set('America/Sao_Paulo');
$dia = date("l", strtotime(date("Y-m-d")));
$dia = str_replace(
    ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
    ['segunda', 'terca', 'quarta', 'quinta', 'sexta'],
    $dia
);

$resoponse = (new CardapioController)->getIdCardapio($dia);

if ($resoponse !== null) {
    echo $resoponse;
}
?>