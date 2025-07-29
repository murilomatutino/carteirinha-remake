<?php
    require_once(__DIR__ . "/Model.php");

    class NotificationModel extends Model
    {
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

        public function getTransferenciaData($idDestinatario)
        {
            date_default_timezone_set('America/Sao_Paulo');
            $dataAtual = date("Y-m-d");

            $query = "SELECT id_remetente FROM notificacao WHERE id_destinatario = ? AND data = ? AND transferencia = 1";
            $result = $this->executeQuery($query, [$idDestinatario, $dataAtual], 'is');

            return empty($result)? [] : $result[0]['id_remetente'];
        }

        public function isActive($idUser) {
            date_default_timezone_set('America/Sao_Paulo');
            $dataAtual = date("Y-m-d");
            $query = "SELECT COUNT(*) as total FROM refeicao WHERE id_usuario = ? AND data_solicitacao = ? AND id_status_ref = 1 AND motivo_cancelamento IS NULL";
            $result = $this->executeQuery($query, [$idUser, $dataAtual], "is");
            return $result && $result[0]['total'] > 0;
        }

        public function aceitarRefeicao($idDestinatario, $idRemetente)
        {
            // criar refeição para o destinatario
            date_default_timezone_set('America/Sao_Paulo');
            $dataSolicitacao = date("Y-m-d");
            $horaSolicitacao = date("H:i:s");

            $diaDaSemana = date('l', strtotime($dataSolicitacao));

            switch ($diaDaSemana) {
                case "Monday": $diaDaSemana = "Segunda-feira"; break;
                case "Tuesday": $diaDaSemana = "Terça-feira";  break;
                case "Wednesday": $diaDaSemana = "Quarta-feira";  break;
                case "Thursday": $diaDaSemana = "Quinta-feira";  break;
                case "Friday": $diaDaSemana = "Sexta-feira"; break;
                default: break;
            }

            $idCardapio = $this->getIdCardapio($diaDaSemana);
            if ($idCardapio === null){return false;}

            $result = $this->setMeal($idDestinatario, $idCardapio, 1, NULL, $dataSolicitacao, $horaSolicitacao, NULL);
            if ($result === false){return false;}

            $result = $this->changeNotificacaoType($idRemetente);
            if ($result === false){return false;}

            // mudar status da refeição do remetente para transferido
            $query = "UPDATE refeicao set id_status_ref = 5 WHERE id_usuario = ? AND data_solicitacao = ? AND id_status_ref = 1";
            return $this->executeUpdate($query, [$idRemetente, $dataSolicitacao], 'is');

        }

        public function changeNotificacaoType($idRemetente) 
        {
            date_default_timezone_set('America/Sao_Paulo');
            $dataAtual = date("Y-m-d");

            $query = "UPDATE notificacao set transferencia = 0  WHERE id_remetente = ? AND data = ? AND  transferencia = 1";
            return $this->executeUpdate($query, [$idRemetente, $dataAtual], 'is');
        }

        public function readNotification(int $idDestinatario, int $idNotification) {
            $query = "UPDATE notificacao SET lida = 1 WHERE id_destinatario = ? AND id = ?";
            return $this->executeUpdate($query, [$idDestinatario, $idNotification], "ii");
        }

        public function createNotificacao($idRemetente, $idAlvo, $assunto, $mensagem, $tipo)
        {
            date_default_timezone_set('America/Sao_Paulo');

            $data = date("Y-m-d");
            $hora = date("H:i:s");

            $query = "INSERT INTO notificacao (id_remetente, id_destinatario, data, hora, assunto, mensagem, lida, transferencia) VALUES (?, ?, ?, ?, ?, ?, DEFAULT, ?)";

            return $this->executeUpdate($query, [$idRemetente, $idAlvo, $data, $hora, $assunto, $mensagem, $tipo], 'iissssi');
        }

        public function getIdCardapio($diaDaSemana) {
            $query = "SELECT id FROM cardapio WHERE dia = ? AND ind_excluido = 0";
            $result = $this->executeQuery($query, [$diaDaSemana], "s");
            return $result ? $result[0]['id'] : null;
        }

        public function setMeal($idUser, $idCardapio, $statusRef, $idJustificativa, $dataSolicitacao, $horaSolicitacao, $justificativa) {
            $query = "INSERT INTO refeicao (id_usuario, id_cardapio, id_status_ref, id_justificativa, data_solicitacao, hora_solicitacao, outra_justificativa) VALUES (?, ?, ?, ?, ?, ?, ?)";
            return $this->executeUpdate($query, [$idUser, $idCardapio, $statusRef, $idJustificativa, $dataSolicitacao, $horaSolicitacao, $justificativa], "iiiisss");
        }

    }

?>