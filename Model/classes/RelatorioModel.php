<?php
    require_once(__DIR__ . "/Model.php");

    class RelatorioModel extends Model
    {
        // retorna as refeições que ainda estão agendadas em um determinado dia
        public function getRelatorioFaltas($day)
        {
            $query = "SELECT id_usuario, hora_solicitacao FROM refeicao where id_status_ref=1 AND data_solicitacao = ?";
            return $this->executeQuery($query, [$day], 's');
        }

        public function getNameById($id)
        {
            $query = "SELECT nome FROM usuario WHERE id = ?";
            $result = $this->executeQuery($query, [$id], 'i');
            return empty($result)? [] : $result[0];
        }

        // pega o cardapio em um determinado intervalo
        public function getCardapioByInterval($inicio, $fim)
        {
            $query = "SELECT date(data_hora_cardapio) as data_cardapio, dia, proteina, principal, sobremesa FROM cardapio WHERE  date(data_hora_cardapio) BETWEEN ? AND ?";
            $result = $this->executeQuery($query, [$inicio, $fim], 'ss');
            return empty($result)? [] : $result;
        }

    }
?>