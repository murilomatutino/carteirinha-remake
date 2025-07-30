<?php
    require_once(__DIR__ . '/../classes/RelatorioController.php');
    $controller = new RelatorioController();

    echo json_encode($controller->getNameById($_POST["id"]));  
?>