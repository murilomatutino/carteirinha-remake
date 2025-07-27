<?php
    require_once '../RelatorioController.php';
    $controller = new RelatorioController();

    echo json_encode($controller->getCardapioByInterval($_POST["inicio"], $_POST["fim"]));  
?>