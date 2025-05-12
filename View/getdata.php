<?php
    function xorDecrypt($encoded, $key) {
        $data = base64_decode($encoded);
        $result = '';
        for ($i = 0; $i < strlen($data); $i++) {
            $result .= chr(ord($data[$i]) ^ ord($key[$i % strlen($key)]));
        }
        return $result;
    }

    $id = isset($_GET['id']) ? xorDecrypt($_GET['id'], 'ledsifba') : '';

    require_once '../Controller/FeedbackController.php';
    $data = (new FeedbackController())->getFeedbackDetails($id);
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