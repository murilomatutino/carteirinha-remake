<?php
    require_once '../Controller/FeedbackController.php';
    $data = (new FeedbackController())->getFeedbackDetails(47);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

    <script>
        const feedbacks = <?php echo json_encode($data); ?>;

        console.log(feedbacks);
    </script>
</body>
</html>