<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Início</title>
</head>
<body>
    <?php
        // if (isset($_GET['id'])) {
        //     $id = $_GET['id'];
            
        //     echo "<div class='popup-index'>";
        //     // echo "<script>showIndexPopup();</script>";
            
        //     if ($id == 0) { echo "<h2 class='popup-index-title'>Horário limite alterado!</h2>"; }
        //     else { echo "<h2 class='popup-index-title'>Erro ao alterar horário!</h2>"; }
        //     echo "</div>";
        // }
    ?>

    <header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img class="img-logo" src='assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>

    <?php include_once("navbar.php"); ?>

    <main class="session-2">
        <div>
            <img class="texto" src="assets/9e42d98494cc4cb687bf1f0012b58c06.png" alt="BEM-VINDO! EXPLORE E APROVEITE TODOS OS RECURSOS." draggable="false">
            <a href="cardapio.php">
                <button class="custom-button">CARDÁPIO</button>
            </a>
        </div>
        <div></div>
    </main>

    <main class="session-3">
        <div class="content">
            <h1 class="title">COMO SURGIU?</h1>
            <p class="text">O projeto da carteirinha digital iniciou-se em 2023 com o intuito de simplificar o processo de almoço na escola, proporcionando praticidade e controle aos alunos. Além disso, oferece segurança e eficiência para a instituição de ensino, tornando a experiência das refeições na escola muito mais conveniente e agradável.</p>
        </div>
    </main>

    <div class="image">
        <img src="assets/cozinheira.png" alt="Imagem do Boneco" class="image" draggable="false">
    </div>

    <div class="session-4"></div>

    <main class="session-5">
        <div class="menu-section">
            <div class="menu-title">CARDÁPIO?</div>

            <div class="separator"> <img src="assets/23fcc2516acc4eacad3a22096338e5a2.png" draggable="false" alt="none"> </div>
            
            <div class="menu-items">
                <div class="menu-item">
                <img src="assets/6da0cc15731a428a9e2cf1767f46190f.png" alt="Imagem do Almoço" class="menu-image" draggable="false">
                <div>
                    <div class="menu-name">Almoço</div>
                    <div class="separator"> <img src="assets/23fcc2516acc4eacad3a22096338e5a2.png" draggable="false" alt="none"> </div><br>
                    <div class="menu-info">
                    <p>Todo dia diversas opções diferentes.</p>
                    </div>
                </div>
                </div>
                
                <div class="menu-item">
                <img src="assets/7732604ec55c471e850c0151ec6b1697.png" alt="Imagem do Complemento" class="menu-image" draggable="false">
                <div>
                    <div class="menu-name">Complemento</div>
                    <div class="separator"> <img src="assets/23fcc2516acc4eacad3a22096338e5a2.png" draggable="false" alt="none"> </div><br>
                    <div class="menu-info">
                    <p>Diversas opções, como saladas e entre outros.</p>
                    </div>
                </div>
                </div>
                
                <div class="menu-item">
                <img src="assets/d362a44164f44a24bbb327a5d7208dd6.png" alt="Imagem da Sobremesa" class="menu-image" draggable="false">
                <div>
                    <div class="menu-name">Sobremesa</div>
                    <div class="separator2"> <img src="assets/23fcc2516acc4eacad3a22096338e5a2.png" draggable="false" alt="none"> </div><br>
                    <div class="menu-info">
                    <p>Ótimos acompanhamentos para a sua refeição.</p>
                  </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>