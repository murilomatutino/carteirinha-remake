<?php
    require_once __DIR__ . '/../Model/model.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    }
?>