<?php 
    require_once(__DIR__ . '/../Controller/classes/CardapioController.php');
    $tags = (new CardapioController())->getTagsCardapio();

    foreach ($tags as &$tag) {
        if ($tag['lactose'] === 1 && $tag['gluten'] === 1) {
            $tag['restricoes'] = 'gluten-lactose ';
        } else if ($tag['lactose'] === 1 && $tag['gluten'] === 0) {
            $tag['restricoes'] = 'lactose';
        } else if ($tag['lactose'] === 0 && $tag['gluten'] === 1) {
            $tag['restricoes'] = 'gluten';
        } else {
            $tag['restricoes'] = 'sem-restricoes';
        }
    }

    function utf8ize($mixed) {
        if (is_array($mixed)) {
            foreach ($mixed as $key => $value) {
                $mixed[$key] = utf8ize($value);
            }
        } else if (is_string($mixed)) {
            return mb_convert_encoding($mixed, 'UTF-8', 'UTF-8');
        }
        
        return $mixed;
    }

    $tags = utf8ize($tags);
    $jsonTags = json_encode($tags, JSON_UNESCAPED_UNICODE);
?>

<!DOCTYPE html>
 <html lang="pt-br">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="css/criar-cardapio.css">
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
                 <input id='default' type='radio' name='restricao' value='SR' checked />
                 <span>Sem restrições</span>
             </label>
 
             <label class='radio-item'>
                 <input type='radio' name='restricao' value='G' />
                 <span>Glúten</span>
             </label>
 
             <label class='radio-item'>
                 <input type='radio' name='restricao' value='L' />
                 <span>Lactose</span>
             </label>
 
             <label class='radio-item'>
                 <input type='radio' name='restricao' value='GL' />
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

     <script>
        const tags = <?php echo $jsonTags; ?>;
     </script>
     <script type="module" src="js/criar-cardapio.js" defer></script>
 </body>
 </html>