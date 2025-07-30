<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/perfil.css">
    <title>Perfil</title>
</head>
<body>
    <header class="session-1">
        <a href='https://portal.ifba.edu.br/seabra' target='_blank'>
            <img class="img-logo" src='assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'>
        </a>
    </header>

    <?php include('navbar.php')?>

    <main id="pai">
        <div class="form" id="infos"> 
            <h1 class="titulo-principal">Perfil</h1>
            <div>
                <label>Nome</label>
                <div class="input transbordamento"><?php echo $_SESSION['name']?></div>
            </div> 

            <div>
                <label>Matricula</label>
                <div class="input transbordamento"><?php echo $_SESSION['enrollment']?></div>
            </div> 

            <div>
                <label>Email</label>
                <div class="input transbordamento"><?php echo $_SESSION['email']?></div>
            </div> 

            <div>
                <label>Telefone</label>
                <div class="input transbordamento"><?php echo $_SESSION['telefone']?></div>
            </div>

            <a href="#" id="link-mudar-senha">Mudar senha</a>
        </div>

        <div id="popup-perfil-wrapper">
            <form class="form"  method="post" action="perfil.php">
                <div id="popup-perfil-close">X</div>
                <div>
                    <label for="senha">Senha nova</label>
                    <input type="password" class="input" name="senha" id="senha" minlength="8" required>
                </div>

                <div>
                    <label for="confirmacao">Confirmação</label>
                    <input type="password" class="input" name="confirmacao" id="confirmacao" minlength="8" required>
                </div>

                
                <button type="submit">Alterar senha</button>

            </form>
        </div>

        <?php
            if(isset($_POST['senha']) && isset($_POST['confirmacao']))
            {
                if($_POST["senha"] !== $_POST["confirmacao"]) // emite um popup de alerta
                {
                    echo "
                    <div id='popup-alerta' class='form'>
                        <div id='popup-alerta-close'>X</div>
                        <h1>Senhas Diferentes</h1>
                        <p>Digite as senhas novamente</p>
                    </div>
                    ";
                }
                else
                {
                    include("../Controller/classes/PerfilController.php");

                    $object = new PerfilController();

                    $return = $object->setPassword($_POST["senha"], $_SESSION["id"]);

                    if($return) // emite um popup de sucesso
                    {
                        echo "
                        <div id='popup-alerta' class='form'>
                            <div id='popup-alerta-close'>X</div>
                            <h1>Senha alterada!</h1>
                            <p>A sua senha foi alterada com sucesso.</p>
                        </div>
                        ";
                    }
                    else // emite um popup de erro
                    {
                        echo "
                        <div id='popup-alerta' class='form'>
                            <div id='popup-alerta-close'>X</div>
                            <h1>Erro!</h1>
                            <p>Ocorreu um erro ao tentar alterar a sua senha.</p>
                        </div>
                        ";
                    }
                }
            }
        ?>
        
    </main>
    
    <?php include('footer.php')?>

    <script src="./js/perfil.js" type="text/javascript"></script>
</body>
</html>