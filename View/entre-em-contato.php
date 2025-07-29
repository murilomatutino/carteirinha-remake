<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entre em Contato</title>
    <link rel="stylesheet" href="css/entre-em-contato.css">
</head>
<body>
    <header class="session-1">
        <a href='https://portal.ifba.edu.br/seabra' target='_blank'>
            <img class="img-logo" src='assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'>
        </a>
    </header>
    <?php include_once("navbar.php"); ?>

    <main>
        
        <form method="post">

            <label for="message">
                Este é um espaço dedicado para você, estudante, relatar bugs no site, fazer sugestões 
                para melhorá-lo, expressar suas reclamações sobre o funcionamento do
                 site ou do cardápio oferecido. Sinta-se à vontade para compartilhar 
                 aquilo que você não gosta ou tem uma sugestão para melhorar.
            </label>

            <div>
                <label for="opcao">Tipo de contato:</label>
                <select name="opcao" id="opcao">
                    <option value="Crítica">Crítica</option>
                    <option value="Elogio" selected>Elogio</option>
                    <option value="Sugestão">Sugestão</option>
                    <option value="Reclamação">Reclamação</option>
                    <option value="Dúvida">Dúvida</option>
                </select>
            </div>
        
            <textarea id="message" name="message" required></textarea><br><br>

            <button type="submit">Enviar</button>
        </form>

        <?php
        if(!empty($_POST))
        {
            include("../Controller/ContatoController.php");

            $return = (new ContatoController())->sendEmailContact($_POST['message'], $_POST['opcao']);

            if ($return)
            {
                echo"
                <div id='popup-alerta'>
                    <div id='popup-alerta-close'>X</div>
                    <h1>E-mail enviado com sucesso</h1>
                    <p>O seu comentario foi enviado.</p>
                </div>";
            }
            else
            {
                echo"
                <div id='popup-alerta'>
                    <div id='popup-alerta-close'>X</div>
                    <h1>Erro ao enviar e-mail</h1>
                    <p>O seu comentario não foi enviado, por favor tente de novamente.</p>
                </div>";
            }
        }
        ?>
        
    </main>

    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="js/entre-em-contato.js"></script>
</body>
</html>