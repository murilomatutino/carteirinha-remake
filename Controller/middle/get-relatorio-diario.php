<?php
    require_once(__DIR__ . '/../classes/RelatorioController.php');
    $controller = new RelatorioController();

    echo json_encode($controller->getRelatorioFaltas($_POST["date"]));  
?>