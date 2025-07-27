<?php
require_once '../../Model/connect.php';

// importando código para manipular as planilhas
require_once '../../libs/planilhas/vendor/autoload.php';
require_once '../config.php';
  
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

if (isset($_POST['submit'])) {
  
    $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      
    if(isset($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {
        $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
      
        if('csv' == $extension) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else if ($extension == 'xls')
        {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        }else{
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
  
        $spreadsheet = $reader->load($_FILES['file']['tmp_name']); 
  
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
  
        if (!empty($sheetData)) {
            for ($i=1; $i<count($sheetData); $i++) { 
                $matricula = $sheetData[$i][1];
                $matricula = $conn->real_escape_string($matricula);

                $nome = $sheetData[$i][2];
                $nome = $conn->real_escape_string($nome);

                //$email = $sheetData[$i][3];
                //$email = $conn->real_escape_string($email);
                $email = "Sem e-mail cadastrado";

                //$telefone = $sheetData[$i][4];
                //$telefone = $conn->real_escape_string($telefone);
                $telefone = "Sem telefone cadastrado";

                $sql = sprintf("INSERT INTO usuario (nome, email, matricula, senha, categoria, telefone) VALUES('%s', '%s', '%d', md5('%s'), 'estudante', '%s')", $nome, $email, $matricula, $matricula . "ifba", $telefone);
                $conn->query($sql);

                echo $matricula . "  " . $nome . "<br>";
            }
        }
        echo "Usuarios adicionados com sucesso.";
    } else {
        echo "Carregue um arquivo CSV ou Exel";
    }
}
?>