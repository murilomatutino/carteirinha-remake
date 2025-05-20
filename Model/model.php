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
        if ($params) { $stmt->bind_param($types, ...$params); }

        if (!$stmt->execute()) { return false; }

        if (stripos(trim($query), "SELECT") === 0) {
            $result = $stmt->get_result();
            return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        }

        return $stmt->affected_rows;
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
        $query = "SELECT dia, data_hora_cardapio, proteina, principal, sobremesa FROM cardapio WHERE ind_excluido = 0 ORDER BY data_hora_cardapio";
        return $this->executeQuery($query);
    }

    public function getTime() {
        $query = "SELECT horario FROM horario_padrao WHERE fim_vig IS NULL";
        $result = $this->executeQuery($query);
        return $result ? $result[0]['horario'] : '';
    }

    public function hasRefeicao(int $idUser, string $diaAtual) {
        $query = "SELECT COUNT(*) as total FROM refeicao WHERE id_usuario = ? AND data_solicitacao = ? AND motivo_cancelamento IS NULL AND id_status_ref = 1";
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
        $query = "UPDATE refeicao SET motivo_cancelamento = ?, id_status_ref = 2 WHERE id_usuario = ? AND motivo_cancelamento IS NULL ORDER BY data_solicitacao DESC LIMIT 1";
        return $this->executeUpdate($query, [$motivo, $idUser], "si");
    }

    public function adicionarFeedback($nota, $idUser, $idCardapio) {
        $query = "INSERT INTO feedback (id_usuario, id_cardapio, id_nota) VALUES (?, ?, ?)";
        return $this->executeUpdate($query, [$idUser, $idCardapio, $nota], "iii");
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
        date_default_timezone_set('America/Sao_Paulo');
        $dataAtual = date("Y-m-d");

        $query = "SELECT * FROM refeicao WHERE id_usuario = ? AND motivo_cancelamento IS NULL AND data_solicitacao = ? AND id_status_ref = 1";
        $result = $this->executeQuery($query, [$idUser, $dataAtual], 'is');

        return empty($result)? [] : $result[0];
    }
    
    public function getCardapioById($idCardapio) {
        $query = "SELECT data_hora_cardapio, dia, proteina, principal, sobremesa FROM cardapio WHERE id = ?";
        $result = $this->executeQuery($query, [$idCardapio], 'i');

        return $result[0];
    }

    public function excluirCardapio() {
        $query = "UPDATE cardapio SET ind_excluido = 1 WHERE ind_excluido = 0";
        $result = $this->executeQuery($query);

        return $result !== false;
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

    /* Transferencia de almoço */

    public function getIdByMatricula($matricula)
    {
        $query = "SELECT id FROM usuario WHERE matricula = ?";
        $result = $this->executeQuery($query, [$matricula], 'i');

        return $result == null ?  false : $result[0]['id'] ;
    }

    public function createNotificacao($idRemetente, $idAlvo, $assunto, $mensagem, $tipo)
    {
        date_default_timezone_set('America/Sao_Paulo');

        $data = date("Y-m-d");
        $hora = date("H:i:s");

        $query = "INSERT INTO notificacao (id_remetente, id_destinatario, data, hora, assunto, mensagem, lida, transferencia) VALUES (?, ?, ?, ?, ?, ?, DEFAULT, ?)";

        return $this->executeUpdate($query, [$idRemetente, $idAlvo, $data, $hora, $assunto, $mensagem, $tipo], 'iissssi');
    }


    public function aceitarRefeicao($idDestinatario, $idRemetente)
    {
        // criar refeição para o destinatario
        date_default_timezone_set('America/Sao_Paulo');
        $dataSolicitacao = date("Y-m-d");
        $horaSolicitacao = date("H:i:s");

        $diaDaSemana = date('l', strtotime($dataSolicitacao));

        switch ($diaDaSemana) {
            case "Monday": $diaDaSemana = "segunda"; break;
            case "Tuesday": $diaDaSemana = "terca";  break;
            case "Wednesday": $diaDaSemana = "quarta";  break;
            case "Thursday": $diaDaSemana = "quinta";  break;
            case "Friday": $diaDaSemana = "sexta"; break;
            default: break;
        }

        $idCardapio = $this->getIdCardapio($diaDaSemana);
        if ($idCardapio === null){return false;}

        $result = $this->setMeal($idDestinatario, $idCardapio, 1, 5, $dataSolicitacao, $horaSolicitacao, NULL);
        if ($result === false){return false;}

        $result = $this->changeNotificacaoType($idRemetente);
        if ($result === false){return false;}

        // mudar status da refeição do remetente para transferido
        $query = "UPDATE refeicao set id_status_ref = 5 WHERE id_usuario = ? AND data_solicitacao = ? AND id_status_ref = 1";
        return $this->executeUpdate($query, [$idRemetente, $dataSolicitacao], 'is');

    }

    public function getTransferenciaData($idDestinatario)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $dataAtual = date("Y-m-d");

        $query = "SELECT id_remetente FROM notificacao WHERE id_destinatario = ? AND data = ? AND transferencia = 1";
        $result = $this->executeQuery($query, [$idDestinatario, $dataAtual], 'is');

        return empty($result)? [] : $result[0]['id_remetente'];
    }

    /**
     * Transforma uma notificação de almoço em um notificação normal
     * @param mixed $idRemetente
     * @return bool
     */
    public function changeNotificacaoType($idRemetente) 
    {
        date_default_timezone_set('America/Sao_Paulo');
        $dataAtual = date("Y-m-d");

        $query = "UPDATE notificacao set transferencia = 0  WHERE id_remetente = ? AND data = ? AND  transferencia = 1";
        return $this->executeUpdate($query, [$idRemetente, $dataAtual], 'is');
    }

    // retornar horário limite da transferencia de almoço
    public function getHorarioLimiteTransferencia()
    {
        date_default_timezone_set('America/Sao_Paulo');

        $horario_limite = date("Y-m-d") . " " .$this->getTime();

        $query = "SELECT ADDTIME(?, '4:00:00')";
        $result = $this->executeQuery($query, [$horario_limite], 's');

        return $result[0]["ADDTIME(?, '4:00:00')"];
    }

    public function getAllFeedback() {
        $query = "SELECT * FROM feedback";
        return $this->executeQuery($query);
    }

    // buscar mais detalhes do feedback
    public function getFeedbackDetails($idCardapio) {
        $query = "SELECT 
            f.id AS id,
            u.nome AS nome,
            u.matricula AS matricula,
            f.id_nota,
            f.comentario,
            c.*
            FROM 
            feedback f
            JOIN 
            cardapio c ON f.id_cardapio = c.id
            JOIN 
            usuario u ON f.id_usuario = u.id
            WHERE 
            f.id_cardapio = ?;
            ";

        $result = $this->executeQuery($query, [$idCardapio], 'i');
        // $result = $this->executeQuery($query);
        return $result;
    }

    // buscar tags para criação do cardapio
    public function getTagsCardapio() {
        $query = "SELECT * FROM tags_cardapio";
        return $this->executeQuery($query);
    }

    // criar tag
    public function criarTag($nome, $tipo, $gluten, $lactose) {
        $query = "INSERT INTO tags_cardapio (nome, tipo, gluten, lactose) VALUES (?, ?, ?, ?)";
        return $this->executeQuery($query, [$nome, $tipo, $gluten, $lactose], 'ssii');
    }

    // Cadastra cardápio no BD
    public function criarCardapio($dia, $proteina, $principal, $sobremesa) {
        $query = "INSERT INTO cardapio (dia, proteina, principal, sobremesa) VALUES (?, ?, ?, ?)";
        return $this->executeQuery($query, [$dia, $proteina, $principal, $sobremesa], 'ssss');
    }

    public function salvarCardapioSemana($dados) {
        $success = [];

        // print_r($dados); exit();
        // Verifica se o array está vazio   

        foreach ($dados as $linha) {
            $dia = $linha['dia'] ?? '';
            $proteina = $linha['Proteína'] ?? '';
            $principal = $linha['Principal'] ?? '';
            $sobremesa = $linha['Sobremesa'] ?? '-';
            
            $sucesso = $this->criarCardapio($dia, $proteina, $principal, $sobremesa);
            $sucess[] = $sucesso;
        }

        // print_r($success); exit();
        return in_array(false, $sucess, true) ? false : true;
    }
}
?>
