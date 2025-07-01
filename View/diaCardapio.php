<?php
    require_once '../Controller/FeedbackController.php';
    $controller = new FeedbackController();

    echo json_encode($controller->getDiaByID($_POST["idCardapio"]));  
?>