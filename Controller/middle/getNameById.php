<?php
    require_once '../RelatorioController.php';
    $controller = new RelatorioController();

    echo json_encode($controller->getNameById($_POST["id"]));  
?>