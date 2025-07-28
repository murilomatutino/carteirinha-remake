<?php
    require_once(__DIR__ . "/Model.php");

    class CardapioModel extends Model
    {
        public function getCardapio() {
        $query = "
            SELECT 
                dia,
                data_refeicao,
                data_hora_cardapio,
                (SELECT JSON_OBJECT('nome', t.nome, 'gluten', t.gluten, 'lactose', t.lactose)
                FROM tags_cardapio t 
                WHERE t.nome = c.proteina LIMIT 1) AS proteina,

                (SELECT JSON_OBJECT('nome', t.nome, 'gluten', t.gluten, 'lactose', t.lactose)
                FROM tags_cardapio t 
                WHERE t.nome = c.principal LIMIT 1) AS principal,

                CASE
                    WHEN c.sobremesa = '-' THEN NULL
                    ELSE (SELECT JSON_OBJECT('nome', t.nome, 'gluten', t.gluten, 'lactose', t.lactose)
                        FROM tags_cardapio t 
                        WHERE t.nome = c.sobremesa LIMIT 1)
                END AS sobremesa

            FROM cardapio c
            WHERE c.ind_excluido = 0
            ORDER BY c.id
        ";
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
            $query = "SELECT data_hora_cardapio, data_refeicao,dia, proteina, principal, sobremesa FROM cardapio WHERE id = ?";
            $result = $this->executeQuery($query, [$idCardapio], 'i');

            return $result[0];
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

        public function isActive($idUser) {
            date_default_timezone_set('America/Sao_Paulo');
            $dataAtual = date("Y-m-d");
            $query = "SELECT COUNT(*) as total FROM refeicao WHERE id_usuario = ? AND data_solicitacao = ? AND id_status_ref = 1 AND motivo_cancelamento IS NULL";
            $result = $this->executeQuery($query, [$idUser, $dataAtual], "is");
            return $result && $result[0]['total'] > 0;
        }

        public function cancelarReserva($idUser, $motivo) {
            $query = "UPDATE refeicao SET motivo_cancelamento = ?, id_status_ref = 2 WHERE id_usuario = ? AND motivo_cancelamento IS NULL ORDER BY data_solicitacao DESC LIMIT 1";
            return $this->executeUpdate($query, [$motivo, $idUser], "si");
        }


        public function excluirCardapio() {
            $query = "UPDATE cardapio SET ind_excluido = 1 WHERE ind_excluido = 0";
            $result = $this->executeQuery($query);

            return $result !== false;
        }

        public function getIdByMatricula($matricula)
        {
            $query = "SELECT id FROM usuario WHERE matricula = ?";
            $result = $this->executeQuery($query, [$matricula], 'i');

            return $result == null ?  false : $result[0]['id'] ;
        }

        public function getTagsCardapio() {
            $query = "SELECT * FROM tags_cardapio";
            return $this->executeQuery($query);
        }

        // criar tag
        public function criarTag($nome, $tipo, $gluten, $lactose) {
            $query = "INSERT INTO tags_cardapio (nome, tipo, gluten, lactose) VALUES (?, ?, ?, ?)";
            return $this->executeQuery($query, [$nome, $tipo, $gluten, $lactose], 'ssii');
        }

        public function salvarCardapioSemana($dados) {
            $success = [];

            // print_r($dados); exit();
            // Verifica se o array está vazio   

            foreach ($dados as $linha) {
                $dia = $linha['dia'] ?? '';
                $data_refeicao = $linha['data_refeicao'] ?? '';
                $proteina = $linha['Proteína'] ?? '';
                $principal = $linha['Principal'] ?? '';
                $sobremesa = $linha['Sobremesa'] ?? '-';
                
                $sucesso = $this->criarCardapio($dia, $data_refeicao, $proteina, $principal, $sobremesa);
                $sucess[] = $sucesso;
            }

            // print_r($success); exit();
            return in_array(false, $sucess, true) ? false : true;
        }

        // Busca por refeições confirmadas e totaliza os registros por data
        public function getRefeicoesConfirmadas() {
            $sql = "
            SELECT 
                DATE(data_solicitacao) AS data,
                COUNT(*) AS registros
            FROM 
                refeicao
            WHERE 
                motivo_cancelamento IS NULL
                AND id_status_ref = 1
            GROUP BY 
                DATE(data_solicitacao)
            ORDER BY 
                data
            ";

            $result = $this->executeQuery($sql);
            return $result ? $result : [];
        }

        // Cadastra cardápio no BD
        public function criarCardapio($dia, $data_refeicao, $proteina, $principal, $sobremesa) {
            $query = "INSERT INTO cardapio (dia, data_refeicao, proteina, principal, sobremesa) VALUES (?, ?, ?, ?, ?)";
            return $this->executeQuery($query, [$dia, $data_refeicao,$proteina, $principal, $sobremesa], 'sssss');
        }
    }
?>