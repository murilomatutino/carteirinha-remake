<?php
    require_once __DIR__ . '/../Model/model.php';

    class FeedbackController {
        public $model;
        public function __construct() {
            $this->model = new Model();
        }

        public function sendFeedback($nota, $idUser) {
            $response = $this->model->adicionarFeedback($nota, $idUser);

            if ($response['status']) {
                return ['status'=> true, 'message'=> $respone['message']];
            } else {
                return ['status'=> false, $respone['message']];
            }
        }
    }
?>