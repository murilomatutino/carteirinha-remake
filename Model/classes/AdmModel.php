<?php
require_once(__DIR__ . "/Model.php");

class AdmModel extends Model
{
    // Mudança de horário padrão
    public function editarHorario($hora) {
        date_default_timezone_set('America/Sao_Paulo');
        $dataHora = date("Y-m-d H:i:s");
        $query = "SELECT MAX(id) AS max_id FROM horario_padrao";
        $result = $this->executeQuery($query);
        $maxId = $result[0]['max_id'] ?? null;
    
        if ($maxId) {
            $this->executeUpdate("UPDATE horario_padrao SET fim_vig = ? WHERE id = ?", [$dataHora, $maxId], "si");
        }
    
        return $this->executeUpdate("INSERT INTO horario_padrao (horario, inicio_vig) VALUES (?, ?)", [$hora, $dataHora], "ss");
    }
}

?>