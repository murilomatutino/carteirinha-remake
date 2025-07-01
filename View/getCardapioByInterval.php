<?php
    require_once '../Controller/RelatorioController.php';
    $controller = new RelatorioController();

    echo json_encode($controller->getCardapioByInterval($_POST["inicio"], $_POST["fim"]));  
?>