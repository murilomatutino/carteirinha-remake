<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <link rel="stylesheet" href="./css/qrcode.css">
    <title>QR code reader</title>
</head>
<body>

    <header class="session-1">
        <a href='https://portal.ifba.edu.br/seabra' target='_blank'>
            <img class="img-logo" src='assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'>
        </a>
    </header>

    <?php include('navbar.php'); showNav("default");?>

    <main>
        <div id="reader"></div>
    </main>

    <script type="text/javascript" src="js/qrcode.js"></script>

    <?php include('footer.php')?>
</body>
</html>