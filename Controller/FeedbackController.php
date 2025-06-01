<?php
    require_once __DIR__ . '/../Model/model.php';

    class FeedbackController {
        public $model;
        public function __construct() {
            $this->model = new Model();
        }

        public function sendFeedback($nota, $idUser, $idCardapio) {
            return $this->model->adicionarFeedback($nota, $idUser, $idCardapio);
        }

        public function getFeedback() {
            return $this->model->getAllFeedback();
        }

        public function getFeedbackDetails($idCardapio) {
            return $this->model->getFeedbackDetails($idCardapio);
        }
    }
?>