<?php
require_once(__DIR__ . "/Model1.php");

class AgendamentoModel extends Model1
{
    // verificar se o  usuario agendou o almoço
    public function hasAgendamento($dia, $idUser)
    {
        $query = "SELECT COUNT(*) AS total FROM refeicao WHERE id_usuario = ? AND data_solicitacao = ? AND id_status_ref = 1";
        $resultado = $this->executeQuery($query, [$idUser, $dia], 'is');
        return $resultado[0]["total"] > 0;
    }

    // muda o status da refeição para confirmada
    public function retirarAlmoco($dia, $idUser)
    {
        $query = "UPDATE refeicao SET id_status_ref = 3 WHERE id_usuario = ? AND data_solicitacao = ? AND id_status_ref = 1";
        return $this->executeQuery($query, [$idUser, $dia], 'is');
    }
}

?>