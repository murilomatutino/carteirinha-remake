<?php
    require_once __DIR__ . '/../Model/model.php';

    class FeedbackController {
        public $model;
        public function __construct() {
            $this->model = new Model();
        }

        public function sendFeedback($nota, $idUser) {
            return $this->model->adicionarFeedback($nota, $idUser, $idCardapio);
        }
    }
?>