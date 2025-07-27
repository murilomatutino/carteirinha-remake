<?php
    require_once '../FeedbackController.php';
    $controller = new FeedbackController();

    echo json_encode($controller->getDiaByID($_POST["idCardapio"]));  
?>