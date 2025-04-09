<?php
    session_start();
    if ($_SESSION['category'] !== 'adm'){exit();} // evita imprimir o cardapio caso o usuario não seja um adm

    require_once '../libs/dompdf/vendor/autoload.php';
    require_once "../Controller/CardapioController.php";


    $cardapio = (new CardapioController())->getCardapio();


    $arquivo ='
    <!DOCTYPE html>
    <html>
    <head>
        <title>Cardapio Semanal</title>
        <style>
            body
            { font-family: Arial, Helvetica, sans-serif;}
            th, td, table{padding: 20px;border:  2px  black solid;border-radius: 5px;background-color: white;}
            th{background-color: rgb(1, 80, 1); color: white;}
        </style>
    </head>
    <body style="display: flex; flex-direction: column; align-items: center;">
    <table style="width: 900px; background-color: green;">
    <thead>
        <tr>
            <th>Dia</th>
            <th>Proteína</th>
            <th>Acompanhamento</th>
            <th>Sobremesa</th>
        </tr>
    </thead>
    <tbody>';
    
    foreach ($cardapio as $dia) {
        if ($dia['principal'] != 'Sem refeição') {
            $data = date("d/m", strtotime($dia['data_refeicao'])); 
            $newDia = ucfirst($dia['dia']) . "-feira";
            
            $arquivo .= "<tr>";
            $arquivo .= "<td>$newDia ($data)</td>";
        } else {
            $arquivo .= "<tr>";
            $arquivo .=  "<td>{$dia['dia']}</td>";
        }
        $arquivo .= "<td>{$dia['principal']}</td>";
        $arquivo .= "<td>{$dia['acompanhamento']}</td>";
        $arquivo .= "<td>{$dia['sobremesa']}</td>";
        $arquivo .= "</tr>";
    }

    $arquivo .= "</tbody></table>";

    $arquivo .= '</body></html>';

    /* parte responsavel por gerar o pdf */ 
    use Dompdf\Dompdf;

    $dompdf = new Dompdf();

    $dompdf->loadHtml($arquivo); 

    $dompdf->setPaper('A4', 'landscape'); // tamanho do pdf

    // renderiza o html
    $dompdf->render();

    // mostra o pdf
    $dompdf->stream("cardapio.pdf");
?>