<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/editar-horario.css">
    <title>Editar Horário</title>
</head>
<body>
<header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img class="img-logo" src='assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>

    <?php include_once("navbar.php"); ?>

    <div class="container">
        <h1>EDITAR HORÁRIO</h1>

        <form method="POST">
            <label for="data">Data:</label>
            <input type="date" id="data" name="data" required>
            <br>
            <label for="hora">Hora:</label>
            <input type="time" id="hora" name="hora" required>
            <br>
            <div class="botao-container">
                <a href='painel-administrador.php'><button class="cancelar" type="button"></button></a>

                <button class="validar" type="submit"></button>
            </div>
        </form>
    </div>


    <?php include 'footer.php'; ?>
</body>
</html>