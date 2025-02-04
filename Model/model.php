<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
    class Model {
        public $conn;
        public function __construct() {
            global $conn;
            require("connect.php");
            $this->conn = $conn;
        }

        public function login($matricula, $pass) {
            $stmt = $this->conn->prepare("SELECT senha FROM usuario WHERE matricula = ?");
            $stmt->bind_param("s", $matricula);
            $stmt->execute();
            $stmt->store_result();
            
            if ($stmt->num_rows > 0) {
                // Buscar o hash da senha
                $stmt->bind_result($hashedPassword);
                $stmt->fetch();

                if ($hashedPassword === md5($pass)) {
                    return true;
                }
            }
            
            return false;
        }

        public function getDataByMatricula($matricula) {
            $stmt = $this->conn->prepare("SELECT id, nome, email, matricula, categoria FROM usuario WHERE matricula = ?");
            $stmt->bind_param("s", $matricula);
            $stmt->execute();
            $stmt->store_result();
            
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $nome, $email, $matricula, $categoria);
                $stmt->fetch();
                return [
                    'id' => $id,
                    'nome' => $nome,
                    'email' => $email,
                    'matricula' => $matricula,
                    'categoria' => $categoria
                ];
            }
            
            return false;
        }
        
        public function hasNotification(int $userId) {
            $sql = "SELECT COUNT(*) FROM notificacao WHERE id_destinatario = ? AND lida = 0";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            
            $resultado = $stmt->get_result();
            $num = $resultado->fetch_row()[0];
        
            return $num > 0;
        }

        public function getCardapio() {
            $sql = "SELECT dia, data_refeicao, principal, acompanhamento, sobremesa FROM cardapio WHERE ind_excluido = 0 ORDER BY data_refeicao";
            $result = $this->conn->query($sql);
            
            $cardapio = array_fill(0, 5, [
                "dia" => '',
                "data" => '',
                "principal" => '-',
                "acompanhamento" => '-',
                "sobremesa" => '-'
            ]);
        
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $diaIndex = match ($row['dia']) {
                        "segunda" => 0,
                        "terca" => 1,
                        "quarta" => 2,
                        "quinta" => 3,
                        "sexta" => 4,
                        default => null,
                    };
                    if ($diaIndex !== null) {
                        $cardapio[$diaIndex] = [
                            "dia" => ucfirst($row['dia']),
                            "data" => $row['data_refeicao'],
                            "principal" => $row['principal'],
                            "acompanhamento" => $row['acompanhamento'],
                            "sobremesa" => $row['sobremesa']
                        ];
                    }
                }
            }
        
            return $cardapio;
        }

        public function getTime() {
            $sql = "SELECT horario FROM horario_padrao WHERE fim_vig IS NULL";
            $result = $this->conn->query($sql);
            
            return $result->num_rows > 0 ? $result->fetch_assoc()['horario'] : '';
        }

        public function hasRefeicao(int $idUser, string $diaAtual): bool {
            $sql = "SELECT COUNT(*) FROM refeicao WHERE id_usuario = ? AND data_solicitacao = ? AND motivo_cancelamento IS NULL";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("is", $idUser, $diaAtual);
            $stmt->execute();
            
            $resultado = $stmt->get_result();
            $num = $resultado->fetch_row()[0];
        
            return $num > 0;
        }

        public function getAssunto(int $userId) {
            $sql = "SELECT assunto FROM notificacao WHERE id_destinatario = ?";
            $stmt = $this->conn->prepare($sql);
            
            if ($stmt === false) {
                throw new Exception('Erro ao preparar a consulta: ' . $this->conn->error);
            }
            
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $stmt->bind_result($assunto);
            
            $assuntos = [];
            while ($stmt->fetch()) {
                $assuntos[] = $assunto;
            }
            
            $stmt->close();
            return $assuntos;
        }

        public function getIdCardapio($diaDaSemana) {
            $sql = "SELECT id FROM cardapio WHERE dia = '$diaDaSemana' AND ind_excluido = 0";
            $result = $this->conn->query($sql);
            $row = $result->fetch_assoc();
            return $row['id'];
        }

        public function setMeal($idUser, $idCardapio, $statusRef, $idJustificativa, $dataSolicitacao, $horaSolicitacao, $justificativa) {
            $justificativa = $justificativa ?: null; // Define como null se estiver vazia
        
            $sql = "INSERT INTO refeicao (id_usuario, id_cardapio, id_status_ref, id_justificativa, data_solicitacao, hora_solicitacao, outra_justificativa)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
        
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iiissss", $idUser, $idCardapio, $statusRef, $idJustificativa, $dataSolicitacao, $horaSolicitacao, $justificativa);
            
            if ($stmt->execute()) {
                return ['status' => true, 'message' => 'success'];
            } else {
                return ['status'=> false,'message'=> 'error'];
            }
        }

        private function getUserDataForTransfer($matriculaAlvo, $idRemetente) {
            $sql = "
                (SELECT id, nome, matricula, 'remetente' AS tipo FROM usuario WHERE id = ?)
                UNION ALL
                (SELECT id, nome, matricula, 'destinatario' AS tipo FROM usuario WHERE matricula = ?)
            ";
            
            $stmt = $this->conn->prepare($sql);
        
            if ($stmt) {
                $stmt->bind_param('is', $idRemetente, $matriculaAlvo);
                $stmt->execute();
                $result = $stmt->get_result();
        
                $usersData = [];
                while ($row = $result->fetch_assoc()) {
                    $usersData[$row['tipo']] = [$row['id'], $row['nome'], $row['matricula']];
                }
        
                $stmt->close();
                return $usersData;
            }
        
            return [];
        }        

        public function isActive($idUser) {
            $dataAtual = date("Y-m-d");
            $sql = "SELECT COUNT(*) FROM refeicao WHERE id_usuario = ? AND id_status_ref = 1 AND data_solicitacao = ? AND motivo_cancelamento IS NULL";
            $stmt = $this->conn->prepare($sql);
        
            if ($stmt) {
                $stmt->bind_param('is', $idUser,  $dataAtual);
                $stmt->execute();
                $stmt->bind_result($quantidade);
                $stmt->fetch();
                $stmt->close();
        
                return $quantidade > 0;  
            } else {
                return false;
            }
        }

        public function transferenciaIsActive($idUser) {
            $sql = "SELECT COUNT(*) FROM notificacao WHERE id_remetente = ? AND data = ? AND transferencia = 1";
            $stmt = $this->conn->prepare($sql);
            $dataAtual = date("Y-m-d");

            if ($stmt) {
                $stmt->bind_param('is', $idUser, $dataAtual);
                $stmt->execute();
                $stmt->bind_result($quantidade);
                $stmt->fetch();
                $stmt->close();

                return $quantidade > 0;
            }

            return false;
        } 

        public function cancelarReserva($idUser, $motivo) {
            $sql = "UPDATE refeicao SET motivo_cancelamento = ? WHERE id_usuario = ? AND motivo_cancelamento IS NULL ORDER BY data_solicitacao DESC LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('si', $motivo, $idUser);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    return true;                    
                }
                return false;
            } else {
                return false;
            }
        }

        public function transferirReserva($idUser, $motivo, $matriculaAlvo) {
            // Obter dados do remetente e destinatário
            $usersData = $this->getUserDataForTransfer($matriculaAlvo, $idUser);
        
            if (!isset($usersData['remetente']) || !isset($usersData['destinatario'])) {
                return ['success' => false, 'message' => 'Usuários não encontrados.'];
            }
        
            $idRemetente = $usersData['remetente'][0];
            $nomeRemetente = ucfirst($usersData['remetente'][1]);
        
            $idDestinatario = $usersData['destinatario'][0];
            $nomeDestinatario = ucfirst($usersData['destinatario'][1]);
        
            $assunto = "Transferência de Almoço";
            $mensagem = "Saudações $nomeDestinatario, o estudante $nomeRemetente fez a você uma solicitação de transferência de almoço!\n\nMotivo: $motivo";
            $sql = "INSERT INTO notificacao (id_remetente, id_destinatario, assunto, mensagem, transferencia) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
        
            if ($stmt) {
                $transferencia = 1;
                $stmt->bind_param('iissi', $idRemetente, $idDestinatario, $assunto, $mensagem, $transferencia);
                
                if ($stmt->execute()) {
                    $stmt->close();
                    return ['success' => true, 'message' => 'Notificação enviada com sucesso!'];
                } else {
                    $stmt->close();
                    return ['success' => false, 'message' => 'Erro ao enviar a notificação.'];
                }
            } else {
                return ['success' => false, 'message' => 'Erro ao preparar a consulta.'];
            }
        }   

        public function getTransferenciaData($idUser) {
            $sql = 'SELECT id_remetente, id_destinatario FROM notificacao WHERE id_destinatario = ? AND transferencia = 1';
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('i', $idUser);
            $stmt->execute();
            $stmt->bind_result($idRemetente, $idDestinatario);
            $stmt->fetch();
            $stmt->close();
            return $idRemetente;
        }
        
        public function aceitarRefeicao($idDestinatario, $idRemetente) {
            $dataAtual = date("Y-m-d");
            $sql = "UPDATE refeicao SET id_usuario = ? WHERE id_usuario = ? AND data_solicitacao = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iis", $idDestinatario, $idRemetente, $dataAtual);

            if ($stmt->execute()) {
                $sqlNoti = "UPDATE notificacao SET lida = 1, transferencia = 2 WHERE id_destinatario = ? AND id_remetente = ? AND transferencia = 1 AND data = ?";

                $stmtNoti = $this->conn->prepare($sqlNoti);
                $stmtNoti->bind_param("iis", $idDestinatario, $idRemetente, $dataAtual);

                if ($stmtNoti->execute()) {
                    return ["status" => true, "message" => "Reserva transferida com sucesso!"];
                } else {
                    return ["status" => false, "message" => "Erro ao atualizar a notificação: " . $this->conn->error]; 
                }
            } else {
                return ["status" => false, "message" => "Erro ao atualizar a reserva: " . $this->conn->error];
            }
        }
    }
?>