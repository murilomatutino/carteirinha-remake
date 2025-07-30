<?php
    require_once(__DIR__ . '/../classes/FeedbackController.php');
    $controller = new FeedbackController();

    echo json_encode($controller->getDiaByID($_POST["idCardapio"]));  
?>