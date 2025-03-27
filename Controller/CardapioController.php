<?php
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);
    require_once __DIR__ . '/../Model/model.php';

    class CardapioController {
        public $model;

        public function __construct() {
            $this->model = new Model();
        }

        public function getCardapio() {
            return $this->model->getCardapio();
        }

        public function getTime() {
            return $this->model->getTime();
        }

        public function hasRefeicao($idUser, $current_day) {
            return $this->model->hasRefeicao($idUser, $current_day);
        }

        public function hasTransferencia($idUser) {
            return $this->model->transferenciaIsActive($idUser);
        }

        public function getRefeicaoById($idUser) {
            return $this->model->getRefeicaoById($idUser);
        }
 
        public function getCardapioById($idCardapio) {
            return $this->model->getCardapioById($idCardapio);
        }

        public function processarReserva($idUser, $idJustificativa, $justificativa, $diaDaSemana) {
            date_default_timezone_set('America/Sao_Paulo');
            $idCardapio = $this->model->getIdCardapio($diaDaSemana);
            $statusRef = 1;
            $dataSolicitacao = date("Y-m-d");
            $horaSolicitacao = date("H:i:s");

            $result = $this->model->setMeal($idUser, $idCardapio, $statusRef, $idJustificativa, $dataSolicitacao, $horaSolicitacao, $justificativa);

            if ($result) {
                return ['status' => true, 'message' => 'Refeição agendada com sucesso!'];
            } else {
                return ['status'=> false, 'message'=> 'Houve um problema ao agendar a sua refeição. Por favor, tente novamente mais tarde!'];
            }
        }

        public function cancelarReserva($idUser, $motivo) {
            // Primeiramente, verificamos se a reserva existe e está ativa
            if ($this->model->isActive($idUser)) {
                if ($this->model->cancelarReserva($idUser, $motivo)) {
                    return ['status' => true, 'message' => 'Reserva cancelada com sucesso'];
                } else {
                    return ['status' => false, 'message' => 'Falha ao cancelar a reserva'];
                }
            } else {
                return ['status' => false, 'message' => 'Reserva não encontrada ou já foi cancelada'];
            }
        }
        
        public function transferirReserva($idUser, $motivo, $matriculaAlvo) {
            if ($this->model->isActive($idUser)) {
                if ($this->model->transferirReserva($idUser, $motivo, $matriculaAlvo)['success']) {
                    return ['status' => true, 'message' => 'Reserva transferida com sucesso'];
                } else {
                    return ['status' => false, 'message' => 'Falha ao transferir reserva'];
                }
            } else {
                return ['status' => false, 'message' => 'Reserva não encontrada!'];
            }
        }

        public function excluirCardapio() {
            if ($this->model->excluirCardapio()['success']) {
                return ['status' => true, 'message' => 'Cardápio excluído com sucesso!'];
            } else {
                return ['status' => false, 'message' => 'Falha ao excluir cardápio!'];
            }
        }
    }
?>