<?php
    require_once '../Controller/FeedbackController.php';
    $controller = new FeedbackController();

    echo json_encode($controller->getUserFeedback($_POST["idUser"]));  
?>