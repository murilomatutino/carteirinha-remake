<?php
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
    }
?>