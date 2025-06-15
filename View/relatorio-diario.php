<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/relatorio-diario.css">
    <title>Relatório Diário</title>
</head>
<body>
    <header class="session-1">
        <a href='https://portal.ifba.edu.br/seabra' target='_blank'>
            <img class="img-logo" src='assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'>
        </a>
    </header>

    <?php include('navbar.php')?>

    <main>
        <h1>Relatório pessoas que não retiraram o almoço</h1>
        <div id="container-filtro">
            <form>
                <div>
                    <label>Dia</label>
                    <input type="date" name="date" id="date" required>
                </div>
                <input type="button" id="btn-submit" value="Filtrar">
            </form>
        </div>

        <div id="resultados">
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Hora solicitação</th>
                    </tr>
                </thead>
                <tbody id="tablebody">

                </tbody>
            </table>
        </div>
    </main>

    <?php include('footer.php')?>
    <script src="js/relatorio-diario.js" type="module"></script>
</body>
</html>