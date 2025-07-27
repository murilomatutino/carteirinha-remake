<?php
    require_once '../RelatorioController.php';
    $controller = new RelatorioController();

    echo json_encode($controller->getRelatorioFaltas($_POST["date"]));  
?>