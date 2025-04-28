<!DOCTYPE html>
 <html lang="pt-br">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="css/criar-cardapio.css">
     <script type="module" src="js/criar-cardapio.js" defer></script>
     <title>Criar Cardápio</title>
 </head>
 <body>
     <header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img class="img-logo" src='assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>
     <?php include_once("navbar.php"); ?>
         
     <h1 class='cabecalho-principal'>CARDÁPIO SEMANAL</h1>
     <table class='tabela-cardapio'>
         <thead>
         <tr>
             <th></th>
             <th>Proteína</th>
             <th>Principal</th>
             <th>Sobremesa</th>
         </tr>
         </thead>
         <tbody class='corpo-tabela-cardapio'></tbody>
     </table>
 
     <div class='janela-overlay' id='tagPopup'>
         <div class='janela-conteudo'>
         <h3 id='tagTitle'>Criar novo(a) tag</h3>
         <input class='campo-nome-tag' type='text' id='newTagName' placeholder='Nome da tag' required>
 
         <div class='area-restricoes'>
             <div class='grupo-opcoes'>
             <label class='radio-item'>
                 <input id='default' type='radio' name='restricao' value='' checked />
                 <span>Sem restrições</span>
             </label>
 
             <label class='radio-item'>
                 <input type='radio' name='restricao' value='Contém glúten' />
                 <span>Glúten</span>
             </label>
 
             <label class='radio-item'>
                 <input type='radio' name='restricao' value='Contém lactose' />
                 <span>Lactose</span>
             </label>
 
             <label class='radio-item'>
                 <input type='radio' name='restricao' value='Contém glúten e lactose' />
                 <span>Glúten e lactose</span>
             </label>
             </div>
         </div>
 
         <div class='grupo-botoes'>
             <button id='confirmCreate'>Criar</button>
             <button id='cancelCreate'>Cancelar</button>
         </div>
         </div>
     </div>
 
     <div class='mensagens-restricoes'>
         <div class='msg-alerta'>Sem restrições</div>
         <div class='msg-alerta'>Glúten</div>
         <div class='msg-alerta'>Lactose</div>
         <div class='msg-alerta'>Lactose e glúten</div>
     </div>
 
     <button id='save'>Salvar</button>
 
     <?php require_once "footer.php"; ?>
 </body>
 </html>