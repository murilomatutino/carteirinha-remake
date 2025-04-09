<?php
    require_once __DIR__ . '/../Model/model.php';

    class FeedbackController {
        public $model;
        public function __construct() {
            $this->model = new Model();
        }

        public function sendFeedback($nota, $idUser) {
            if($this->model->adicionarFeedback($nota, $idUser)) {
                return ['success' => true, 'message' => 'sucesso']; 
            } else {
                return ['success' => false, 'message' => 'erro']; 
            }
        }
    }
?>