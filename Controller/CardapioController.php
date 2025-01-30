<?php
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    require_once __DIR__ . '/../Model/model.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['operacao'])) {
            if ($_POST['operacao'] === 'cancelarReserva') {
                $idUser = $_POST['idUser'];
                $motivo = $_POST['motivo'];

                (new CardapioController)->cancelarReserva($idUser, $motivo);
            } else if ($_POST['operacao'] === 'transferirReserva') {
                $idUser = $_POST['idUser'];
                $motivo = $_POST['motivo'];
                $matricula = $_POST['matriculaAlvo'];

                (new CardapioController)->transferirReserva($idUser, $motivo, $matricula);
            }
        } else {
            $idJustificativa = 0;
            $justificativa = $_POST['justificativa'];
            $idUser = $_POST['idUser'];
            $diaDaSemana = $_POST['diaDaSemana'];

            if ($justificativa == "outro") {
                $idJustificativa = 4;
                $justificativa = $_POST["outro"];
            } else {
                switch ($justificativa) {
                    case "contra-turno": $idJustificativa = 1; break;
                    case "transporte": $idJustificativa = 2; break;
                    case "projeto": $idJustificativa = 3; break;
                }
                $justificativa = null;
            }
            
            (new CardapioController)->processarReserva($idUser, $idJustificativa, $justificativa, $diaDaSemana);
        }
    }

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

        public function processarReserva($idUser, $idJustificativa, $justificativa, $diaDaSemana) {
            date_default_timezone_set('America/Sao_Paulo');
            $idCardapio = $this->model->getIdCardapio($diaDaSemana);
            $statusRef = 1;
            $dataSolicitacao = date("Y-m-d");
            $horaSolicitacao = date("H:i:s");

            $result = $this->model->setMeal($idUser, $idCardapio, $statusRef, $idJustificativa, $dataSolicitacao, $horaSolicitacao, $justificativa);

            $reserva = "confirmada";
            if (!$result) { $reserva = "erro"; }

            header("Location: ../View/cardapio.php?reserva={$reserva}"); exit();
        }

        public function cancelarReserva($idUser, $motivo) {
            // Primeiramente, verificamos se a reserva existe e está ativa
            if ($this->model->isActive($idUser)) {
                if ($this->model->cancelarReserva($idUser, $motivo)) {
                    echo json_encode(['status' => 'success', 'message' => 'Reserva cancelada com sucesso']); exit();
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Falha ao cancelar a reserva']); exit();
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Reserva não encontrada ou já foi cancelada']); exit();
            }
        }
        

        public function transferirReserva($idUser, $motivo, $matriculaAlvo) {
            if ($this->model->isActive($idUser)) {
                if ($this->model->transferirReserva($idUser, $motivo, $matriculaAlvo)['success']) {
                    echo json_encode(['status' => 'success', 'message' => 'Reserva transferida com sucesso']); exit();
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Falha ao transferir reserva']); exit();
                }
            } else {
                echo json_encode(['status' => 'error', message => 'Reserva não encontrada!']); exit();
            }
        }
    }
?>