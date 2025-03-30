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

    <main>
        <div class="form"> 
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

            <a href="#">Mudar senha</a>
        </div>
    </main>
    
    <?php include('footer.php')?>
</body>
</html>