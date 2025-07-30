<?php
    require_once(__DIR__ . '/../classes/FeedbackController.php');
    $controller = new FeedbackController();

    echo json_encode($controller->getUserFeedback($_POST["idUser"]));  
?>