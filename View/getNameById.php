<?php
    require_once '../Controller/RelatorioController.php';
    $controller = new RelatorioController();

    echo json_encode($controller->getNameById($_POST["id"]));  
?>