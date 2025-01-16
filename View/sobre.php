<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre</title>
    <link rel="stylesheet" href="css/sobre.css">
</head>
<body>
    <header class="session-1">
        <a href='https://portal.ifba.edu.br/seabra' target='_blank'>
            <img class="img-logo" src='assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'>
        </a>
    </header>

    <?php include_once("navbar.php"); showNav("default"); ?>

    <div class="container-sphere">
        <div class="person">
            <div class="semi-sphere">
                <h2>Victor Hugo de Souza Santiago</h2><br>
                <p>Discente do IFBA Campus Seabra ingressado no ano de 2020.</p><br>
                <a href="https://www.github.com/nxrding-dev" target="_blank"><img title="Clique para acessar o GitHub" src="assets/Victor Hugo.jpg" alt="Foto da Pessoa 1" class="img-sobre" onerror="this.src='assets/person.png'" draggable="false"></a>
            </div>
        </div>

        <div class="person">
            <div class="semi-sphere">
                <h2>Rui Santos Carigé Júnior</h2><br>
                <p>Docente do Curso de Informática no IFBA - Campus Seabra e Orientador deste projeto.</p><br>
                <a href="http://lattes.cnpq.br/9841225286230930" target="_blank"><img title="Clique para acessar o GitHub" src="assets/rui.png" alt="Foto da Pessoa 2" class="img-sobre" onerror="this.src='assets/person.png'" draggable="false"></a>
            </div>
        </div>

        <div class="person">
            <div class="semi-sphere">
                <h2>Vitor César Batista de Souza</h2><br>
                <p>Discente do IFBA Campus Seabra ingressado no ano de 2020.</p><br>
                <a href="https://www.github.com/lordvitor11" target="_blank"><img title="Clique para acessar o GitHub" src="assets/vitor.jpg" alt="Foto da Pessoa 3" class="img-sobre" onerror="this.src='assets/person.png'" draggable="false"></a>
            </div>
        </div>
    </div>

    <div class="contact-form">
        <h1 class="contact-title">Entre em Contato</h1>
        <form action="process/contact_form.php" method="post">
            <label for="name">Nome:</label><br>
            <input type="text" id="name" name="name" required><br><br>

            <label for="email">E-mail:</label><br>
            <input type="email" id="email" name="email" required><br><br>

            <label for="message">Mensagem:</label><br>
            <textarea id="message" name="message" required></textarea><br><br>

            <button type="submit">Enviar</button>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>