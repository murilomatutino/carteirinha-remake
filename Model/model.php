<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

class Model {
    public $conn;

    public function __construct() {
        require("connect.php");
        $this->conn = $conn;
    }

    private function executeQuery($query, $params = [], $types = "") {
        $stmt = $this->conn->prepare($query);
        if ($params) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    private function executeUpdate($query, $params = [], $types = "") {
        $stmt = $this->conn->prepare($query);
        if ($params) {
            $stmt->bind_param($types, ...$params);
        }
        $success = $stmt->execute();
        return $success ? $stmt->affected_rows > 0 : false;
    }

    public function login($matricula, $pass) {
        $query = "SELECT senha FROM usuario WHERE matricula = ?";
        $result = $this->executeQuery($query, [$matricula], "s");
        return $result && md5($pass) === $result[0]['senha'];
    }

    public function getDataByMatricula($matricula) {
        $query = "SELECT id, nome, email, matricula, categoria, telefone FROM usuario WHERE matricula = ?";
        $result = $this->executeQuery($query, [$matricula], "s");
        return $result ? $result[0] : false;
    }

    public function hasNotification(int $userId) {
        $query = "SELECT COUNT(*) as total FROM notificacao WHERE id_destinatario = ?";
        $result = $this->executeQuery($query, [$userId], "i");
        return $result && $result[0]['total'] > 0;
    }

    public function hasNewNotification(int $userId) {
        $query = "SELECT COUNT(*) as total FROM notificacao WHERE id_destinatario = ? AND lida = 0";
        $result = $this->executeQuery($query, [$userId], "i");
        return $result && $result[0]['total'] > 0;
    }

    public function getNotification(int $userId, $idNotification = null) {
        $query = "SELECT * FROM notificacao WHERE id_destinatario = ?";
        $params = [$userId];
        $types = "i";

        if ($idNotification) {
            $query .= " AND id = ?";
            $params[] = $idNotification;
            $types .= "i";
        }

        return $this->executeQuery($query, $params, $types);
    }

    public function readNotification(int $idDestinatario, int $idNotification) {
        $query = "UPDATE notificacao SET lida = 1 WHERE id_destinatario = ? AND id = ?";
        return $this->executeUpdate($query, [$idDestinatario, $idNotification], "ii");
    }

    public function getCardapio() {
        $query = "SELECT dia, data_refeicao, principal, acompanhamento, sobremesa FROM cardapio WHERE ind_excluido = 0 ORDER BY data_refeicao";
        return $this->executeQuery($query);
    }

    public function getTime() {
        $query = "SELECT horario FROM horario_padrao WHERE fim_vig IS NULL";
        $result = $this->executeQuery($query);
        return $result ? $result[0]['horario'] : '';
    }

    public function hasRefeicao(int $idUser, string $diaAtual) {
        $query = "SELECT COUNT(*) as total FROM refeicao WHERE id_usuario = ? AND data_solicitacao = ? AND motivo_cancelamento IS NULL";
        $result = $this->executeQuery($query, [$idUser, $diaAtual], "is");
        return $result && $result[0]['total'] > 0;
    }

    public function getIdCardapio($diaDaSemana) {
        $query = "SELECT id FROM cardapio WHERE dia = ? AND ind_excluido = 0";
        $result = $this->executeQuery($query, [$diaDaSemana], "s");
        return $result ? $result[0]['id'] : null;
    }

    public function setMeal($idUser, $idCardapio, $statusRef, $idJustificativa, $dataSolicitacao, $horaSolicitacao, $justificativa) {
        $query = "INSERT INTO refeicao (id_usuario, id_cardapio, id_status_ref, id_justificativa, data_solicitacao, hora_solicitacao, outra_justificativa) VALUES (?, ?, ?, ?, ?, ?, ?)";
        return $this->executeUpdate($query, [$idUser, $idCardapio, $statusRef, $idJustificativa, $dataSolicitacao, $horaSolicitacao, $justificativa], "iiissss");
    }

    public function cancelarReserva($idUser, $motivo) {
        $query = "UPDATE refeicao SET motivo_cancelamento = ? WHERE id_usuario = ? AND motivo_cancelamento IS NULL ORDER BY data_solicitacao DESC LIMIT 1";
        return $this->executeUpdate($query, [$motivo, $idUser], "si");
    }

    public function adicionarFeedback($nota, $idUser) {
        $query = "INSERT INTO feedback (id_usuario, nota) VALUES (?, ?)";
        return $this->executeUpdate($query, [$idUser, $nota], "ii");
    }

    public function isActive($idUser) {
        date_default_timezone_set('America/Sao_Paulo');
        $dataAtual = date("Y-m-d");
        $query = "SELECT COUNT(*) as total FROM refeicao WHERE id_usuario = ? AND data_solicitacao = ? AND id_status_ref = 1 AND motivo_cancelamento IS NULL";
        $result = $this->executeQuery($query, [$idUser, $dataAtual], "is");
        return $result && $result[0]['total'] > 0;
    }

    public function transferenciaIsActive($idUser) {
        date_default_timezone_set('America/Sao_Paulo');
        $dataAtual = date("Y-m-d");
        $query = "SELECT COUNT(*) as total FROM notificacao WHERE id_remetente = ? AND data = ? AND transferencia = 1";
        $result = $this->executeQuery($query, [$idUser, $dataAtual], "is");
        return $result && $result[0]['total'] > 0;
    }

    public function getRefeicaoById($idUser) {
        $query = "SELECT * FROM refeicao WHERE id_usuario = ? AND motivo_cancelamento IS NULL";
        $result = $this->executeQuery($query, [$idUser], 'i');

        return $result[0];
    }
    
    public function getCardapioById($idCardapio) {
        $query = "SELECT data_refeicao, dia, principal, acompanhamento, sobremesa FROM cardapio WHERE id = ?";
        $result = $this->executeQuery($query, [$idCardapio], 'i');

        return $result[0];
    }

    public function excluirCardapio() {
        $query = "UPDATE cardapio SET ind_excluido = 1 WHERE ind_excluido = 0";
        $result = $this->executeQuery($query);

        if ($result === TRUE) {
            return ['success' => true];
        } else {
            return ['success' => false];
        }
    }


    /* Mudança de senha - métodos necessarios */

    public function setPassword($newPassword, $idUser)
    {
        $query = "UPDATE usuario SET senha = md5(?) WHERE id = ?";
        return $this->executeUpdate($query, [$newPassword, $idUser], "si");
    }

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
