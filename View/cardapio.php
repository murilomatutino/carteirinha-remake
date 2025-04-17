<?php session_start();
    require_once "../Controller/CardapioController.php";
    date_default_timezone_set('America/Sao_Paulo');

    $cardapio = (new CardapioController())->getCardapio();
    $horario_padrao = (new CardapioController())->getTime();
    $hasRefeicao = (new CardapioController())->hasRefeicao($_SESSION['id'], date("Y-m-d"));
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/cardapio.css">
    <script type="module" src="js/index.js" defer></script>
    <title>Cardapio Semanal</title>
</head>
<body>
    <header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img class="img-logo" src='assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>
    <?php include_once("navbar.php"); ?>
    
    <div class="container">
        <h1 class="titulo">CARDÁPIO SEMANAL</h1>
        <img src="assets/cozinheira.png" alt="Imagem do Boneco" class="image2" draggable="false">
        <table class="print-content">
            <?php
                if (isset($cardapio[0]) && $cardapio[0]['dia'] != '') {
                    echo "
                        <thead>
                            <tr>
                                <th>Dia</th>
                                <th>Proteína</th>
                                <th>Acompanhamento</th>
                                <th>Sobremesa</th>
                            </tr>
                        </thead>
                        <tbody>";

                    
                    foreach ($cardapio as $dia) {
                        if ($dia['principal'] != 'Sem refeição') {
                            $data = date("d/m", strtotime($dia['data_refeicao'])); 
                            $newDia = ucfirst($dia['dia']) . "-feira";
                            echo "<tr>";
                            echo "<td>$newDia ($data)</td>";
                        } else {
                            echo "<tr>";
                            echo "<td>{$dia['dia']}</td>";
                        }
                        echo "<td>{$dia['principal']}</td>";
                        echo "<td>{$dia['acompanhamento']}</td>";
                        echo "<td>{$dia['sobremesa']}</td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                }
            ?>
        </table>

        <template class='null-adm' id="cardapio-template">
            <h3 class='null'>O cardápio ainda está vazio. Adicione um agora</h3>
            <a href='cardapio-criar.php'><button class='button'>Adicionar cardápio</button></a>
        </template>

        <template class='null-user' id="cardapio-template">
            <h3 class='null'>O cardápio ainda está vazio. Aguarde por atualizações.</h3>
        </template>

        <template class='adm-template' id="cardapio-template">
            <div class='separador'>
                <div class='button-group'>
                    <button class="button-excluir">Excluir</button>
                    <button class='button-editar'>Editar</button>
                    <button class="button-imprimir">Imprimir Cardápio</button>
                    <!-- <button class='button-excluir' onclick='excluirCardapio()'>Excluir</button>
                    <button class='button-editar'>Editar</button>
                    <button class='button-imprimir' onclick='imprimirCardapio();'>Imprimir Cardápio</button> -->
                </div>
            </div>
        </template>

        <template class='user-template-agendado' id="cardapio-template">
            <a href='agendados.php'><button class='button agendado'>Minha Reserva</button></a>
        </template>

        <template class='user-template-out-time' id="cardapio-template">
            <span class='horario-limite'>Horário limite atingido!</span>
        </template>

        <template class='user-template-in-time' id="cardapio-template">
            <a href='cardapio-reserva.php'><button class='button'>Quero almoçar!</button></a>
        </template>

        <div class="overlay" id="overlay"></div>
        <div class="popup" id="popup">
            <h2>Reserva Confirmada!</h2>
            <p>Sua reserva foi confirmada com sucesso.</p>
        </div>

        <div class="info"></div>
    </div>
    <script>
        const agora = new Date();
        const horas = agora.getHours();
        const minutos = agora.getMinutes();
        const segundos = agora.getSeconds();

        const diaDaSemana = (new Date()).getDay();
        // const category = <?= json_encode($_SESSION['category']) ?>;  
        const cardapio = <?= json_encode($cardapio) ?>;
        const current_time = `${horas.toString().padStart(2, '0')}:${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')}`;
        const horario_padrao = <?= json_encode($horario_padrao) ?>;
        const hasRefeicao = <?= json_encode($hasRefeicao) ?>;

        console.log(current_time);

        if (category === 'adm' && cardapio.length > 0 && cardapio[0] !== '') { showTemplate(2); } 
        else if (category === 'adm' && (cardapio.length === 0 || cardapio[0]['dia'] === '')) { showTemplate(0); } 
        else if (category !== "adm" && (cardapio.length === 0 || cardapio[0]['dia'] === '')) { showTemplate(1); } 
        else {
            if (current_time >= horario_padrao || (diaDaSemana === 0 || diaDaSemana === 6)) { showTemplate(4); } 
            else { !hasRefeicao ? showTemplate(5) : showTemplate(3); }
        }

        function showTemplate(template) {
            const templates = document.querySelectorAll('#cardapio-template');
            const div = document.querySelector('.info');
            if (templates[template]) {
                div.innerHTML = templates[template].innerHTML;
            } else {
                console.log("Template não encontrado!");
            }
        }
    </script>
    <script type="module">
        import { showNotification } from './js/index.js';

        const params = new URLSearchParams(window.location.search);
        let response;
        let titulo;
        let desc;

        switch (true) {
            case params.has('agendamento'):
                response = {type: 'agendamento', data: params.get('agendamento') }; break;
            case params.has('cancelamento'):
                response = {type: 'cancelamento', data: params.get('cancelamento') }; break;
            case params.has('solicitacao'):
                response = {type: 'solicitacao', data: params.get('solicitacao') }; break;
            case params.has('feedback'):
                response = {type: 'feedback', data: params.get('feedback') }; break;
            case params.has('transferencia'):
                response = {type: 'transferencia', data: params.get('transferencia') }; break;
            default:
                response = { type: 'nenhum', data: null };
        }

        if (response.type === 'agendamento') {
            let feedback = false;
            if (response.data === 'success') { titulo = 'Refeição Agendada'; desc = 'Sua refeição foi agendada com sucesso!'; feedback = true }
            else if (response.data === 'emailerror'){titulo = 'Erro ao enviar e-mail'; desc = 'Sua refeição foi agendada com sucesso, mas houve um erro ao enviar um e-mail de confirmação.';}
            else { titulo = 'Problema na solicitação'; desc = 'Houve algum problema solicitação de agendamento do seu almoço. Por favor tente novamente mais tarde!'; }

            showNotification(titulo, desc, feedback);
        } else if (response.type === 'solicitacao') {
            if (response.data === 'success') { titulo = 'Sucesso na Solicitação', desc = 'Sua solicitação de transferência de reserva foi enviada ao estudante!' }
            else { titulo = 'Problema na solicitação'; desc = 'Houve um problema com a solicitação, que tal tentar novamente mais tarde?'}

            showNotification(titulo, desc);
        } else if (response.type === 'cancelamento') {
            if (response.data === 'success') { titulo = 'Sucesso no Cancelamento', desc = 'O cancelamento da sua refeição foi concluído!' }
            else { titulo = 'Problema no Cancelamento', desc = 'Houve um problema no cancelamento da sua refeição. Por favor, tente novamente mais tarde!' }

            showNotification(titulo, desc);
        } else if (response.type === 'feedback') {
            if (response.data === 'success') { titulo = 'Sucesso no feedback!', desc = 'Seu feedback foi enviaddo com sucesso para a nossa equipe!' }
            else { titulo = 'Problema no feedback!', desc = 'Houve um problema no envio do seu feedback. Por favor, tente novamente mais tarde!' }

            showNotification(titulo, desc);
        }
        else if (response.type === 'transferencia')
        {
            if (response.data === 'success') { titulo = 'Sucesso ao aceitar refeição!', desc = 'A refeição foi transferida para você'}
            else { titulo = 'Problema ao aceitar refeição!', desc = 'Houve um problema ao tentar aceitar a refeição. Por favor, tente novamente mais tarde!' }

            showNotification(titulo, desc);
        }
    </script>
    <?php require_once "footer.php"; ?>
</body>
</html>