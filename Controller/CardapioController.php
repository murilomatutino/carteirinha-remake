<?php
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
    }
?>